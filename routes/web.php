<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController; // Ajoutez cette ligne si vous créez le contrôleur

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page À propos
Route::get('/about', function () {
    return view('about');
})->name('about');

// Catalogue produits
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Catégories
Route::get('/categories', [ProductController::class, 'categories'])->name('categories.index');
Route::get('/categories/{category:slug}', [ProductController::class, 'category'])->name('categories.show');

// Panier (authentification requise)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout (authentification requise)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

// Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Commandes (authentification requise)
Route::middleware(['auth', 'verified'])->group(function () {
    // Si vous avez un contrôleur OrderController
    // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Sinon, vous pouvez utiliser une closure temporaire
    Route::get('/orders', function () {
        return view('orders.index'); // Assurez-vous que la vue existe
    })->name('orders.index');
});

// Authentification
require __DIR__ . '/auth.php';
