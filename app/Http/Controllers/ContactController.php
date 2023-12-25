<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ContactController extends Controller
{
  //php artisan make:controller -m Contact ContactController
  //php artisan tinker to test querys
  /*  protected $rules = [
        "name" => ["required","string"],
        "phone_number" => ["required","digits:9"],
        "email" => ["required","email","unique:contacts,email"],
        "age" => ["required","min:18","numeric","max:255"],
    ];*/

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $this->authorize('viewAny', Contact::class);
    $contacts = auth()->user()->contacts()->get();
    return view('contacts.index', compact('contacts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $this->authorize('create', Contact::class);
    return view('contacts.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreContactRequest $request)
  {
    $this->authorize('create', Contact::class);
    //($request->hasFile('profile_picture')) && $data['profile_picture'] = $request->file('profile_picture')->store('public/profiles');


    $data = $request->validated();
    if($request->hasFile('profile_picture')){
      $path = $request->file('profile_picture')->store('profiles', 'public');
      $data['profile_picture'] = $path;
    }
    auth()->user()->contacts()->create($data);

    return redirect('home')->with('alert',
        ['message' => 'Yours contacts has been shown',
            'type' => 'info']);
  }

  /**
   * Display the specified resource.
   */
  public function show(Contact $contact)
  {
    $this->authorize('view', $contact);
    return view('contacts.show', compact('contact'));
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
    //$rules = $this->rules;
    //$rules['email'] = ["required", "email", Rule::unique('contacts')->ignore($contact->id)];
    //$data = $request->validate($rules);

    $rules = $request->validate([
        "name" => ["required", "string"],
        "phone_number" => ["required", "digits:9"],
        "email" => ["required", "email", Rule::unique('contacts')->ignore($contact->id)],
        "age" => ["required", "min:18", "numeric", "max:255"],
        "profile_picture" => ["image", "mimes:jpeg,png,jpg,gif,svg"],
    ]);

    if($request->hasFile('profile_picture')){
      $path = $request->file('profile_picture')->store('profiles', 'public');
      $rules['profile_picture'] = $path;
    }

    $contact->update($rules);
    session()->flash('alert',
        ['message' => 'Your contact ' . $contact->name . ' has been updated',
            'type' => 'success']);
    return redirect()->route("home");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Contact $contact)
  {
    $this->authorize('delete', $contact);
    session()->flash('alert',
        ['message' => 'Your contact ' . $contact->name . ' has been deleted',
            'type' => 'info']);
    $contact->delete();
    return back();
  }
}
