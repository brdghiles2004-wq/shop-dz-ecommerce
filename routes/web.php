<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UsersController;


// ─── Public ───────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// ─── Panier (guest + auth) ────────────────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

// ─── Checkout (guest + auth) ──────────────────────────────
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// ─── Auth required ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ─── Admin ────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ─── Support (guest + auth) ───────────────────────────────
Route::get('/support', [SupportController::class, 'index'])->name('support.index');
Route::post('/support', [SupportController::class, 'store'])->name('support.store');
Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    // ← zid hada
    Route::get('/support', [AdminSupportController::class, 'index'])->name('support.index');
    Route::get('/support/{ticket}', [AdminSupportController::class, 'show'])->name('support.show');
    Route::put('/support/{ticket}/reply', [AdminSupportController::class, 'reply'])->name('support.reply');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::get('/support', [AdminSupportController::class, 'index'])->name('support.index');
    Route::get('/support/{ticket}', [AdminSupportController::class, 'show'])->name('support.show');
    Route::put('/support/{ticket}/reply', [AdminSupportController::class, 'reply'])->name('support.reply');

    // ← zid hadou
    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

Route::get('/test-cloudinary', function () {
    dd(env('CLOUDINARY_URL'));
});
require __DIR__.'/auth.php';