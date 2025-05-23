<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GiftCardController;
use App\Models\Order;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/about', function () {
    return view('about.index');
})->name('about');

Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Home Page Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Menu Routes
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/category/{category:slug}', [MenuController::class, 'category'])->name('menu.category');
    Route::get('/item/{item:slug}', [MenuController::class, 'show'])->name('menu.item');
});

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout Routes
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.payment-intent');
});

// Gift Card Routes
Route::prefix('gift-cards')->group(function () {
    Route::get('/', [GiftCardController::class, 'index'])->name('gift-cards.index');
    Route::get('/purchase', [GiftCardController::class, 'showPurchaseForm'])->name('gift-cards.purchase');
    Route::post('/purchase', [GiftCardController::class, 'purchase'])->name('gift-cards.process');
    Route::get('/validate/{code}', [GiftCardController::class, 'validateCode'])->name('gift-cards.validate');
});

// Order Receipt
Route::get('/order/print/{order}', function (Order $order) {
    return view('orders.print', compact('order'));
})->name('orders.print');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// Events routes
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::post('/events/inquiry', [EventsController::class, 'inquiry'])->name('events.inquiry');
