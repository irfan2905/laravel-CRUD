<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//-----------------LOGIN--------------------

Auth::routes();

Route::get('/', function () {
    return Redirect::to('login.login');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('layout.default');
    });

    $this->get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');

//------------------HOME--------------------

    /*
      Route::get('/', function () {
      return view('layout.default');
      });
     * 
      Auth::routes();

      Route::get('/home', 'HomeController@index')->name('home'); */

//-----------------PASSPORT-----------------

    Route::get('/passport/create', function () {
        return view('passport/add');
    });

    Route::get('/passports', 'PassportController@index');
    Route::get('/passports/create', 'PassportController@create');
    Route::post('/passports', 'PassportController@store');
    Route::get('/passports/{id}', 'PassportController@edit');
    Route::put('/passports', 'PassportController@update');
    Route::delete('/passports', 'PassportController@destroy');

//-----------------PRODUCT-----------------

    Route::get('/product/create', function () {
        return view('product/add_product');
    });

    
    Route::get('/product', 'ProductController@index');
    Route::get('/product/create', 'ProductController@add_product');
    Route::post('/product', 'ProductController@store');
    Route::get('/product/{id}', 'ProductController@edit');
    Route::put('/product', 'ProductController@update');
    Route::delete('/product', 'ProductController@destroy');
    Route::get('/add-to-cart/{id}', 'ProductController@getAddToCart');
    Route::get('/cart', 'ProductController@getCart');
    Route::get('/checkout', 'ProductController@getCheckout');
    Route::post('/checkout', 'ProductController@postCheckout');
    
});

/*
  Route::get('/product', 'ProductController@index');
  Route::get('/product/add_product', 'ProductController@add_product');
  Route::post('/product','ProductController@store');
  Route::get('/product/{id}', 'ProductController@edit');
  Route::put('/product', 'ProductController@update');
  Route::delete('/product','ProductController@destroy');
 * 
 */




//-----------------PAYPAL-----------------

Route::get('paypal', function () {
    return redirect('paywithpaypal');
});

Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal', 'uses' => 'AddMoneyController@payWithPaypal',));
Route::post('paypal', array('as' => 'addmoney.paypal', 'uses' => 'AddMoneyController@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status', 'uses' => 'AddMoneyController@getPaymentStatus',));

/*Route::get('payment-status',array('as'=>'payment.status','uses'=>'AddMoneyController@paymentInfo'));
Route::get('payment',array('as'=>'payment','uses'=>'AddMoneyController@payment'));

Route::get('payment-cancel', function () {
    return 'Payment has been canceled';
});*/

//-----------------SOCIALITE-----------------

Route::get('auth/{provider}', 'SocialAuthController@redirect');
Route::get('auth/{provider}/callback', 'SocialAuthController@callback');