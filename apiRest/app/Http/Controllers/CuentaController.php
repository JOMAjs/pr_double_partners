<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    
    public function index()
    {
        # codigo para litado la curnta del cliente ...
        $listCuentas = Cuenta::all();
        return $listCuentas;
    }


    public function store(Request $request)
    {
        if (!blank($request->id)) 
        {
            # codigo para actualizar la curnta del cliente ...
            $update = Cuenta::findOrFail($request->id);
            $update->nombre = $request->nombre;
            $update->email = $request->email;
            $update->telefono = $request->telefono;

            $update->update();
            return $update;

        } else {
            
            # codigo para insertar  la curnta del cliente ...
            $create = new Cuenta();
            $create->nombre = $request->nombre;
            $create->email  = $request->email;
            $create->telefono = $request->telefono;
            
            $create->save();

        }
    }


    public function show(Request $request)
    {
        # codigo para buscar curnta del cliente ...
        $cuenta = blank($request->id) ? new Cuenta() : Cuenta::findOrFail($request->id);
        return $cuenta;
    }



    public function destroy(Request $request)
    {
        # codigo para eliminar la curnta del cliente ...
        $destroy = Cuenta::destroy($request->id);
        return $destroy;
    }
}
