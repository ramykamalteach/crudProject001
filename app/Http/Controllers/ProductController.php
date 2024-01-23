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
            'photo' => 'required|mimes:jpg,jpeg,png,svg'
        ],
        [
            'productName.required' => 'يجب إدخال أسم المنتج'
        ]);

        //
        $photo = $request->file("photo");
        $storedPhotoName = time() . $request->photo->getClientOriginalName();
        $request->photo = $storedPhotoName;

        $photo->move(public_path("productPhotos"), $storedPhotoName);

        // add to database
        /* Product::create($request->all()); */
        $product = new Product();
        $product->productName = $request->productName;
        $product->productPrice = $request->productPrice;
        $product->productProducer = $request->productProducer;
        $product->productDescription = $request->productDescription;
        $product->photo = $storedPhotoName;

        $product->save();

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
            'photo' => 'mimes:jpg,jpeg,png,svg'
        ]);

        if($request->photo != null) {  // form photo field is not empty
            unlink(public_path("productPhotos")."/".$product->photo);

            $photo = $request->file("photo");
            $storedPhotoName = time() . $request->photo->getClientOriginalName();
            /* $request->photo = $storedPhotoName; */
            $product->photo = $storedPhotoName;
            $photo->move(public_path("productPhotos"), $storedPhotoName);
        }

        // add to database
        $product->productName = $request->productName;
        $product->productPrice = $request->productPrice;
        $product->productProducer = $request->productProducer;
        $product->productDescription = $request->productDescription;

        $product->update();

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

        unlink(public_path("productPhotos")."/".$product->photo);

        $product->delete();

        return redirect()->route("products.index")->with("success", "Product has been Deleted !!!");
    }
}
