@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Liste des Caisses</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('caisse.create') }}" class="btn btn-sm btn-outline-secondary">Ajouter</a>
            </div>
        </div>
    </div>

    <div class="row m-4">
        <div class="col-4">
            <p class="h3 mb-4">Total Caisse</p>
            <span class="h1 mt-4">30€</span>
        </div>
        <div class="col-8">
            <p class="h3">Operations du jour</p>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Retraits</th>
                        <th scope="col">Ajouts</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>
                            <button class="btn btn-secondary">Editer</button>
                            <button class="btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>
                            <button class="btn btn-secondary">Editer</button>
                            <button class="btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
