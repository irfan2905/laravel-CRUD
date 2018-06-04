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

//-----------------PASSPORT-----------------

Route::resource('/product','ProductController');
