<div id="domain-accordion">
  @forelse ($user->domains() as $name => $domain)
    @include('components.domain', [
      'domain'        => $domain,
      'name'          => $name,
      'friendlyName'  => str_replace('.', '-', $name),
      'first'         => $loop->first,
    ])
  @empty
    No domains found.
  @endforelse
</div>