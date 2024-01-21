<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        //
        return view("products.index", compact("products"))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'productName' => 'required|unique:products',
            'productPrice' => 'required | numeric | min:0 | not_in:0',
            'productProducer' => 'required',
            'productDescription' => 'required',
        ],
        [
            'productName.required' => 'يجب إدخال أسم المنتج'
        ]);

        // add to database
        Product::create($request->all());

        return redirect()->route("products.index")->with("success", "Product has been Added !!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return view("products.show", compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view("products.edit", compact("product"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        // validation
        $request->validate([
            'productName' => 'required | unique:products,productName,'.$product->id,
            'productPrice' => 'required | numeric | min:0 | not_in:0',
            'productProducer' => 'required',
            'productDescription' => 'required',
        ]);

        // add to database
        $product->update($request->all());

        return redirect()->route("products.index")->with("success", "Product has been updated !!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return redirect()->route("products.index")->with("success", "Product has been Deleted !!!");
    }
}
