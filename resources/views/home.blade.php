@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          @include('components.session-alerts')

          You are logged in!

          <hr/>

          @include('components.domains', [ 'user' => Auth::user() ])

          @if (Auth::user()->hasVerifiedEmail())
            <hr/>

            @include('components.domain-form')
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
