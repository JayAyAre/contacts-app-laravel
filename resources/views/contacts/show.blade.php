@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Contact info</div>
          <div class="card-body">
            <div class="d-flex justify-content-center">
              <img class="profile_picture" src="{{Storage::url($contact->profile_picture)}}">
            </div>
            <p>Name: {{ $contact->name }}</p>
            <p>Phone:<a class="text-decoration-none text-light"
                        href="tel:{{ $contact->phone_number }}"> {{ $contact->phone_number }}</a></p>
            <p>Email:<a class="text-decoration-none text-light"
                        href="mailto:{{ $contact->email }}"> {{ $contact->email }}</a></p>
            <p>Age: {{ $contact->age }}</p>
            <a>Created at: {{ $contact->created_at }}<br></a>
            @if($contact->updated_at!=null)
              <a><br>Updated at: {{ $contact->updated_at }}<br></a>
            @endif
            <div class="d-flex justify-content-center">
              <a href="{{route("contacts.edit",$contact->id)}}" class="btn btn-secondary me-2">Edit contact</a>
              <form action="{{route("contacts.destroy",$contact->id)}}" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger">Delete contact</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
