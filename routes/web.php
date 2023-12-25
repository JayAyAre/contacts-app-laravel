<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

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
Route::get('/billing-portal', function (Request $request) {
  return $request->user()->redirectToBillingPortal();
});
Route::get('/checkout', function (Request $request) {
  return $request->user()
      ->newSubscription('default', config('stripe.price_id'))
      ->checkout();
});

Route::get('/', fn() => auth()->check() ? redirect('/home') : redirect('/welcome'));

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');

Route::resource('contacts', ContactController::class);


//Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
//Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
//Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
//Route::put('/contacts/{contact}/', [ContactController::class, 'update'])->name('contacts.update');
//Route::get('/contacts/{contact}/', [ContactController::class, 'show'])->name('contacts.show');
//Route::delete('/contacts/{contact}/', [ContactController::class, 'destroy'])->name('contacts.destroy');
//Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');

