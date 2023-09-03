<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # codigo para listar los pedido del cliente ...
        
        $listPedido = Pedido::join('cuenta','cuenta.id','=','pedido.cuenta_id')
                             ->select('cantidad','producto','valor','total','pedido.id')
                             ->where('cuenta.id',$request->id)->get();
        return $listPedido;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show_total(Request $request)
    {
    
        # codigo para sumas los pedido del cliente ...
        $suma = DB::table('pedido')->select(DB::raw('SUM(valor) AS total'))->where('pedido.cuenta_id',$request->id)->get();
        return $suma;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!blank($request->id)) 
        {
            # codigo para actualizar la pedido del cliente ...
            $update = Pedido::findOrFail($request->id);
            $update->producto = $request->producto;
            $update->cantidad  = $request->cantidad;
            $update->valor = $request->valor;

            $update->update();
            return $update;

        } else {
            
            # codigo para insertar  la pedido del cliente ...
            $suma = DB::table('pedido') ->select(DB::raw('SUM(valor) AS total'))->get();

            $create = new Pedido();
            $create->cuenta_id = $request->cuenta_id;
            $create->producto = $request->producto;
            $create->cantidad  = $request->cantidad;
            $create->valor = $request->valor;
            $create->total = $suma;
            
            $create->save();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        $pedido = blank($request->id) ? new Pedido() : Pedido::findOrFail($request->id);
        return $pedido;
    }


    public function destroy(Request $request)
    {
        # codigo para eliminar la Pedido del cliente ...
        $destroy = Pedido::destroy($request->id);
        return $destroy;
    }
}
