<?php

namespace App\Exports;

use App\Models\Asistente;
use App\Models\AsistenteRespuesta;
use App\Models\Evento;
use App\Models\Pregunta;
use App\Models\PreguntaRespuesta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportePreguntasExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $idEvento;

    public function __construct($idEvento)
    {
        $this->idEvento = $idEvento;
    }

    public function view(): View
    {
        $evento = Evento::find($this->idEvento);
        $registrados = Asistente::where('id_evento', $evento->id)->where('status', 1)->count();
        $preguntas = Pregunta::where('id_evento', $evento->id)->where('status', '!=', 0)->orderBy('numero', 'asc')->get();
        foreach ($preguntas as $pregunta) {
            $opciones = PreguntaRespuesta::where('id_pregunta', $pregunta->id)->get();
            foreach ($opciones as $opcion) {
                # code...
                $contadorOpcion = AsistenteRespuesta::where('id_evento', $evento->id)
                    ->where('id_pregunta', $pregunta->id)
                    ->where('id_respuesta', $opcion->id)
                    ->count();

                $opcion->participaciones = $contadorOpcion;
            }
            $contadorPregunta = AsistenteRespuesta::where('id_evento', $evento->id)
                ->where('id_pregunta', $pregunta->id)->count();
            $presenciales = AsistenteRespuesta::where('asistente_respuestas.id_evento', $evento->id)
                ->join('asistentes', 'asistente_respuestas.id_asistente', 'asistentes.id')
                ->where('asistente_respuestas.id_pregunta', $pregunta->id)
                ->where('id_pregunta', $pregunta->id)->where('modalidad', 'Presencial')->count();
            $virtuales = AsistenteRespuesta::where('asistente_respuestas.id_evento', $evento->id)
                ->join('asistentes', 'asistente_respuestas.id_asistente', 'asistentes.id')
                ->where('asistente_respuestas.id_pregunta', $pregunta->id)
                ->where('asistentes.modalidad', 'Virtual')->count();
            $pregunta->participaciones = $contadorPregunta;
            $pregunta->presenciales = $presenciales;
            $pregunta->virtuales = $virtuales;
            $pregunta->opciones = $opciones;
        }
        return view('admin.preguntas.reporte_excel', ['evento' => $evento, 'preguntas' => $preguntas, 'registrados' => $registrados]);
    }
}
