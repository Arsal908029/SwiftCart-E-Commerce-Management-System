<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;

Route::get('/', fn() => view('welcome'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products',               [AdminController::class, 'products']);
    Route::get('/products/create',        [AdminController::class, 'createProduct']);
    Route::post('/products/store',        [AdminController::class, 'storeProduct']);
    Route::get('/products/{product}/edit',[AdminController::class, 'editProduct']);
    Route::put('/products/{product}',     [AdminController::class, 'updateProduct']);
    Route::delete('/products/{product}',  [AdminController::class, 'deleteProduct']);
    Route::get('/orders',   [AdminController::class, 'orders']);
    Route::post('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
    Route::get('/payments', [AdminController::class, 'payments']);
    Route::get('/sales',    [AdminController::class, 'sales']);
    Route::get('/feedbacks',[AdminController::class, 'feedbacks'])->name('admin.feedbacks');
    Route::delete('/feedbacks/{feedback}',[AdminController::class, 'deleteFeedback'])->name('admin.feedbacks.delete');
});

// Buyer Routes
Route::prefix('buyer')->middleware(['auth','buyer'])->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    Route::get('/products',        [BuyerController::class, 'products']);
    Route::post('/cart/add',       [BuyerController::class, 'addToCart']);
    Route::get('/cart',            [BuyerController::class, 'viewCart']);
    Route::get('/cart/remove/{id}',[BuyerController::class, 'removeFromCart']);
    Route::get('/checkout',  [BuyerController::class, 'checkoutForm']);
    Route::post('/checkout', [BuyerController::class, 'checkout']);
    Route::get('/orders',    [BuyerController::class, 'myOrders']);
    Route::get('/orders/{id}/track', [BuyerController::class, 'trackOrder'])->name('buyer.track');
    Route::get('/profile',           [BuyerController::class, 'profile'])->name('buyer.profile');
    Route::post('/profile/update',   [BuyerController::class, 'updateProfile'])->name('buyer.profile.update');
    Route::post('/profile/password', [BuyerController::class, 'updatePassword'])->name('buyer.profile.password');
    Route::get('/feedback',          [BuyerController::class, 'feedbackForm'])->name('buyer.feedback');
    Route::post('/feedback',         [BuyerController::class, 'submitFeedback'])->name('buyer.feedback.submit');
});
