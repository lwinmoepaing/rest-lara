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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
|----------
| Buyers
|----------
*/
Route::resource('buyer', 'Buyer\BuyerController')->only(['index', 'show']);

/*
|----------
| Categories
|----------
*/
Route::resource('categories', 'Category\CategoryController')->except(['create', 'edit']);

/*
|----------
| Products
|----------
*/
Route::resource('buyer', 'Buyer\BuyerController')->only(['index', 'show']);

/*
|----------
| Sellers
|----------
*/
Route::resource('buyer', 'Buyer\BuyerController')->only(['index', 'show']);

/*
|----------
| Transactions
|----------
*/
Route::resource('buyer', 'Buyer\BuyerController')->only(['index', 'show']);

/*
|----------
| Users
|----------
*/
Route::resource('buyer', 'Buyer\BuyerController')->only(['index', 'show']);
