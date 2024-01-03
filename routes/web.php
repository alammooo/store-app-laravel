<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::redirect('/', '/product');

Route::get('/auth', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/auth', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/create', [ProductController::class, 'create'])->middleware('auth');
Route::post('/product', [ProductController::class, 'store'])->name('product.store')->middleware('auth');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->middleware('auth');
Route::patch('/product/{id}', [ProductController::class, 'update'])->middleware('auth');

Route::get('/profile', function () {
    return view('./profile/index');
})->middleware('auth');
