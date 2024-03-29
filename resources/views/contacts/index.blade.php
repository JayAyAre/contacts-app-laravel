@extends('layouts.app')

@section('content')
  <div class="container">
    @forelse($contacts as $contact)
      <div class="d-flex justify-content-between bg-dark mb-3 rounded px-4 py-2">
        <div>
          <a href="{{route("contacts.show",$contact->id)}}">
              <img class="profile_picture" src="{{Storage::url($contact->profile_picture)}}">
          </a>
        </div>
        <div class="d-flex align-items-center">
          <p class="me-2 mb-0">Name: {{ $contact->name }}</p>
          <p class="me-2 mb-0 d-none d-md-block">Phone:<a
                href="tel:{{ $contact->phone_number }}"> {{ $contact->phone_number }}</a></p>
          <p class="me-2 mb-0 d-none d-md-block">Email:<a
                href="mailto:{{ $contact->email }}"> {{ $contact->email }}</a></p>
          <p class="me-2 mb-0">Age: {{ $contact->age }}</p>
          <a class="btn btn-secondary mb-0 me-2 p-1 px-2" href="{{route("contacts.edit",$contact->id)}}">
            <x-icon icon="pencil"></x-icon>
          </a>
          <form action="{{route("contacts.destroy",$contact->id)}}" method="POST">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger mb-0 p-1 px-2">
              <x-icon icon="trash"></x-icon>
            </button>
          </form>
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
    {{$contacts->links()}}
  </div>
@endsection
