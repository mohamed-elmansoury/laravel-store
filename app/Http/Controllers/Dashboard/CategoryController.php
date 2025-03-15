<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->query('name');

        $status = $request->query('status');

        $categories = Category::with('parent')
            // select('image', 'id', 'parent_id', 'name', 'status', 'created_at')
            ->withCount([
                'products as product_number' => function ($query) {
                    $query->where('status', 'active');
                }
            ])

            ->when($name, fn($query) => $query->where('name', 'like', "%$name%"))
            ->when($status, fn($query) => $query->where('status', $status))
            ->paginate(2);



        return view('dashboard.Categories.index', compact('categories'));
    }
    //Image	ID	Name	Parent	Created At	

    public function create()
    {
        $parents = Category::all();
        return view('dashboard.Categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('dashboard.Categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }
        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }




        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // } 

        //move the last code to force delete reason for using Trash and force delete    

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully!');
    }



    protected function uploadImage(Request $request)
    {

        if (!$request->hasFile('image')) {
            return '';
        }
        $file = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $file->storeAs('uploads', $filename, 'public');
        return 'uploads/' . $filename;
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(2);

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category restored!');
    }



    public function forceDelete($id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);

        $category->forceDelete();


        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category delete for restored!');
    }
}
