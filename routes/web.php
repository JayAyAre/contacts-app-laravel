<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactShareController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
|$contact be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/billing-portal', [StripeController::class, 'billingPortal'])->name('billing-portal');
Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/free-trial-end', [StripeController::class, 'freeTrialEnd'])->name('free-trial-end');

Route::get('/', fn() => auth()->check() ? redirect('/home') : redirect('/welcome'));

Auth::routes();
Route::middleware(['auth', 'subscription'])->group(function () {
  Route::get('/home', [HomeController::class, 'index'])->name('home');
  Route::resource('contacts', ContactController::class);
  Route::resource('contact-shares', ContactShareController::class)->except(['show', 'edit', 'update']);
});


Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');

//Route::middleware(['auth','subscription'])->resource('contacts', ContactController::class);

//Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
//Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
//Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
//Route::put('/contacts/{contact}/', [ContactController::class, 'update'])->name('contacts.update');
//Route::get('/contacts/{contact}/', [ContactController::class, 'show'])->name('contacts.show');
//Route::delete('/contacts/{contact}/', [ContactController::class, 'destroy'])->name('contacts.destroy');
//Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');

