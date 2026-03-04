@extends('eventos.plantilla')

@section('contenido')
    <div class="row">
        <div class="col-12 text-center">
            <h1>
                Bienvenido
            </h1>
            <h2>
                {{ $evento->nombre }}
            </h2>
        </div>
    </div>
    @switch($evento->status)
     @case(1)
     <div class="row">
            <div class="col-12 text-center">
                <h1>Registro</h1>

            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <form id="FormAddAsistente">
                    @csrf
                    <input type="hidden" name="id_evento" id="id_evento" value="{{ $evento->id }}">
                    <div class="form-group">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" class="form-control" placeholder="Introduce tu nombre" id="nombre"
                            name="nombre" oninput="comprobarDatos();" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" class="form-control" placeholder="Introduce tu apellido paterno"
                            id="apellido_paterno" name="apellido_paterno" oninput="comprobarDatos();" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" class="form-control" placeholder="Introduce tu apellido materno"
                            id="apellido_materno" name="apellido_materno" oninput="comprobarDatos();" required>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" placeholder="Introduce tu correo" id="correo"
                            name="correo" oninput="comprobarDatos();" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="registrarAsistente();"
                        id="bRegistro">Registarme</button>
                </form>
            </div>
        </div>
     @break
        @case(2)
        <div class="row">
            <div class="col-12 text-center">
                <h1>Ingresa</h1>

            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <form method="post" action="{{ URL('/evento/iniciar-sesion') }}">
                    @csrf
                    <input type="hidden" name="id_evento" id="id_evento" value="{{ $evento->id }}">
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" placeholder="Introduce tu correo" id="correo"
                            name="correo">
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar</button>
                </form>
            </div>
        </div>
        @break

        @default
    @endswitch

    <script>
        function borrarCache() {
            alert('Borrar cache');
            window.location.reload(true);
        }
    </script>
@endsection

@section('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/fc-4.2.2/fh-3.3.2/r-2.4.1/sc-2.1.1/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/fc-4.2.2/fh-3.3.2/r-2.4.1/sc-2.1.1/datatables.min.js">
    </script>
    <script src="{{ asset('js/inicio/modales.js') }}?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.min.js"></script>

    <script src="{{ asset('js/eventos/inicio.js') }}?v={{ time() }}"></script>
@endsection
