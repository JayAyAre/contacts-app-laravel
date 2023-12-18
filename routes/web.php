<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

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

Route::get('/contact', fn() => Response::view('contact'));

Route::post('/contact', function (Request $request) {
    return Response::json([
        'success' => true
    ]);
});

Route::get('/change-password', fn() => Response::view('change-password'));

Route::post('/change-password', function (Request $request) {
       if (auth()->check()){
           return response("Password Changed to: {$request->get('password')}", 200);
       }else {
           return response("Not Authorized,401");
   }
});
