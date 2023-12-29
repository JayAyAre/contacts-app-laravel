<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  //php artisan tinker to test querys

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $contacts = auth()->user()->contacts()->orderBy('created_at', 'desc')->paginate(6);
    return view('home', compact('contacts'));
  }

  public function welcome()
  {
    return view('welcome');
  }

}
