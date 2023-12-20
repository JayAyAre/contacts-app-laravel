<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  //php artisan tinker to test querys
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $contacts = auth()->user()->contacts()->get();
    return view('home', compact('contacts'));
  }

  public function welcome()
  {
    return view('welcome');
  }

}
