<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/usersss', function (Request $request) {
//     return $request->user();
// });

Route::get('users','UserController@index');
Route::post('user','UserController@store');
Route::post('login','UserController@login');

Route::get('products/{id}','ProductController@index');
Route::get('product/{id}','ProductController@show');
Route::get('productsByUser/{id}','ProductController@showByUser');
Route::post('product','ProductController@store');

Route::get('productImages/{id}','ProductPictureController@index');
Route::post('productImage/{id}','ProductPictureController@store');

Route::get('tradeOffers/{user_id}','TradeController@offers');
Route::get('tradeOffer/{user_id}','TradeController@offer');
Route::get('tradeRequests/{user_id}','TradeController@requests');
Route::get('tradeRequest/{user_id}','TradeController@request');
Route::post('tradeOffer','TradeController@store');

Route::post('setTradeStatus','TradeController@updateStatus');
Route::post('updateTradeLocation','TradeController@updateLocation');

