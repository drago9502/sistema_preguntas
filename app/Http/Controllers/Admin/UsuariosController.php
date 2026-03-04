<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index');
    }
    public function usuarios()
    {
        $usuarios = User::where('status','1')->get();
        return json_encode(['data' => $usuarios]);
    }

    public function registrarUsuario(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]
        );
        if ($validarDatos) {
            $usuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => '1'
            ]);
            if ($usuario) {
                Auth::login($usuario);
                return redirect('/home');
            }
        }
    }


    public function inicioSesion(Request $request)
    {
        $validarDatos = $request->validate([
            'email' => 'required|email|max:255|',
            'password' => 'required|string|min:8'
        ]);
        if ($validarDatos) {
            $usuario = User::where('email', $request->email)->where('status', '1')->get()->first();
            if(isset($usuario)){
                if (Hash::check($request->password, $usuario->password)) {
                    Auth::login($usuario);
                    return redirect('/admin/empresas');
                }else{
                    return redirect('/');
                }
            }else{
                return redirect('/');
            }
           
        }
    }

    public function usuarioAdd(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]
        );
        if ($validarDatos) {
            $usuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => '1'
            ]);
            if ($usuario) {
                return response()->json(['ok' => 'true']);
            } else {
                return response()->json(['ok' => 'false']);
            }
        } else {
            return response()->json(['ok' => 'false']);
        }
    }
    public function usuarioGet($id)
    {
        $usuario = User::find($id);
        return $usuario;
    }
    public function usuarioUpdate(Request $request)
    {
        $usuario = User::find($request->id);
        if ($usuario) {
            if ($usuario->update(['name' => $request->name_edit, 'password' => Hash::make($request->password_edit)])) {
                return response()->json(['ok' => 'true']);
            } else {
                return response()->json(['ok' => 'false']);
            }
        }
    }
    public function eliminarUpdate($id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            if ($usuario->update(['status' =>'0'])) {
                return response()->json(['ok' => 'true']);
            } else {
                return response()->json(['ok' => 'false']);
            }
        }
    }
    public function informacionUsuario()
    {
        $user=Auth::user();
        $usuario=User::find($user->id);
        return view('usuarios.informacion.informacion',['usuario'=>$usuario]);
    }
    public function eliminarSesion()
    {
        $user=Auth::user();
        Auth::logout();
        return redirect('/');
    }
}
