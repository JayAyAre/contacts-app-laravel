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
              <a class = "text-decoration-none text-light" href="{{route("contacts.show",$contact->id)}}">
                <h3 class="card-title text-capitalize">{{$contact->name}}</h3>
              </a>
              <p class="m-2"><strong>Phone:</strong> {{ $contact->phone_number}}</p>
              <p class="m-2"><strong>Email:</strong> {{ $contact->email }}</p>
              <p class="m-2"><strong>Age:</strong> {{ $contact->age }}</p>
              <a href="{{route("contacts.edit",$contact->id)}}" class="btn btn-secondary">Edit contact</a>
              <form action="{{route("contacts.destroy",$contact->id)}}" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger">Delete contact</button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-md-4 mx-auto">
          <div class="card car-body text-center">
            <p>No contacts</p>
            <a href="{{route("contacts.create")}}" class="btn btn-primary">Add contact</a>
          </div>
        </div>
  @endforelse

@endsection
