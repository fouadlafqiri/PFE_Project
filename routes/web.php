<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DeliveryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Test route for debugging product creation

Route::get('/' , [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/category/{id}', [ProductController::class, 'category'])->name('products.category');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Cart Routes (Guest & Authenticated)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])
    ->name('cart.coupon');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Order Success & Tracking
    Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');
    Route::get('/track', [OrderController::class, 'track'])->name('order.track');

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::post('/products/{product}', [ReviewController::class, 'store'])->name('store');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});


/*
|--------------------------------------------------------------------------
| News Routes
|--------------------------------------------------------------------------
*/

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard & Profile
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::middleware('admin')->group(function () {
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });

    Route::middleware('admin')->group(function () {
        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('/products/{id}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        Route::post('/products/{id}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');

        // Reviews
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [AdminReviewController::class, 'index'])->name('index');
            Route::post('/{review}/approve', [AdminReviewController::class, 'approve'])->name('approve');
            Route::post('/{review}/reject', [AdminReviewController::class, 'reject'])->name('reject');
            Route::post('/{review}/toggle', [AdminReviewController::class, 'toggle'])->name('toggle');
        });

        // Deliveries (admin only)
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('index');
            Route::get('/create', [DeliveryController::class, 'create'])->name('create');
            Route::post('/', [DeliveryController::class, 'store'])->name('store');
            Route::get('/{delivery}/edit', [DeliveryController::class, 'edit'])->name('edit');
            Route::put('/{delivery}', [DeliveryController::class, 'update'])->name('update');
            Route::delete('/{delivery}', [DeliveryController::class, 'destroy'])->name('destroy');
            Route::post('/assign-order', [DeliveryController::class, 'assignOrder'])->name('assign-order');
            Route::put('/order-deliveries/{orderDelivery}/status', [DeliveryController::class, 'updateDeliveryStatus'])->name('updateDeliveryStatus');
        });
    });

    // Orders (admin + livreur)
    Route::middleware('isAdminOrLivreur')->group(function () {
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
            Route::put('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
            Route::put('/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
            Route::delete('/{id}', [AdminOrderController::class, 'destroy'])->name('destroy')->middleware('admin');
            Route::get('/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('invoice')->middleware('admin');
        });
    });
});
