@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            @isset($operation)
                Edit
            @else
                Ajout
            @endisset operation</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('operation.index') }}" class="btn btn-sm btn-outline-secondary">Retour</a>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <x-back.validation-errors :errors="$errors" />

        @if (session('ok'))
            <x-back.alert type='success' title="{!! session('ok') !!}">
            </x-back.alert>
        @endif
    </div>

    <form method="POST"
        action="{{ Route::currentRouteName() === 'operation.edit'? route('operation.update', $operation->id): route('operation.store') }}"
        class="row g-3 mx-auto">

        @if (Route::currentRouteName() === 'operation.edit')
            @method('PUT')
        @endif

        @csrf

        <input type="hidden" id="input-slug" name="cle" value="" required>

        <div class="col-md-4">
            <label for="valeur" class="form-label">Valeur</label>
            <input type="text" class="form-control input-valeur {{ $errors->has('valeur') ? ' is-invalid' : '' }}" id="valeur"
                value="{{ old('valeur', isset($operation) ? $operation->valeur : '') }}" name="valeur" required>
            @if ($errors->has('valeur'))
                <div class="invalid-feedback">
                    {{ $errors->first('valeur') }}
                </div>
            @else
                <div class="valid-feedback">
                    Looks good!
                </div>
            @endif
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Valider</button>
        </div>
    </form>
@endsection
