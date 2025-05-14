<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AIRecommenderController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about', function () {
    return view('about');
})->name('about');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get( '/login', [UserController::class, 'loginView']);
    Route::get('/signup', [UserController::class, 'registerView'])->name('signup');
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login', [UserController::class,'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Book Routes
|--------------------------------------------------------------------------
*/
Route::get('/books', [BookController::class, 'index'])->name('product.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/
// Public order routes (accessible to both guests and authenticated users)
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::get('/orders/create/{book}', [OrderController::class, 'createForSingleBook'])->name('orders.create.single');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/success', function () {
    return view('orders.success');
})->name('orders.success');

// Protected order routes (only for authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Favorite Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{book}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'remove'])->name('favorites.remove');
});

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/update/{bookId}', [CartController::class, 'update'])->name('cart.update');

/*
|--------------------------------------------------------------------------
| Google Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| Account Settings Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [UserController::class, 'edit'])->name('account.settings');
    Route::post('/account/settings', [UserController::class, 'update'])->name('account.settings.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Log::info('Admin routes accessed');

    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books Management
    Route::resource('books', AdminBookController::class);

    // Users Management
    Route::resource('users', AdminUserController::class);

    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

    // Route to display the "Create New Category" form
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

    // Route to handle the form submission for creating a new category
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});

/*
|--------------------------------------------------------------------------
| Chat Routes
|--------------------------------------------------------------------------
*/
// Route to display the chat interface
Route::get('/chat', function () {
    return view('AIChat.index'); // Ensure this matches the path to your Blade file
})->name('chat.index');

// Route to handle API requests to the Open AI API
Route::post('/ai/recommend', [AIRecommenderController::class, 'recommend'])->name('ai.recommend');


