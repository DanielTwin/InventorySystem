<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;

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

Route::middleware('auth:api')->group( function () {

	//Users
	Route::get('/users', [UserController::class, 'index']);
	Route::get('/users/{id}', [UserController::class, 'show']);
	Route::get('/users/promote/{id}', [UserController::class, 'promote']);
	Route::put('/users', [UserController::class, 'update']);
	Route::delete('/users/{id}', [UserController::class, 'destroy']);

	//categories
	Route::get('/categories', [CategorieController::class, 'index']);
	Route::get('/categories/{id}', [CategorieController::class, 'show']);
	Route::post('/categories', [CategorieController::class, 'store']);
	Route::put('/categories/{id}', [CategorieController::class, 'update']);
	Route::delete('/categories/{id}', [CategorieController::class, 'destroy']);

	//Products
	Route::get('/products', [ProductController::class, 'index']);
	Route::get('/products/{id}', [ProductController::class, 'show']);
	Route::post('/products', [ProductController::class, 'store']);
	Route::put('/products/{id}', [ProductController::class, 'update']);
	Route::delete('/products/{id}', [ProductController::class, 'destroy']);

	//images
	Route::get('/images/product/{product_id}', [ImageController::class, 'index']);
	Route::get('/images/{id}', [ImageController::class, 'show']);
	Route::post('/images', [ImageController::class, 'store']);
	Route::put('/images/{id}', [ImageController::class, 'update']);
	Route::get('/images/promote/{id}', [ImageController::class, 'promote']);
	Route::delete('/images/{id}', [ImageController::class, 'destroy']);

	//invoices
	Route::get('/invoices', [InvoiceController::class, 'index']);
	Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
	Route::post('/invoices', [InvoiceController::class, 'store']);

	Route::get('/roles', [RoleController::class, 'index']);
});

//Register and login
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register',[LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);
