<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Http\Requests\StoreFacturaRequest;
use App\Http\Requests\UpdateFacturaRequest;
use App\Models\Cabezafactura;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Inertia::render('Facturas/index');
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
    public function facturasapipublic()
    {
        //
       // $facturas = Factura::all();
        $facturas = DB::table('cabezafacturas')
        ->leftJoin('facturas', 'facturas.id', '=', 'cabezafacturas.factura_id')
        ->leftJoin('users', 'users.id', '=', 'cabezafacturas.cliente_id')
        ->get();
        return response()->json([
            $facturas
        ], Response::HTTP_OK);
    }
    public function facturasapi()
    {
        $facturas = DB::table('facturas')
        ->leftJoin('productos', 'productos.id', '=', 'facturas.producto_id')
        ->select('facturas.id AS idfactura', 'productos.pro_nombre', 'facturas.fac_cantidad', 'facturas.fac_valor')
        ->get();
        return response()->json([
            $facturas
        ], Response::HTTP_OK);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFacturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFacturaRequest $request)
    {
        //
    }
    public function comprar(Request $request)
    {
        //  dd($request);

        $request->validate([
            'venta_producto' => 'required|max:100',
            'venta_cantidad' => 'required|max:100',
        ]);
        $fecha = new Carbon();
        $user = Auth::user()->id;
        $ventas = new Factura([
            'producto_id' => $request->input('venta_producto'),
            'fac_cantidad' => $request->input('venta_cantidad'),
            'fac_valor' => $request->input('venta_precio'),
        ]);
        $ventas->save();
        $pro = Factura::latest('id')->first();
        if ($ventas->exists == true) {
            $cabeza = new Cabezafactura([
                'factura_id' => $pro->id,
                'cab_fecha' => $fecha,
                'cliente_id' => $user,
                'cab_total' => $request->input('venta_precio')
            ]);
            $cabeza->save();
            return response()->json(['success' => 'Guardado correctamente.', 'ejecucion' => true]);
        }else{
            return response()->json(['error' => 'No se pudo guardar.', 'ejecucion' => false]);

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFacturaRequest  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFacturaRequest $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->delete();
        return response()->json(['success' => 'Eliminado correctamente.', 'ejecucion' => true]);
    }
}
