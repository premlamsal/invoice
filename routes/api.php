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

//retriving settings
Route::get('settings','SettingsController@index');

//updating settings
Route::put('settings','SettingsController@update');


//List estimates
Route::get('estimates','EstimateController@index');

//List single estimate
Route::get('estimate/{id}','EstimateController@show');

//Create new estimate
Route::post('estimate','EstimateController@store');

//Update estimate
Route::put('estimate','EstimateController@update');

//Delete estimate
Route::delete('estimate/{id}','EstimateController@destroy');


//List Units
Route::get('units','UnitController@index');

//List single Unit
Route::get('units/{id}','UnitController@show');

//Add Unit
Route::post('unit','UnitController@store');

//Update Unit
Route::put('unit','UnitController@update');

//Delete Unit
Route::delete('unit/{id}','UnitController@destroy');

