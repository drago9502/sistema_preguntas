<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    //
    public function index()
    {
        return view('admin.empresas.index');
    }
    public function empresas()
    {
        $empresas = Empresa::where('status', '1')->get();
        return json_encode(['data' => $empresas]);
    }


    public function empresaAdd(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'nombre' => 'required|string|max:255',
            ]
        );
        if ($validarDatos) {
            $empresa = Empresa::create([
                'nombre' => $request->nombre,
                'status' => '1'
            ]);
            if ($empresa) {
                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }

    public function empresaGet($id)
    {
        $empresa = Empresa::find($id);
        return $empresa;
    }
    public function empresaUpdate(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'nombre' => 'required|string|max:255',
                'id' => 'required|numeric'
            ]
        );
        if ($validarDatos) {
            $empresa = Empresa::find($request->id);
            if ($empresa) {
                if ($empresa->update(['nombre' => $request->nombre])) {
                    return response()->json(['ok' => 'true'],200);
                } else {
                    return response()->json(['ok' => 'false'],400);
                }
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }
    public function eliminarEmpresa($id)
    {
        $empresa = Empresa::find($id);
        if ($empresa) {
            if ($empresa->update(['status' => '0'])) {
                return response()->json(['ok' => 'true'],200);
            } else {
                return response()->json(['ok' => 'false'],400);
            }
        }
    }
}
