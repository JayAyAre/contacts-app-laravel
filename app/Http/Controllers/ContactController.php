<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
  //php artisan make:controller -m Contact ContactController
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('contacts.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      "name" => ["required","string"],
      "phone_number" => ["required","digits:9"],
      "email" => ["required","email","unique:contacts,email"],
      "age" => ["required","min:18","numeric","max:255"],
      ]);

    Contact::create([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'age' => $request->age
    ]);

    session()->flash('success', 'Your contact has been added');
    return redirect()->route("home");
  }

  /**
   * Display the specified resource.
   */
  public function show(Contact $contact)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Contact $contact)
  {
    return view('contacts.edit', compact('contact'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Contact $contact)
  {
    $data = $request->validate([
        "name" => ["required","string"],
        "phone_number" => ["required","digits:9"],
        "email" => ["required","email",Rule::unique('contacts')->ignore($contact->id)],
        "age" => ["required","min:18","numeric","max:255"],
    ]);

    $contact->update($data);
    session()->flash('success', 'Your contact has been modified');
    return redirect()->route("home");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Contact $contact)
  {
    //
  }
}
