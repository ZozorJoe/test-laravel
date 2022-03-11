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

    <div id="alert-ajax" class="row my-2 d-none">

        <div id="alert-type" class="alert alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p id="alert-content"></p>
        </div>
    </div>

    <form method="POST"
        action="{{ Route::currentRouteName() === 'caisse.edit' ? route('caisse.update', $caisse->id) : route('caisse.store') }}"
        class="m-4" id="form-caisse">

        @if (Route::currentRouteName() === 'caisse.edit')
            @method('PUT')
        @endif

        @csrf

        <!-- Entree de fond de caisse -->
        <div class="card">
            <div class="card-header"> Entree de fond de caisse </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div>
                            <label for="operation_id" class="form-label">Type d'operation</label>
                            <select class="form-select" id="operation_id" name="operation_id"
                                aria-label="Type d'operation" required>
                                @foreach ($operations as $cle => $valeur)
                                    <option @if ($cle === old('operation_id', isset($caisse) ? $caisse->operation_id : '')) selected @endif value="{{ $cle }}">
                                        {{ $valeur }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- @dd($caisse->date, gettype($caisse->date)) --}}

                        <div class="mt-1">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" name="date" id="date" class="form-control" autocomplete="false"
                                data-toggle="datepicker" required
                                value="{{ old('date', isset($caisse) ? convertToDMY($caisse->date) : '') }}">
                        </div>

                        <div class="mt-1">
                            <label for="note" class="form-label">Note</label>
                            <textarea name="note" id="note"
                                class="form-control"
                                required>{{ old('note', isset($caisse) ? $caisse->note : '') }}</textarea>

                            {{-- {{ $errors->has('note') ? ' is-invalid' : '' }}
                                
                                @if ($errors->has('note'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('note') }}
                                </div>
                            @else
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <span class="h1" id="caisse">
                            {{ isset($caisse) ? total($caisse->billets, $caisse->pieces, $caisse->centimes) : '0' }}
                            €</span>
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
                        @if (isset($caisse))
                            @foreach ($caisse->billets as $billet)
                                <div class="row  @if (!$loop->first) mt-1 @endif ">
                                    <div class="col-5">
                                        <select class="form-select input-billet nominal-billet" name="billets_nominal[]">
                                            @foreach ($billets as $item)
                                                <option @if ($item === $billet->nominal) selected @endif
                                                    value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <input type="number" value="1" step="1"
                                            class="form-control input-billet quantite-billet" name="billets_quantite[]"
                                            value="{{ $billet->quantite }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row after-billet">
                                <div class="col-5">
                                    <label for="billets_nominal_0" class="form-label">Nominal</label>
                                    <select class="form-select input-billet nominal-billet" id="billets_nominal_0"
                                        name="billets_nominal[]">
                                        @foreach ($billets as $billet)
                                            <option @if ($loop->first) selected @endif
                                                value="{{ $billet }}">{{ $billet }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="billets_quantite_0" class="form-label">Quantite</label>
                                    <input type="number" value="1" step="1"
                                        class="form-control input-billet quantite-billet " id="billets_quantite_0"
                                        name="billets_quantite[]">
                                </div>
                            </div>
                        @endif

                        <div class="row mt-1 clone-billets d-none">
                            <div class="col-5">
                                <select class="form-select clone input-billet nominal-billet"
                                    name="billets_nominal_clone[]">
                                    @foreach ($billets as $billet)
                                        <option @if ($loop->first) selected @endif
                                            value="{{ $billet }}">{{ $billet }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-billet quantite-billet" name="billets_quantite_clone[]">
                            </div>
                            <button type="button" data-id="billets_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-billet text-center">X</button>
                        </div>
                        <div id="billet-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1"
                            id="billet">{{ isset($caisse) ? sousTotalBloc($caisse->billets) : '0' }} €</span>
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
                        @if (isset($caisse))
                            @foreach ($caisse->pieces as $piece)
                                <div class="row  @if (!$loop->first) mt-1 @endif ">
                                    <div class="col-5">
                                        <select class="form-select input-piece nominal-piece" name="pieces_nominal[]">
                                            @foreach ($pieces as $item)
                                                <option @if ($item === $piece->nominal) selected @endif
                                                    value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <input type="number" value="1" step="1"
                                            class="form-control input-piece quantite-piece" name="pieces_quantite[]"
                                            value="{{ $piece->quantite }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-5">
                                    <label for="pieces_nominal_0" class="form-label">Nominal</label>
                                    <select class="form-select input-piece nominal-piece" id="pieces_nominal_0"
                                        name="pieces_nominal[]">
                                        @foreach ($pieces as $piece)
                                            <option @if ($loop->first) selected @endif
                                                value="{{ $piece }}">{{ $piece }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="pieces_quantite_0" class="form-label">Quantite</label>
                                    <input type="number" value="1" step="1" class="form-control input-piece quantite-piece "
                                        id="pieces_quantite_0" name="pieces_quantite[]">
                                </div>
                            </div>
                        @endif

                        <div class="row mt-1 clone-pieces d-none">
                            <div class="col-5">
                                <select class="form-select clone input-piece nominal-piece" name="pieces_nominal_clone[]">
                                    @foreach ($pieces as $piece)
                                        <option @if ($loop->first) selected @endif
                                            value="{{ $piece }}">{{ $piece }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-piece quantite-piece" name="pieces_quantite_clone[]">
                            </div>
                            <button type="button" data-id="pieces_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-piece text-center">X</button>
                        </div>
                        <div id="piece-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1"
                            id="piece">{{ isset($caisse) ? sousTotalBloc($caisse->pieces) : '0' }} €</span>
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
                        @if(isset($caisse))
                            @foreach ($caisse->centimes as $centime)
                                <div class="row @if (!$loop->first) mt-1 @endif ">
                                    <div class="col-5">
                                        <select class="form-select input-centime nominal-centime" name="centimes_nominal[]">
                                            @foreach ($centimes as $item)
                                                <option @if ($item === $centime->nominal) selected @endif
                                                    value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <input type="number" value="1" step="1"
                                            class="form-control input-centime quantite-centime" name="centimes_quantite[]"
                                            value="{{ $centime->quantite }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-5">
                                    <label for="centimes_nominal_0" class="form-label">Nominal</label>
                                    <select class="form-select input-centime nominal-centime" id="centimes_nominal_0"
                                        name="centimes_nominal[]">
                                        @foreach ($centimes as $centime)
                                            <option @if ($loop->first) selected @endif
                                                value="{{ $centime }}">{{ $centime }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="centimes_quantite_0" class="form-label">Quantite</label>
                                    <input type="number" value="1" step="1"
                                        class="form-control input-centime quantite-centime " id="centimes_quantite_0"
                                        name="centimes_quantite[]">
                                </div>
                            </div>
                        @endif


                        <div class="row mt-1 clone-centimes d-none">
                            <div class="col-5">
                                <select class="form-select clone input-centime nominal-centime"
                                    name="centimes_nominal_clone[]">
                                    @foreach ($centimes as $centime)
                                        <option @if ($loop->first) selected @endif
                                            value="{{ $centime }}">{{ $centime }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5">
                                <input type="number" value="1" step="1"
                                    class="form-control clone input-centime quantite-centime"
                                    name="centimes_quantite_clone[]">
                            </div>
                            <button type="button" data-id="centimes_nominal_id_clone"
                                class="btn btn-danger col-1 btn-delete-centime text-center">X</button>
                        </div>
                        <div id="centime-end"></div>
                    </div>

                    <div class="col-4 text-end">
                        <span class="h1"
                            id="centime">{{ isset($caisse) ? sousTotalBloc($caisse->centimes) : '0' }} €</span>
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
