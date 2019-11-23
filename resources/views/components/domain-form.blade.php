<form action="/dyndns/setup" method="POST">
  @method('POST')
  @csrf

  <div class="form-group row mb-0">
    <label for="domain" class="col-2 col-form-label">Add Domain</label>
    <div class="col-6">
      <input type="text" class="form-control" id="domain" name="domain" placeholder="example.com">
    </div>
    <a
      class="btn btn-primary mb-2 col-2"
      target="_blank"
      onclick="this.href='{{ \App\DynDNS\Connect::getActivationUrl('<domain>') }}'.replace('<domain>', document.getElementById('domain').value); return true;"
    >
      Activate
    </a>
  </div>

  <div class="form-group row mb-0">
    <label for="accessCode" class="col-2 col-form-label">Access Code</label>
    <div class="col-6">
      <input type="text" class="form-control" id="accessCode" name="accessCode" placeholder="c1192e36-614a-48c4-b168-605b6f2da6d8">
    </div>
    <button type="submit" class="btn btn-primary mb-2 col-2">Setup DynDNS</button>
  </div>
</form>