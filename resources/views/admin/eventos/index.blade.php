@extends('bases.base')

@section('title', 'Eventos')

@section('encabezado')
    <div class="row">
        <div class="col-6">
            <h1>Eventos de {{ $empresa->nombre }}</h1>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-warning" href="/admin/empresas">Regresar</a>
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddEvento">Agregar Eventos</a>
        </div>
    </div>
    <input type="hidden" name="id_empresa_all" id="id_empresa_all" value="{{$empresa->id}}">
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="tablaEventos" style="width: 100%" class="table">
                <thead>
                    <th>
                        Numero
                    </th>
                    <th>
                        Empresa
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Fecha inicio
                    </th>
                    <th>
                        Fecha fin
                    </th>
                    <th>
                        Acciones
                    </th>
                    <th>
                        Registro
                    </th>
                </thead>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modalAddEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formRegistroEvento">
                                @csrf

                                {{-- Name field --}}
                                <input type="hidden" id="id_empresa" name="id_empresa" value="{{ $empresa->id }}">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce nombre empresa"
                                        id="nombre" name="nombre" required oninput="comprobarDatos()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        required oninput="comprobarDatos()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_termino">Fecha fin</label>
                                    <input type="date" class="form-control" id="fecha_termino" name="fecha_termino"
                                        required oninput="comprobarDatos()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarEvento();"
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
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required
                                        oninput="comprobarDatosEdit()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_termino">Fecha fin</label>
                                    <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" required
                                        oninput="comprobarDatosEdit()">
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.2/datatables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.css">
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.2/datatables.min.js"></script>
    {{-- <script src="{{ asset('js/inicio/notificaciones.js') }}?v={{time()}}"></script> --}}
    <script src="{{ asset('js/inicio/modales.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/admin/eventos.js') }}?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.js"></script>

@endsection
