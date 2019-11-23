<div class="card">
  <div class="card-header" id="header-{{ $friendlyName }}">
    <h5 class="mb-0">
      <button
        class="btn btn-link p-0 {{ $first ? '' : 'collapsed' }}" 
        data-toggle="collapse" 
        data-target="#body-{{ $friendlyName }}" 
        aria-expanded="true" 
        aria-controls="body-{{ $friendlyName }}"
      >
        {{ $name }}
      </button>
    </h5>
  </div>

  <div
    id="body-{{ $friendlyName }}" 
    class="collapse  {{ $first ? 'show' : '' }}" 
    aria-labelledby="header-{{ $friendlyName }}" 
    data-parent="#domain-accordion"
  >
    <div class="card-body">
      @foreach ($domain as $key => $value)
        <div class="row">
          <div class="col-4">{{ $key }}</div>
          <div class="col-8">{{ $value }}</div>
        </div>
      @endforeach
    </div>
  </div>
</div>