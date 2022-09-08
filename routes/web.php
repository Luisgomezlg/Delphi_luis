<?php

use App\Http\Controllers\CabezafacturaController;
use App\Http\Controllers\CalculoSalarialController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/productosauth', [ProductoController::class, 'productos'])->name('productos');
Route::get('/productosapi', [ProductoController::class, 'productosapi']);
Route::get('/productosapipublic', [ProductoController::class, 'productosapipublic']);

Route::post('/crearproducto', [ProductoController::class, 'crearproducto']);
Route::post('/actualizarproducto', [ProductoController::class, 'update']);
Route::post('/eliminarproducto', [ProductoController::class, 'delete']);

Route::get('editarproducto/{id}', [ProductoController::class, 'edit']);
Route::get('productosedit/{id}', [ProductoController::class, 'productosedit']);

Route::get('/facturas', [FacturaController::class, 'index'])->name('index');
Route::get('/calculosalarial', [CalculoSalarialController::class, 'index'])->name('index');
Route::get('/facturasapi', [FacturaController::class, 'facturasapi']);
Route::get('/facturasapipublic', [FacturaController::class, 'facturasapipublic']);
Route::post('/comprarproducto', [FacturaController::class, 'comprar']);

Route::get('/empleados', [CalculoSalarialController::class, 'index'])->name('index');
Route::get('/empleadosapi', [CalculoSalarialController::class, 'empleadosapi'])->name('empleadosapi');
Route::get('/empleadosapipublic', [CalculoSalarialController::class, 'empleadosapipublic'])->name('empleadosapipublic');

Route::post('/crearempleados', [CalculoSalarialController::class, 'crearempleados'])->name('crearempleados');
Route::post('/calcularhoras', [CalculoSalarialController::class, 'calcularhoras'])->name('calcularhoras');

Route::get('/salarios', [CalculoSalarialController::class, 'salarios'])->name('salarios');

Route::post('/eliminarempleado', [EmpleadoController::class, 'delete']);
Route::post('/eliminarsalario', [CalculoSalarialController::class, 'delete']);
Route::post('/eliminarfactura', [FacturaController::class, 'delete']);
Route::post('/eliminarcabeza', [CabezafacturaController::class, 'delete']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'productos' => Producto::all(),
    
        ]);
    });
});
