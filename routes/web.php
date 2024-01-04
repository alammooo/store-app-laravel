<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::redirect('/', '/product');
Route::get('/product', [ProductController::class, 'index']);
Route::get('/export-products', [ProductController::class, 'export'])->name('export.products');

Route::middleware(['auth'])->name('product.')->group(function () {
    Route::get('/product/create', [ProductController::class, 'create'])->name('create');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::post('/product', [ProductController::class, 'store'])->name('store');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('delete');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->middleware('auth');
    Route::put('/profile', [UserController::class, 'update'])->middleware('auth')->name('update');
});
