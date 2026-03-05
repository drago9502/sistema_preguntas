@extends('bases.base')

@section('title', 'Preguntas')

@section('encabezado')
    <div class="row">
        <div class="col-6">
            <h1>Preguntas de: {{ $evento->nombre }} Registrados: {{ $registrados }}</h1>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-warning" href="{{ url()->previous() }}">Regresar</a>
            <a href="{{URL('/admin/evento-preguntas-reporteExcel',$evento->id)}}" class="btn btn-success" target="_blank">Reporte</a>
            <a href="{{URL('/admin/evento-preguntas-reporteExcelDetallado',$evento->id)}}" class="btn btn-success" target="_blank">Reporte detallado</a>
            @if ($evento->status == 2)
                <a class="btn btn-primary" onclick="cargarTablaPreguntas();">Recargar preguntas</a>
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddPregunta">Agregar Pregunta</a>
            @endif
        </div>
    </div>
@endsection

@section('contenido')
    <input type="hidden" name="id_evento_all" id="id_evento_all" value="{{ $evento->id }}">
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="tablaPreguntas" style="width: 100%" class="table">
                <thead>
                    <th>
                        Numero
                    </th>
                    <th>
                        Pregunta
                    </th>
                    <th>
                        Opciones
                    </th>
                    <th>
                        Estadisticas
                    </th>
                    <th>
                        Acciones
                    </th>
                </thead>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modalAddPregunta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Pregunta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formRegistroPregunta">
                                @csrf

                                {{-- Name field --}}
                                <input type="hidden" id="id_evento" name="id_evento" value="{{ $evento->id }}">
                                <div class="form-group">
                                    <label for="pregunta">Pregunta</label>
                                    <input type="text" class="form-control" placeholder="Introduce la pregunta"
                                        id="pregunta" name="pregunta" required oninput="comprobarDatos()">
                                </div>
                                {{-- <div class="row"> --}}
                                <div class="form-group">
                                    <label for="add_respuesta">Agrega respuesta</label>
                                    <input type="text" class="form-control" placeholder="Introduce la respuesta"
                                        id="add_respuesta" name="add_respuesta">
                                    <a class="btn btn-success my-1" onclick="agregarRespuesta()">+</a>
                                </div>
                                <div class="row" id="respuestas">

                                </div>

                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarPregunta();"
                        id="bRegistro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formEditarEvento">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="id_empresa" id="id_empresa">
                                {{-- Name field --}}
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce tu nombre"
                                        id="nombre" name="nombre" required oninput="comprobarDatosEdit()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        required oninput="comprobarDatosEdit()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_termino">Fecha fin</label>
                                    <input type="date" class="form-control" id="fecha_termino" name="fecha_termino"
                                        required oninput="comprobarDatosEdit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editarEvento();"
                        id="bEditar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.2/datatables.min.css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"> --}}
    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
@endsection

@section('js')
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
    {{-- <script src="{{ asset('js/inicio/notificaciones.js') }}?v={{time()}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>

    <script src="{{ asset('js/inicio/modales.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/admin/preguntas.js') }}?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.js"></script>

@endsection
