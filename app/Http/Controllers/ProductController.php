<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\Cart;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Session;
use Redirect;

//use Input;
/** All Paypal Details class * */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

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
       $products->price = $request->post('price');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        //return view('product.edit_product');
        $products = Product::find($id);
        //var_dump('edit');exit;
        //$categories = Category::all();
        //return view('product.edit_product',compact('products', $products, $id));
        return view('product.edit_product',compact('products','id'));
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
        $products->price = $request->price;
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
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new cart($oldCart);
        $cart->add($product, $product->id);
        
        $request->session()->put('cart', $cart);
        return redirect('product');
    }
    
    
    public function getCart() {
        if (!Session::has('cart')) {
            return view ('product');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        return view ('shopping_cart.shop', ['products'=> $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
    
    public function getCheckout() {
        if (!Session::has('cart')) {
            return view ('product');
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        $total = $cart->totalPrice;
        //return redirect('addmoney.paypal', ['totalPrice' => $totalPrice ]);
        return redirect()->action('addmoney/paypal', ['totalPrice' => $totalPrice ]);
    }
}