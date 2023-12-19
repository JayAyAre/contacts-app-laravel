<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ContactController extends Controller
{
  //php artisan make:controller -m Contact ContactController
  //php artisan tinker to test querys

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $contacts = auth()->user()->contacts()->get();
    return view('contacts.index', compact('contacts'));
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
    $data = $request->validate([
      "name" => ["required","string"],
      "phone_number" => ["required","digits:9"],
      "email" => ["required","email","unique:contacts,email"],
      "age" => ["required","min:18","numeric","max:255"],
      ]);
    auth()->user()->contacts()->create($data);
    session()->flash('success', 'Your contact has been added');
    return redirect()->route("home");
  }

  /**
   * Display the specified resource.
   */
  public function show(Contact $contact)
  {
    $this->authorize('view', $contact);
    $contacts = auth()->user()->contacts()->get();
    return view('contacts.show', compact('contacts'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Contact $contact)
  {
    $this->authorize('update', $contact);
    return view('contacts.edit', compact('contact'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Contact $contact)
  {
    $this->authorize('update', $contact);
    $data = $request->validate([
        "name" => ["required","string"],
        "phone_number" => ["required","digits:9"],
        "email" => ["required","email",Rule::unique('contacts')->ignore($contact->id)],
        "age" => ["required","min:18","numeric","max:255"],
    ]);
    auth()->user()->contacts()->update($data);
    session()->flash('success', 'Your contact has been modified');
    return redirect()->route("home");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Contact $contact)
  {
    $this->authorize('delete', $contact);
    $contact->delete();
    return redirect()->route("home");
  }
}
