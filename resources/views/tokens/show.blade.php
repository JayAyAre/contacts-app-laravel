@extends('layouts.app')

@section('content')
  <div class="container pt-4 p-3">
    <div class="col-md-8 mx-auto">
      <div class="card car-body text-center pt-2 pb-2">
        <p >This is your API token, copy it before leaving this page.</p>
        <p class="text-info">{{ $token->plainTextToken }}</p>
      </div>
    </div>
  </div>
@endsection
