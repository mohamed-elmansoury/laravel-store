<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'store', 'tags')->latest()->paginate(15);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create', [
            'categories' => Category::all(),
            'stores' => Store::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'], // شلنا gt:price من هنا
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'description' => ['nullable', 'string', 'max:300'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'tags' => ['nullable', 'array'],
        ]);
        
        $validator->after(function ($validator) use ($request) {
            if (
                $request->filled('compare_price') &&
                $request->filled('price') &&
                $request->compare_price <= $request->price
            ) {
                $validator->errors()->add('compare_price', 'يجب أن يكون السعر قبل الخصم أكبر من السعر الحالي.');
            }
        });
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        


        $data = $request->except('tags');

        $data['image'] = $this->handleImageUpload($request);

        $product = Product::create($data);


        $tags = collect($request->input('tags', []))->map(function ($tag) {
            return Tag::firstOrCreate(
                ['name' => $tag],
                ['slug' => Str::slug($tag)]
            )->id;
        });

        $product->tags()->sync($tags);

        return redirect()->route('dashboard.products.index')->with('success', 'تم إضافة المنتج بنجاح!');
    }



    public function edit(Product $product)
    {
        return view('dashboard.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'stores' => Store::all(),
            'tags' => Tag::all(),
            'selectedTags' => $product->tags->pluck('name')->toArray(), // التاجز الخاصة بالمنتج الحالي
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'], // شلنا gt:price من هنا
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'description' => ['nullable', 'string', 'max:300'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'tags' => ['nullable', 'array'],
        ]);
        
        $validator->after(function ($validator) use ($request) {
            if (
                $request->filled('compare_price') &&
                $request->filled('price') &&
                $request->compare_price <= $request->price
            ) {
                $validator->errors()->add('compare_price', 'يجب أن يكون السعر قبل الخصم أكبر من السعر الحالي.');
            }
        });
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except('tags');

        $data['image'] = $this->handleImageUpload($request, $product->image);

        $product->update($data);

        $tags = collect($request->input('tags', []))->map(function ($tag) {
            return Tag::firstOrCreate(
                ['name' => $tag],
                ['slug' => Str::slug($tag)]
            )->id;
        });

        $product->tags()->sync($tags);

        return redirect()->route('dashboard.products.index')->with('success', 'تم تحديث المنتج بنجاح!');
    }

    public function destroy(Product $product)
    {

        $product->delete();

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }




        return redirect()->route('dashboard.products.index')->with('success', 'تم حذف المنتج بنجاح!');
    }

    private function handleImageUpload(Request $request, $existingImage = null)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = Str::slug($request->input('name')) . '-' . time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $image->storeAs('products', $imageName, 'public');

            if ($existingImage) {
                Storage::disk('public')->delete($existingImage);
            }

            return $imagePath;
        }

        return $existingImage;
    }
}
