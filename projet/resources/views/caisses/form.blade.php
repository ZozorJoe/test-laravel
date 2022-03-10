@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            @isset($caisse)
                Edit
            @else
                Ajout
            @endisset caisse</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('caisse.index') }}" class="btn btn-sm btn-outline-secondary">Retour</a>
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

    <form class="m-4" id="form-caisse">

        <!-- Entree de fond de caisse -->
        <div class="card">
            <div class="card-header"> Entree de fond de caisse </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div>
                            <label for="type_operation" class="form-label">Type d'operation</label>
                            <select class="form-select" id="type_operation" name="type_operation"
                                aria-label="Type d'operation">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="mt-1">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" name="date" id="date" class="form-control" autocomplete="false"
                                data-toggle="datepicker">
                        </div>

                        <div class="mt-1">
                            <label for="note" class="form-label">Note</label>
                            <textarea name="note" id="note" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <span class="h1" id="caisse">0 €</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billets -->
        <div class="card mt-4">
            <div class="card-header"> Billets </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="row after-billet">
                            <div class="col-5">
                                <label for="billets_nominal_0" class="form-label">Nominal</label>
                                <select class="form-select input-billet nominal-billet" id="billets_nominal_0"
                                    name="billets_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="billets_quantite_0" class="form-label">Quantite</label>
                                <input type="number" value="1" step="1" class="form-control input-billet quantite-billet "
                                    id="billets_quantite_0" name="billets_quantite[]">
                            </div>
                        </div>

                        <div class="row mt-1 clone-billets d-none">
                            <div class="col-5">
                                <select class="form-select clone input-billet nominal-billet" name="billets_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-billet quantite-billet" name="billets_quantite[]">
                            </div>
                            <button type="button" data-id="billets_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-billet text-center">X</button>
                        </div>
                        <div id="billet-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1" id="billet">0 €</span>
                    </div>
                </div>

                <button type="button" id="btn-ajout-billet" class="btn btn-secondary my-1">Ajouter</button>
            </div>
        </div>

        <!-- Pieces -->
        <div class="card mt-4">
            <div class="card-header"> Pieces </div>
            <div class="card-body">
                <div class="row">
                    <div id="zone-piece-sample" class="col-8">
                        <div class="row">
                            <div class="col-5">
                                <label for="pieces_nominal_0" class="form-label">Nominal</label>
                                <select class="form-select input-piece nominal-piece" id="pieces_nominal_0"
                                    name="pieces_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="pieces_quantite_0" class="form-label">Quantite</label>
                                <input type="number" value="1" step="1" class="form-control input-piece quantite-piece "
                                    id="pieces_quantite_0" name="pieces_quantite[]">
                            </div>
                        </div>

                        <div class="row mt-1 clone-pieces d-none">
                            <div class="col-5">
                                <select class="form-select clone input-piece nominal-piece" name="pieces_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-piece quantite-piece" name="pieces_quantite[]">
                            </div>
                            <button type="button" data-id="pieces_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-piece text-center">X</button>
                        </div>
                        <div id="piece-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1" id="piece">0 €</span>
                    </div>
                </div>

                <button type="button" id="btn-ajout-piece" class="btn btn-secondary my-1">Ajouter</button>
            </div>
        </div>

        <!-- Centimes -->
        <div class="card mt-4">
            <div class="card-header"> Centimes </div>
            <div class="card-body">
                <div class="row">
                    <div id="zone-centime-sample" class="col-8">
                        <div class="row">
                            <div class="col-5">
                                <label for="centimes_nominal_0" class="form-label">Nominal</label>
                                <select class="form-select input-centime nominal-centime" id="centimes_nominal_0"
                                    name="centimes_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="centimes_quantite_0" class="form-label">Quantite</label>
                                <input type="number" value="1" step="1" class="form-control input-centime quantite-centime "
                                    id="centimes_quantite_0" name="centimes_quantite[]">
                            </div>
                        </div>

                        <div class="row mt-1 clone-centimes d-none">
                            <div class="col-5">
                                <select class="form-select clone input-centime nominal-centime" name="centimes_nominal[]">
                                    <option selected value="0">0</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-centime quantite-centime" name="centimes_quantite[]">
                            </div>
                            <button type="button" data-id="centimes_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-centime text-center">X</button>
                        </div>
                        <div id="centime-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1" id="centime">0 €</span>
                    </div>
                </div>

                <button type="button" id="btn-ajout-centime" class="btn btn-secondary my-1">Ajouter</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn-lg btn-primary mt-4 col-4">Enregistrer</button>
        </div>

    </form>
@endsection
