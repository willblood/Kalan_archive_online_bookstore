<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class,'index'])->name('welcome');

//Route for Authentication and Register View
Route::get('/login-form', [UserController::class,'loginView'])->name('login');
Route::get('/sign-up-form', [UserController::class,'registerView'])->name('signup');

//UserController
Route::post('/logout', [UserController::class, 'logout'])
->middleware('auth')
->name('logout');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

//BookController
Route::get('/books', [BookController::class,'index'])->name('product.index');
Route::get('/books/{id}', [BookController::class,'show'])->name('product.show');
