@extends('bases.base')

@section('title', 'Usuarios')

@section('encabezado')
    <div class="row">
        <div class="col-6">
            <h1>USUARIOS</h1>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddUser">Agregar Usuario</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="tablaUsuarios" style="width: 100%" class="table">
                <thead>
                    <th>
                        Numero
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Correo
                    </th>
                    <th>
                        Acciones
                    </th>
                </thead>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formRegistroUsuario">
                                @csrf

                                {{-- Name field --}}
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce tu nombre"
                                        id="name" name="name" required onchange="comprobarDatos()">
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <input type="email" class="form-control" placeholder="Introduce tu correo"
                                        id="email" name="email" required onchange="comprobarDatos()">
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Introduce tu Contraseña"
                                        id="password" name="password" required onchange="comprobarDatos()">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar contraseña</label>
                                    <input type="password" class="form-control" placeholder="Introduce tu contraseña"
                                        id="password_confirmation" name="password_confirmation" required
                                        onchange="comprobarDatos()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarUsuario();" id="bRegistro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formEditarUsuario">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                {{-- Name field --}}
                                <div class="form-group">
                                    <label for="name_edit">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Introduce tu nombre"
                                        id="name_edit" name="name_edit" required onchange="comprobarDatosEdit()">
                                </div>
                                <div class="form-group">
                                    <label for="email_edit">Correo</label>
                                    <input type="email" class="form-control" placeholder="Introduce tu correo"
                                        id="email_edit" name="email_edit" required onchange="comprobarDatosEdit()" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="password_edit">Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Introduce tu Contraseña"
                                        id="password_edit" name="password_edit" required onchange="comprobarDatosEdit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editarUsuario();" id="bEditar">Guardar</button>
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
    <script src="{{ asset('js/admin/usuarios.js') }}?v={{time()}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.js"></script>

@endsection
