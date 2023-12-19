@extends('layouts.app')

@section('content')
  @if(session()->has('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
  <div class="container pt-4 pt-3">
    <div class="row">
      @forelse($contacts as $contact)
        <div class="col-md-4 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <h3 class="card-title text-capitalize">{{$contact->name}}</h3>
              <p class="m-2"><strong>Phone:</strong> {{ $contact->phone_number}}</p>
              <p class="m-2"><strong>Email:</strong> {{ $contact->email }}</p>
              <p class="m-2"><strong>Age:</strong> {{ $contact->age }}</p>
              <a href="{{route("contacts.edit",$contact->id)}}" class="btn btn-secondary">Edit contact</a>
              {{--<a href="{{route("contact.destroy")}}" class="btn btn-danger">Delete contact</a>
            --}}</div>
          </div>
        </div>
      @empty
        <div class="col-md-4 mx-auto">
          <div class="card car-body text-center">
            <p>No contacts</p>
            <a href="{{route("contact.create")}}" class="btn btn-primary">Add contact</a>
          </div>
        </div>
  @endforelse

@endsection
