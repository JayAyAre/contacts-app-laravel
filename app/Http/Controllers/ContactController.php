<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        return view('contact');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(is_null($request->name)) {
            session()->flash('error', 'Name is required');
            return back()->withErrors([
            //return Response::redirectTo('/contacts/create')->withErrors([
                'name' => 'Name is required',
            ]);
        }else if (is_null($request->phone_number)) {
            session()->flash('error', 'Phone number is required');
            return back()->withErrors([
                'phone_number' => 'Phone number is required',
            ]);
        }

        Contact::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);
        session()->flash('success', 'Your contact has been added');
        return redirect('/home');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
