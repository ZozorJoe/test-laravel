@props(['type', 'icon' => 'check', 'title' => ''])

<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @if($title !== '') <h5>{{ $title }}</h5>  @endif
    {{ $slot }}
</div>
