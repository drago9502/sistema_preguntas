<?php

namespace App\Exports;

use App\Models\Asistente;
use App\Models\AsistenteRespuesta;
use App\Models\Evento;
use App\Models\Pregunta;
use App\Models\PreguntaRespuesta;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportePreguntasDetalladoExport implements FromView, ShouldAutoSize
{
    protected $idEvento;

    public function __construct($idEvento)
    {
        $this->idEvento = $idEvento;
    }

    public function view(): View
    {
        $evento = Evento::find($this->idEvento);
        $registrados = Asistente::where('id_evento', $evento->id)->where('status', 1)->count();
        $preguntas = Pregunta::where('id_evento', $evento->id)->where('status', '!=', 0)->orderBy('numero','asc')->get();
        foreach ($preguntas as $pregunta) {
            $respuestas = DB::table('asistente_respuestas')
                ->leftJoin('asistentes', 'asistente_respuestas.id_asistente', 'asistentes.id')
                ->leftJoin('pregunta_respuestas', 'asistente_respuestas.id_respuesta', 'pregunta_respuestas.id')
                ->select('asistente_respuestas.*', 'asistentes.correo as correo', 'pregunta_respuestas.respuesta as respuesta')
                ->selectRaw("CONCAT_WS(' ', asistentes.nombre, asistentes.apellido_paterno, asistentes.apellido_materno) as asistente")
                ->where('asistente_respuestas.id_pregunta',$pregunta->id)
                ->get();
            $contadorPregunta = AsistenteRespuesta::where('id_evento', $evento->id)
                ->where('id_pregunta', $pregunta->id)->count();
            $pregunta->respuestas = $respuestas;
            $pregunta->participaciones = $contadorPregunta;
        }
        return view('admin.preguntas.reporte_excel_detallado', ['evento' => $evento, 'preguntas' => $preguntas, 'registrados' => $registrados]);
    }
}
