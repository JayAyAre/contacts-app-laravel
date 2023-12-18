<?php

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
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/contact/create', [App\Http\Controllers\ContactController::class, 'create'])
    ->name('contact.create');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])
    ->name('contact.store');

/*Route::get('/contact', fn() => Response::view('contact'));

Route::post('/contact', function (Request $request) {
    $data = $request->all();
    Contact::create($data);
  $contact = new \App\Models\Contact();
    $contact->name= $data['name'];
    $contact->phone_number= $data['phone_number'];
    $contact->save();
    return "Contact Saved";
});*/

