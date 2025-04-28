<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
//use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(CartRepository $cart) //for get
    {
        // $repository = new CartModelRepository;
        $items = $cart->get();

        return view('front.cart', [
            'cart' => $items,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));

        // $repository = new CartModelRepository;
        $cart->add($product, $request->post('quantity'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        $product = Product::findOrFail($request->post('product_id'));

        // $repository = new CartModelRepository;
        $cart->update($product, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart,string $id)
    {
        // $repository = new CartModelRepository;
        $cart->delete($id);
    }
}
