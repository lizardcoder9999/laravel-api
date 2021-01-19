<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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




//Users routes


Route::post('v1/users/login',[LoginController::class, 'login']);

Route::post('v1/users/register',[RegisterController::class,'register']);

Route::post('v1/users/forgotpass',[UserController::class,'forgotPasswordAction']);

Route::delete('v1/users/deletereset',[UserController::class,'deletePasswordResetToken']);


//Product Routes

Route::post('v1/products/add',[ProductController::class,'addProduct']);

Route::get('v1/products/all',[ProductController::class,'allProducts']);

Route::delete('v1/products/delete/{id}',[ProductController::class,'deleteProduct']);

Route::put('v1/products/update/{id}',[ProductController::class,'updateProduct']);