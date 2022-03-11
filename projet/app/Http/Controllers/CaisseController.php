<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Http\Requests\StoreCaisseRequest;
use App\Http\Requests\UpdateCaisseRequest;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caisses = DB::table('nrh_caisses')
            ->leftJoin('nrh_operations', 'nrh_operations.id', '=', 'nrh_caisses.operation_id')
            ->leftJoin('nrh_billets', 'nrh_billets.caisse_id', '=', 'nrh_caisses.id')
            ->leftJoin('nrh_pieces', 'nrh_pieces.caisse_id', '=', 'nrh_caisses.id')
            ->leftJoin('nrh_centimes', 'nrh_centimes.caisse_id', '=', 'nrh_caisses.id')
            ->select(
                'nrh_caisses.*',
                'nrh_operations.valeur',
                DB::raw('SUM(nrh_billets.nominal * nrh_billets.quantite) AS total_billets'),
                DB::raw('SUM(nrh_pieces.nominal * nrh_pieces.quantite) AS total_pieces'),
                DB::raw('SUM(nrh_centimes.nominal * nrh_centimes.quantite) AS total_centimes')
            )
            ->orderBy('date', 'desc')
            ->groupBy(['operation_id', DB::raw("DATE_FORMAT(date, '%d-%m-%Y')")])
            ->get();

       #dd($caisses);


        # $caisses = Caisse::orderBy('updated_at', 'desc')->get();

        return view('caisses.index', compact('caisses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $billets = collect([0, 5, 10, 20, 50, 100, 200, 500]);
        $pieces = collect([0, 1, 2]);
        $centimes = collect([0, 1, 2, 5, 10, 20, 50]);
        $operations = Operation::all()->pluck('valeur', 'id');

        return view('caisses.form', compact('operations', 'billets', 'pieces', 'centimes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCaisseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaisseRequest $request)
    {
        # true | false | 
        # dd($request->isMethod('post'), $request->ajax(), $request->all());

        $inputs = $request->except('_method', '_token', 'date');

        #$inputs['date'] = date('Y-m-d' , strtotime($request->date));
        $inputs['date'] = convertToYmd($request->date);

        /** create caisse */
        $caisse = Caisse::create($inputs);

        /** create billet */
        $billets = [];

        if (isset($request->billets_nominal) && isset($request->billets_quantite)) {

            foreach ($request->billets_nominal as $key => $value) {
                array_push(
                    $billets,
                    ['nominal' => $value, 'quantite' => $request->billets_quantite[$key]]
                );
            }

            $caisse->billets()->createMany($billets);
        }

        /** create piece */
        $pieces = [];

        if (isset($request->pieces_nominal) && isset($request->pieces_quantite)) {

            foreach ($request->pieces_nominal as $key => $value) {
                array_push(
                    $pieces,
                    ['nominal' => $value, 'quantite' => $request->pieces_quantite[$key]]
                );
            }

            $caisse->pieces()->createMany($pieces);
        }

        /** create centime */
        $centimes = [];

        if (isset($request->centimes_nominal) && isset($request->centimes_quantite)) {

            foreach ($request->centimes_nominal as $key => $value) {
                array_push(
                    $centimes,
                    ['nominal' => $value, 'quantite' => $request->centimes_quantite[$key]]
                );
            }

            $caisse->centimes()->createMany($centimes);
        }

        if (isset($inputs['ajax'])) {
            return response()->json([
                'caisse' => $caisse,
                'sucess' => true,
            ]);
        }

        return back()->with('ok', 'Enregistrement succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function show(Caisse $caisse)
    {
        return view('caisses.show', compact('caisse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function edit(Caisse $caisse)
    {
        $billets = collect([0, 5, 10, 20, 50, 100, 200, 500]);
        $pieces = collect([0, 1, 2]);
        $centimes = collect([0, 1, 2, 5, 10, 20, 50]);
        $operations = Operation::all()->pluck('valeur', 'id');;
        return view('caisses.form', compact('caisse', 'operations', 'billets', 'pieces', 'centimes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCaisseRequest  $request
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCaisseRequest $request, Caisse $caisse)
    {
        # true | false | 
        dd($request->isMethod('put'), $request->ajax(), $request->all());

        $inputs = $request->except('_method', '_token', 'date');

        #$inputs['date'] = date('Y-m-d' , strtotime($request->date));
        $inputs['date'] = convertToYmd($request->date);

        /** create caisse */
        $caisse->update($inputs);

        /** create billet */
        $billets = [];

        if (isset($request->billets_nominal) && isset($request->billets_quantite)) {

            foreach ($request->billets_nominal as $key => $value) {
                array_push(
                    $billets,
                    ['nominal' => $value, 'quantite' => $request->billets_quantite[$key]]
                );
            }

            $caisse->billets()->dissociate();

            dd('billets');

            $caisse->billets()->createMany($billets);
        }

        /** create piece */
        $pieces = [];

        if (isset($request->pieces_nominal) && isset($request->pieces_quantite)) {

            foreach ($request->pieces_nominal as $key => $value) {
                array_push(
                    $pieces,
                    ['nominal' => $value, 'quantite' => $request->pieces_quantite[$key]]
                );
            }

            $caisse->pieces()->createMany($pieces);
        }

        /** create centime */
        $centimes = [];

        if (isset($request->centimes_nominal) && isset($request->centimes_quantite)) {

            foreach ($request->centimes_nominal as $key => $value) {
                array_push(
                    $centimes,
                    ['nominal' => $value, 'quantite' => $request->centimes_quantite[$key]]
                );
            }

            $caisse->centimes()->createMany($centimes);
        }

        if (isset($inputs['ajax'])) {
            return response()->json([
                'caisse' => $caisse,
                'sucess' => true,
            ]);
        }

        return back()->with('ok', 'Enregistrement succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caisse $caisse)
    {
        try {
            $caisse->delete();
        } catch (\Exception $e) {
            return back()->with('ko', 'Suppression error');
        }

        return back()->with('ok', 'Suppression succès');
    }
}
