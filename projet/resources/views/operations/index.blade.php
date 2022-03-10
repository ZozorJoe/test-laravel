@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Liste des Operations</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('operation.create') }}" class="btn btn-sm btn-outline-secondary">Ajouter</a>
            </div>
        </div>
    </div>


    <div class="row my-2">
        @if (session('ok'))
            <x-back.alert type='success' title="{!! session('ok') !!}">
            </x-back.alert>
        @endif
        @if (session('ko'))
            <x-back.alert type='danger' title="{!! session('ko') !!}">
            </x-back.alert>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Valeur</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($operations as $operation)
                    <tr>
                        <td>{{ $operation->valeur }}</td>
                        <td>
                            <a href="{{ route('operation.show', ['operation' => $operation->id]) }}"
                                class="btn btn-secondary me-1">Voir</a>
                            <a href="{{ route('operation.edit', ['operation' => $operation->id]) }}"
                                class="btn btn-secondary me-1">Editer</a>
                            <a href="{{ route('operation.destroy', ['operation' => $operation->id]) }}" class="btn btn-danger" onclick="event.preventDefault();
                                document.getElementById('destroy-form-{{$operation->id}}').submit();">Supprimer</a>

                            <form id="destroy-form-{{$operation->id}}"
                                action="{{ route('operation.destroy', ['operation' => $operation->id]) }}" method="POST"
                                class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>No operations</p>
                @endforelse
            </tbody>
        </table>


    </div>
@endsection
