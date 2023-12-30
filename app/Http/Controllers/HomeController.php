<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
    $this->authorize('viewAny', Contact::class);

    Cache::forget('home'.auth()->user()->id);
    $contacts = Cache::remember('home'.auth()->user()->id,
        now()->addMinutes(30),
        fn () => auth()->user()->contacts()->paginate(10));
    return view('home', compact('contacts'));
  }

  public function welcome()
  {
    return view('welcome');
  }

}
