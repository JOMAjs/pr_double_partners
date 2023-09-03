<?php

use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PedidoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/cuenta',[CuentaController::class, 'index']);
Route::post('/cuenta',[CuentaController::class, 'store']);
//Route::put('/cuenta/{id}',[CuentaController::class, 'update']);
Route::delete('/cuenta/{id}',[CuentaController::class, 'destroy']);
Route::post('/cuenta-show',[CuentaController::class, 'show']);

// ROUTER PARA PEDIDO
Route::post('/pedido-show',[PedidoController::class, 'index']);
Route::post('/show_total',[PedidoController::class, 'show_total']);
Route::post('/pedido-create',[PedidoController::class, 'store']); 
Route::delete('/pedido/{id}',[PedidoController::class, 'destroy']);
Route::post('/pedido-edit',[PedidoController::class, 'show']);
