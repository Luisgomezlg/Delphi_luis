<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productos = Producto::all();
        //dd($temas);
        return Inertia::render('Welcome', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productos()
    {
        //
        $productos = Producto::all();
        //dd($temas);
        return Inertia::render('ProductosAuth/index', compact('productos'));
    }
    public function productosapipublic()
    {
        //
        $productos = Producto::all();
        return response()->json([
            $productos
        ], Response::HTTP_OK);
    }
    public function productosapi()
    {
        $productos = Producto::all();
        return response()->json([
            $productos
        ], Response::HTTP_OK);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function crearproducto(Request $request)
    {
        
         $request->validate([
            'pro_nombre' => 'required|max:100',
            'pro_precio' => 'required|max:100',
        ]);
        $fecha = new Carbon();
        // $user = Auth::user()->id;


        $productos = new Producto([
            'pro_nombre' => $request->input('pro_nombre'),
            'pro_precio' => $request->input('pro_precio'),
        ]);
  
        $productos->save();
        
        if ($productos->exists == true) {

            return response()->json(['success' => 'Guardado correctamente.', 'ejecucion' => true]);
        } else {
            return response()->json(['error' => 'No se pudo guardar.', 'ejecucion' => false]);
        }
    }
    public function store(StoreProductoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto_id = Producto::find($id);
        return Inertia::render('ProductosAuth/edit', compact('producto_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductoRequest  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->id);
        $producto = Producto::find($request->id);
        $producto->update($request->all());
        return response()->json(['success' => 'Actualizado correctamente.', 'ejecucion' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $producto = Producto::find($request->id);
        $producto->delete();
        return response()->json(['success' => 'Eliminado correctamente.', 'ejecucion' => true]);
    }
}
