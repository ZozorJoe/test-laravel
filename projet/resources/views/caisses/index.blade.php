@extends('layouts.app')

@php $total = 0; @endphp

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Liste des Caisses</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('caisse.create') }}" class="btn btn-sm btn-outline-secondary">Ajouter</a>
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

    <div class="row m-4">
        <div class="col-4">
            <p class="h3 mb-4">Total Caisse</p>
            <span class="h1 mt-4" id="resultat-tab">30€</span>
        </div>
        <div class="col-8">
            <p class="h3">Operations du jour</p>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">type mouvement</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($caisses as $caisse)
                        @php
                            $total += totalTab($caisse->total_billets, $caisse->total_pieces, $caisse->total_centimes);
                        @endphp

                        <tr>
                            <td scope="row">{{ convertToDMY($caisse->date) }}</td>
                            <td>{{ $caisse->valeur }}</td>
                            <td>{{ totalTab($caisse->total_billets, $caisse->total_pieces, $caisse->total_centimes) }}</td>
                            <td>
                                {{-- <a href="{{ route('caisse.show', ['caisse' => $caisse->id]) }}"
                                    class="btn btn-secondary me-1">Voir</a> --}}
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="4">Aucune donnée n'est encore enregistree dans la base de donnees</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <input type="hidden" id="resultat-affichage" value="{{ $total }}">
        </div>
    </div>
@endsection
