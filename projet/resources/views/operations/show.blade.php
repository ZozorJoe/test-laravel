@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Operation</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('operation.index') }}" class="btn btn-sm btn-outline-secondary">Retour</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <tbody>
                @if ($operation)
                    <tr>
                        <td>Valeur</td>
                        <td>{{ $operation->valeur }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2">No operation</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
@endsection
