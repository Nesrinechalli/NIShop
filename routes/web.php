<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Shop Routes (Public)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop', function() {
    return redirect()->route('shop.index');
})->name('shop');
Route::get('/shop/category/{category}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/product/{product}', [ShopController::class, 'show'])->name('shop.product.show');

// User Routes (Authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');
    
    // Cart Routes
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');
    Route::patch('/cart/update/{product}', [ShopController::class, 'updateCart'])->name('shop.cart.update');
    Route::delete('/cart/remove/{product}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');
    
    // Checkout Routes
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/place-order', [ShopController::class, 'placeOrder'])->name('shop.place-order');
    Route::get('/orders', [ShopController::class, 'orders'])->name('shop.orders');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'adminDashboard'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    
    // Categories Routes
    Route::resource('categories', AdminCategoryController::class);
    
    // Products Routes
    Route::resource('products', AdminProductController::class);
    
    // Orders Routes
    Route::resource('orders', AdminOrderController::class);
    Route::put('/orders/{order}/update-delivery-status', [AdminOrderController::class, 'updateDeliveryStatus'])->name('orders.update-delivery-status');
    
    // OpenAI Routes
    Route::prefix('openai')->name('openai.')->group(function () {
        Route::get('/ai-product-generator', [OpenAIController::class, 'showForm'])->name('generate');
        Route::post('/generate-product', [OpenAIController::class, 'generateProduct'])->name('generate-product');
        Route::post('/generate-image', [OpenAIController::class, 'generateImage'])->name('image');
        Route::post('/store', [OpenAIController::class, 'store'])->name('store');
    });
});