<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List invoices
Route::get('invoices','InvoiceController@index');

//List single invoice
Route::get('invoice/{id}','InvoiceController@show');

//Create new invoice
Route::post('invoice','InvoiceController@store');

//Update invoice
Route::put('invoice','InvoiceController@update');

//Delete invoice
Route::delete('invoice/{id}','InvoiceController@destroy');

//Create new Customer
Route::post('customer','CustomerController@store');

//Search Customer
Route::post('customer_search','CustomerController@search');


