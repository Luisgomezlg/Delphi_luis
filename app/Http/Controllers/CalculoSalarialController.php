<?php

namespace App\Http\Controllers;

use App\Models\CalculoSalarial;
use App\Http\Requests\StoreCalculoSalarialRequest;
use App\Http\Requests\UpdateCalculoSalarialRequest;
use App\Models\Empleado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class CalculoSalarialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $empleados = Empleado::all();
        //dd($temas);
        return Inertia::render('CalculoSalarial/index', compact('empleados'));
    }
    
    public function salarios()
    {
        //
        $salarios = CalculoSalarial::all();
        return response()->json([
            $salarios
        ], Response::HTTP_OK);
    }
    public function empleadosapipublic()
    {
        //
        $empleados = Empleado::all();
        return response()->json([
            $empleados
        ], Response::HTTP_OK);
    }
    public function empleadosapi()
    {
        //
        $empleados = Empleado::all();
        return response()->json([
            $empleados
        ], Response::HTTP_OK);
    }
    public function crearempleados(Request $request)
    {
        
         $request->validate([
            'emp_nombre' => 'required|max:100',
        ]);

        $empleados = new Empleado([
            'emp_nombre' => $request->input('emp_nombre'),
        ]);
  
        $empleados->save();
        
        if ($empleados->exists == true) {
            return response()->json(['success' => 'Guardado correctamente.', 'ejecucion' => true]);
        } else {
            return response()->json(['error' => 'No se pudo guardar.', 'ejecucion' => false]);
        }
    }
    public function calcularhoras(Request $request)
    {
        
         $request->validate([
            'cal_nombreempleado' => 'required|max:100',
            'cal_horas' =>  'required|max:100',
        ]);
        if ($request->input('cal_horas') < 48) {
            $cal_salario = 25000;
            $operacion = ($cal_salario * $request->input('cal_horas'));
        }else{
            $cal_salario = 35000;
            $operacion = ($cal_salario * $request->input('cal_horas'));
        }
        
        $calculo = new CalculoSalarial([
            'cal_nombreempleado' => $request->input('cal_nombreempleado'),
            'cal_horas' => $request->input('cal_horas'),
            'cal_salario' => $operacion,
        ]);
        $calculo->save();
        
        if ($calculo->exists == true) {
            return response()->json(['success' => 'Guardado correctamente.', 'ejecucion' => true, 'nombre' => $calculo->cal_nombreempleado, 'horas' => $calculo->cal_horas ,'salario' => $calculo->cal_salario]);
        } else {
            return response()->json(['error' => 'No se pudo guardar.', 'ejecucion' => false]);
        }
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
     * @param  \App\Http\Requests\StoreCalculoSalarialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalculoSalarialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalculoSalarial  $calculoSalarial
     * @return \Illuminate\Http\Response
     */
    public function show(CalculoSalarial $calculoSalarial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalculoSalarial  $calculoSalarial
     * @return \Illuminate\Http\Response
     */
    public function edit(CalculoSalarial $calculoSalarial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalculoSalarialRequest  $request
     * @param  \App\Models\CalculoSalarial  $calculoSalarial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalculoSalarialRequest $request, CalculoSalarial $calculoSalarial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalculoSalarial  $calculoSalarial
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $salario = CalculoSalarial::find($request->id);
        $salario->delete();
        return response()->json(['success' => 'Eliminado correctamente.', 'ejecucion' => true]);
    }
}
