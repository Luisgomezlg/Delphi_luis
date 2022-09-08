<?php

namespace App\Http\Controllers;

use App\Models\Cabezafactura;
use App\Http\Requests\StoreCabezafacturaRequest;
use App\Http\Requests\UpdateCabezafacturaRequest;
use Illuminate\Http\Request;

class CabezafacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCabezafacturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCabezafacturaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cabezafactura  $cabezafactura
     * @return \Illuminate\Http\Response
     */
    public function show(Cabezafactura $cabezafactura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cabezafactura  $cabezafactura
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabezafactura $cabezafactura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCabezafacturaRequest  $request
     * @param  \App\Models\Cabezafactura  $cabezafactura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCabezafacturaRequest $request, Cabezafactura $cabezafactura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cabezafactura  $cabezafactura
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $cabeza = Cabezafactura::find($request->id);
        $cabeza->delete();
        return response()->json(['success' => 'Eliminado correctamente.', 'ejecucion' => true]);
    }
}
