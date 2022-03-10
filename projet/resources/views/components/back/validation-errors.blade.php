@props(['errors'])

@if($errors->any())
    <x-back.alert
        type='danger'
        icon='ban'
        title="Oups! Un problème est survenu.">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-back.alert>
@endif
