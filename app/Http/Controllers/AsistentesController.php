<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use App\Models\AsistenteRespuesta;
use App\Models\Evento;
use App\Models\Pregunta;
use App\Models\PreguntaRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsistentesController extends Controller
{
    //
    public function asistenteAdd(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'id_evento' => 'required|numeric',
                'nombre' => 'required|string',
                'apellido_paterno' => 'required|string',
                'apellido_materno' => 'required|string',
                'correo' => 'required|email'
            ]
        );

        if ($validarDatos) {
            $verificarAsistente = Asistente::where('id_evento', $request->id_evento)->where('correo', $request->correo)->where('status', 1)->first();
            if (!empty($verificarAsistente)) {
                return response()->json(['ok' => 'true'], 230);
            } else {
                $asistente = Asistente::create([
                    'id_evento' => $request->id_evento,
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'correo' => $request->correo,
                    'status' => '1'
                ]);
                if ($asistente) {
                    return response()->json(['ok' => 'true'], 200);
                } else {
                    return response()->json(['ok' => 'false'], 400);
                }
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }

    public function inicioSesion(Request $request)
    {
        $validarDatos = $request->validate([
            'correo' => 'required|email|max:255',
            'id_evento' => 'required|numeric'
        ]);
        if ($validarDatos) {
            $asistente = Asistente::where('correo', $request->correo)->where('id_evento', $request->id_evento)->where('status', 1)->first();
            if (!empty($asistente)) {
                Auth::guard('asistente')->login($asistente);
                return redirect('/evento-preguntas/' . base64_encode($request->id_evento));
            } else {
                return redirect('/evento/registro/' . base64_encode($request->id_evento));
            }
        } else {
            return redirect('/evento/registro/' . base64_encode($request->id_evento));
        }
    }

    public function eventoPreguntas($id_evento)
    {
        $id = base64_decode($id_evento);
        $evento = Evento::where('id',$id)->where('status',2)->first();
        if(!empty($evento)){
             return view('eventos.preguntas', ['evento' => $evento]);
        }else{
             return redirect('/evento/registro/' . base64_encode($id));
        }
       
    }

    public function eventoPreguntasObtener($id_evento)
    {
        $asistente = Auth::guard('asistente')->user();

        $preguntas = DB::table('preguntas')
            ->leftJoin('asistente_respuestas', function ($join) use ($asistente) {
                $join->on('asistente_respuestas.id_pregunta', '=', 'preguntas.id')
                    ->where('asistente_respuestas.id_asistente', '=', $asistente->id);
            })
            ->where('preguntas.status', 1)
            ->where('preguntas.id_evento', $id_evento)
            ->whereNull('asistente_respuestas.id_pregunta')
            ->select('preguntas.*')
            ->get();

        return response()->json(['data' => $preguntas]);
    }

    public function preguntaRespuestas($id_pregunta)
    {
        $pregunta = Pregunta::find($id_pregunta);
        $opciones = PreguntaRespuesta::where('id_pregunta', $pregunta->id)->get();
        $pregunta->opciones = $opciones;
        return $pregunta;
    }

    public function agregarRespuesta(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'id_evento' => 'required|numeric',
                'id_pregunta' => 'required|numeric',
                'id_asistente' => 'required|numeric',
                'respuesta' => 'required|numeric',
            ]
        );
        if ($validarDatos) {

            $verificarRespuesta = AsistenteRespuesta::where('id_evento', $request->id_evento)
                ->where('id_pregunta', $request->id_pregunta)
                ->where('id_asistente', $request->id_asistente)->first();

            if (!empty($verificarRespuesta)) {
                return response()->json(['ok' => 'true'], 230);
            } else {
                $registrarRespuesta = AsistenteRespuesta::create([
                    'id_evento' => $request->id_evento,
                    'id_pregunta' => $request->id_pregunta,
                    'id_asistente' => $request->id_asistente,
                    'id_respuesta' => $request->respuesta,
                ]);
                if ($registrarRespuesta) {
                    return response()->json(['ok' => 'true'], 200);
                } else {
                    return response()->json(['ok' => 'false'], 400);
                }
            }
        } else {
            return response()->json(['ok' => 'false'], 400);
        }
    }

    public function eliminarSesion(Request $request)
    {
        $user = Auth::user();
        Auth::guard('asistente')->logout();
        return redirect('/evento/registro/' . base64_encode($request->id_evento_s));
    }
}
