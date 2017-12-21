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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::resource('/home', 'CartController');
Route::post('/home', 'CartController@store')->name('addProductToCart');
Route::post('/home/{card_id}', 'CartController@emptyCart')->name('emptyCart');