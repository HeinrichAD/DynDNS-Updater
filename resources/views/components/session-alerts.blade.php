@if (!Auth::user()->hasVerifiedEmail())
  <div class="alert alert-danger" role="alert">
    Your email address is not verified!<br>
    The functionality is limited.
  </div>
@endif

@if (session('status-log'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (session('status-log'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <pre>{{ session('status-log') }}</pre>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif