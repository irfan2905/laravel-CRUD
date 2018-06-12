<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $products)
    {
        //$categories = Category::all();
        $products = Product::paginate(5);
        return view("product.product", compact('products', $products));
        
        /*$products = \App\Product::paginate(5);


        return view('product.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);*/
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_product(Product $products)
    {   
        return view('product.add_product');
        //$categories = Category::all();
        //$products = Product::paginate(5);
        //return view("product.product", compact('products', $products));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $products = new Product;
       $products->name = $request->post('name');
       $products->detail = $request->post('detail');
       $image = $request->file('photo1');
       $destinationPath = base_path('/public');
       if (!$image->move($destinationPath, $image->getClientOriginalName())) {
         return 'Error saving the file.';
       }
       $products->photo1 = $image->getClientOriginalName();
       $products->save();
            return redirect('product')
                 ->with('success','Product created successfully.');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        $products = Product::all();
        return view('product.show',compact('products', $products));
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        //return view('product.edit_product');
        $products = Product::find($id);
        //$categories = Category::all();
        return view('product.edit_product',compact('products', $products, $id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request)
    {
        $products = Product::find($request->id);
        File::delete(base_path('public/'.$products->photo1));
        $products->name = $request->name;
        $products->detail = $request->detail;
        $image = $request->file('photo1');
        $destinationPath = base_path('/public');
        if (!$image->move($destinationPath, $image->getClientOriginalName())) {
         return 'Error saving the file.';
        }
        $products->photo1 = $image->getClientOriginalName();
        $products->save();
        return redirect('product')->with('success','Product created successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)

    {
      $products = Product::find($request->id);
      $image = $request->file('photo1');
      File::delete(public_path($products->photo1));
      $product = Product::find($request->id);
      $product->delete();
      return redirect('product');
    }
}