<?php

namespace App\Http\Controllers\Admin;

use App\Events\PreguntasPusher;
use App\Exports\ReportePreguntasDetalladoExport;
use App\Exports\ReportePreguntasExport;
use App\Http\Controllers\Controller;
use App\Models\Asistente;
use App\Models\AsistenteRespuesta;
use App\Models\Empresa;
use App\Models\Evento;
use App\Models\Pregunta;
use App\Models\PreguntaRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EventosController extends Controller
{
    //
    public function index($id_empresa)
    {
        $empresa = Empresa::find($id_empresa);
        return view('admin.eventos.index', ['empresa' => $empresa]);
    }
    public function eventos($id_empresa)
    {
        $eventos = DB::table('eventos')
            ->join('empresas', 'eventos.id_empresa', 'empresas.id')
            ->where('eventos.status', '!=', 0)
            ->where('eventos.id_empresa', $id_empresa)
            ->select('eventos.*', 'empresas.nombre as empresa')
            ->get();
        return json_encode(['data' => $eventos]);
    }


    public function eventoAdd(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'nombre' => 'required|string|max:255',
                'id_empresa' => 'required|numeric',
                'fecha_inicio' => 'required',
                'fecha_termino' => 'required'
            ]
        );
        if ($validarDatos) {
            $ruta = '';

            if ($request->hasFile('imagen')) {

                $extension = $request->file('imagen')->extension();

                // Nombre personalizado
                $nombre = $request->nombre . '.' . $extension;

                // Guardar archivo
                $ruta = $request->file('imagen')
                    ->storeAs('eventos', $nombre, 'public');
            }
            $evento = Evento::create([
                'nombre' => $request->nombre,
                'id_empresa' => $request->id_empresa,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_termino' => $request->fecha_termino,
                'status' => '1',
                'imagen' => $ruta
            ]);
            if ($evento) {
                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }

    public function eventoGet($id)
    {
        $evento = Evento::find($id);
        return $evento;
    }
    public function eventoUpdate(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'id' => 'required|numeric',
                'nombre' => 'required|string|max:255',
                'id_empresa' => 'required|numeric',
                'fecha_inicio' => 'required',
                'fecha_termino' => 'required'
            ]
        );
        if ($validarDatos) {
            $ruta = '';

            if ($request->hasFile('imagen')) {

                $extension = $request->file('imagen')->extension();

                // Nombre personalizado
                $nombre = $request->nombre . '.' . $extension;

                // Guardar archivo
                $ruta = $request->file('imagen')
                    ->storeAs('eventos', $nombre, 'public');
            }
            $evento = Evento::find($request->id);
            if ($evento) {
                if ($evento->update([
                    'nombre' => $request->nombre,
                    'id_empresa' => $request->id_empresa,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_termino' => $request->fecha_termino,
                    'imagen' => $ruta
                ])) {
                    return response()->json(['ok' => 'true'], 200);
                } else {
                    return response()->json(['ok' => 'false'], 400);
                }
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }
    public function eliminarEvento($id)
    {
        $evento = Evento::find($id);
        if ($evento) {
            if ($evento->update(['status' => '0'])) {
                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        }
    }

    public function accionEvento($id, $accion)
    {
        $evento = Evento::find($id);
        if ($evento) {
            switch ($accion) {
                case 'activar':
                    $actualizarEvento = $evento->update(['status' => '2']);
                    break;
                case 'cerrar':
                    $actualizarEvento = $evento->update(['status' => '3']);
                    break;

                case 'abrir':
                    $actualizarEvento = $evento->update(['status' => '1']);
                    break;

                default:
                    # code...
                    break;
            }

            if ($actualizarEvento) {
                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        } else {
            return response()->json(['ok' => 'false'], 400);
        }
    }


    public function registroEvento($id_evento)
    {
        $id = base64_decode($id_evento);
        $evento = Evento::find($id);
        return view('eventos.index', ['evento' => $evento]);
    }


    public function eventoPreguntas($id_evento)
    {
        $id = base64_decode($id_evento);
        $evento = Evento::find($id);
        $registrados = Asistente::where('id_evento', $evento->id)->where('status', 1)->count();
        $presenciales = Asistente::where('id_evento', $evento->id)->where('status', 1)->where('modalidad', 'Presencial')->count();
        $virtuales = Asistente::where('id_evento', $evento->id)->where('status', 1)->where('modalidad', 'Virtual')->count();
        return view('admin.preguntas.index', ['evento' => $evento, 'registrados' => $registrados, 'virtuales' => $virtuales, 'presenciales' => $presenciales]);
    }

    public function eventoPreguntasObtener($id_evento)
    {
        $preguntas = Pregunta::where('id_evento', $id_evento)->where('status', '!=', 0)->get();
        foreach ($preguntas as $pregunta) {
            $opciones = PreguntaRespuesta::where('id_pregunta', $pregunta->id)->get();
            foreach ($opciones as $opcion) {
                # code...
                $contadorOpcion = AsistenteRespuesta::where('id_evento', $id_evento)
                    ->where('id_pregunta', $pregunta->id)
                    ->where('id_respuesta', $opcion->id)
                    ->count();

                $opcion->participaciones = $contadorOpcion;
            }
            $contadorPregunta = AsistenteRespuesta::where('id_evento', $id_evento)
                ->where('id_pregunta', $pregunta->id)->count();
            $presenciales = AsistenteRespuesta::where('asistente_respuestas.id_evento', $id_evento)
                ->join('asistentes', 'asistente_respuestas.id_asistente', 'asistentes.id')
                ->where('asistente_respuestas.id_pregunta', $pregunta->id)
                ->where('id_pregunta', $pregunta->id)->where('modalidad', 'Presencial')->count();
            $virtuales = AsistenteRespuesta::where('asistente_respuestas.id_evento', $id_evento)
                ->join('asistentes', 'asistente_respuestas.id_asistente', 'asistentes.id')
                ->where('asistente_respuestas.id_pregunta', $pregunta->id)
                ->where('asistentes.modalidad', 'Virtual')->count();
            $pregunta->participaciones = $contadorPregunta;
            $pregunta->presenciales = $presenciales;
            $pregunta->virtuales = $virtuales;
            $pregunta->opciones = $opciones;
        }

        return json_encode(['data' => $preguntas]);
    }

    public function eventoPreguntaRegistrar(Request $request)
    {
        $validarDatos = $request->validate(
            [
                'pregunta' => 'required|string|max:255',
                'id_evento' => 'required|numeric',
                'respuestas' => 'required'
            ]
        );
        if ($validarDatos) {
            $numero = 1;

            $ultimaPregunta = Pregunta::where('id_evento', $request->id_evento)->where('status', 1)->orderBy('id', 'desc')->first();

            if (!empty($ultimaPregunta)) {
                $numero = $ultimaPregunta->numero + 1;
            }


            $pregunta = Pregunta::create([
                'pregunta' => $request->pregunta,
                'id_evento' => $request->id_evento,
                'numero' => $numero,
                'status' => '1'
            ]);

            if ($pregunta) {
                $respuestas = $request->respuestas;
                foreach ($respuestas as $respuesta) {
                    # code...
                    $separar_respuesta = explode('-', $respuesta);
                    $numero_respuesta = $separar_respuesta[0];
                    $texto_respuesta = $separar_respuesta[1];

                    $registroRespuesta = PreguntaRespuesta::create([
                        'id_pregunta' => $pregunta->id,
                        'numero_respuesta' => $numero_respuesta,
                        'respuesta' => $texto_respuesta,
                    ]);
                }
                broadcast(new PreguntasPusher($pregunta));

                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        } else {
            return response()->json(['ok' => 'false'], 500);
        }
    }

    public function cerrarPregunta($id)
    {
        $pregunta = Pregunta::find($id);
        if ($pregunta) {
            if ($pregunta->update(['status' => '2'])) {
                broadcast(new PreguntasPusher($pregunta));
                return response()->json(['ok' => 'true'], 200);
            } else {
                return response()->json(['ok' => 'false'], 400);
            }
        }
    }

    public function reportePreguntas($id_evento)
    {
        return Excel::download(new ReportePreguntasExport($id_evento), 'preguntas_evento.xlsx');
    }

    public function reportePreguntasDetallado($id_evento)
    {
        return Excel::download(new ReportePreguntasDetalladoExport($id_evento), 'preguntas_evento_detallado.xlsx');
    }
}
