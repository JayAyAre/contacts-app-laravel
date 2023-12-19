@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Contact info</div>
          <div class="card-body">
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
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
