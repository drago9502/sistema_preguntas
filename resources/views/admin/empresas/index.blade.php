@extends('bases.base')

@section('title', 'Empresas')

@section('encabezado')
    <div class="row">
        <div class="col-6">
            <h1>Empresas</h1>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddEmpresa">Agregar Empresa</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="tablaEmpresas" style="width: 100%" class="table">
                <thead>
                    <th>
                        Numero
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Acciones
                    </th>
                </thead>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modalAddEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formRegistroEmpresa">
                                @csrf

                                {{-- Name field --}}
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce nombre empresa"
                                        id="nombre" name="nombre" required oninput="comprobarDatos()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarEmpresa();" id="bRegistro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditEmpresa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formEditarEmpresa">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                {{-- Name field --}}
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce tu nombre"
                                        id="nombre" name="nombre" required oninput="comprobarDatosEdit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editarEmpresa();" id="bEditar">Guardar</button>
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
    <script src="{{ asset('js/inicio/modales.js') }}?v={{time()}}"></script>
    <script src="{{ asset('js/admin/empresas.js') }}?v={{time()}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.js"></script>

@endsection
