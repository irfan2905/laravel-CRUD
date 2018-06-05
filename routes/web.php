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

Route::get('/', function () {
    return view('layout.default');
});

//-----------------PASSPORT-----------------

Route::get('/passport/create', function () {
    return view('passport/add');
});

Route::get('/passports','PassportController@index');
Route::get('/passports/create','PassportController@create');
Route::post('/passports','PassportController@store');
Route::get('/passports/{id}','PassportController@edit');
Route::put('/passports/','PassportController@update');
Route::delete('/passports','PassportController@destroy');

//-----------------PRODUCT-----------------

Route::get('/product', function () {
  return view('product.product');
});

Route::get('/product/create', function () {
  return view('product/add_product');
});

/*Route::group(['prefix' => 'product',  'middleware' => 'auth'], function(){
  Route::get('/', 'ProductController@index');
  Route::post('/', 'ProductController@store');
  Route::get('/{id}', 'ProductController@edit');
  Route::put('/', 'ProductController@update');
  Route::delete('/', 'ProductController@destroy');
});*/

Route::get('/product', 'ProductController@index');
Route::get('/product/add_product', 'ProductController@add_product');
Route::post('/product','ProductController@store');
Route::get('/product/{id}', 'ProductController@edit');
Route::put('/product/', 'ProductController@update');
Route::delete('/product','ProductController@destroy');
