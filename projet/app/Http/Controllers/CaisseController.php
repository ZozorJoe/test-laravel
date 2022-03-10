<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Http\Requests\StoreCaisseRequest;
use App\Http\Requests\UpdateCaisseRequest;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caisses = Caisse::orderBy('updated_at', 'desc')->get();
        return view('caisses.index', compact('caisses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('caisses.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCaisseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaisseRequest $request)
    {
        dd($request->isMethod('post'), $request->ajax());

        $inputs = $request->except('_method', '_token');
        # $inputs['coefficient'] = floatval($request->coefficient);

        Caisse::create($inputs);

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
        return view('caisses.form', compact('caisse'));
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
        $inputs = $request->except('_method', '_token');
        
        $caisse->update($inputs);

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
        }catch (\Exception $e) {
            return back()->with('ko', 'Suppression error');
        }

        return back()->with('ok', 'Suppression succès');
    }
}
