@extends('eventos.plantilla')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="">Inicio</a>

        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContenido"
                aria-controls="navbarContenido"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse" id="navbarContenido">

            <!-- ms-auto en Bootstrap 5 -->
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="">Preguntas</a>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="navbarDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">

                        {{ Auth::guard('asistente')->user()->nombre }}
                        {{ Auth::guard('asistente')->user()->apellido_paterno }}
                        {{ Auth::guard('asistente')->user()->apellido_materno }}
                    </a>

                    <!-- dropdown-menu-end en BS5 -->
                    <ul class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="navbarDropdown">

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger"
                               href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar sesión
                            </a>
                        </li>

                    </ul>

                    <form id="logout-form"
                          action="{{ route('cerrarAsistente') }}"
                          method="POST"
                          class="d-none">
                        @csrf
                        <input type="hidden" name="id_evento_s" value="{{$evento->id}}">
                    </form>

                </li>

            </ul>

        </div>
    </div>
</nav>
@section('contenido')
    <div class="row">
        <div class="col-12 text-center">
            <h1>
                Bienvenido
            </h1>
            <h2>
                Preguntas del evento: {{ $evento->nombre }}
            </h2>
        </div>
    </div>
    <input type="hidden" name="id_evento" id="id_evento" value="{{ $evento->id }}">
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="tablaPreguntas" style="width: 100%" class="table">
                <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Pregunta
                    </th>
                    <th>
                        Acciones
                    </th>
                </thead>
            </table>
        </div>

    </div>

     <div class="modal fade" id="modalAddRespuesta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Respuesta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" id="formRegistroRespuesta">
                                @csrf

                                {{-- Name field --}}
                                <input type="hidden" id="id_evento" name="id_evento" value="{{ $evento->id }}">
                                <input type="hidden" name="id_pregunta" id="id_pregunta">
                                <input type="hidden" name="id_asistente" id="id_asistente" value="{{Auth::guard('asistente')->user()->id}}">
                                <div class="form-group my-4">
                                    <label for="pregunta" id="pregunta"></label>
                                </div>

                                <div class="row my-4" id="respuestas">

                                </div>

                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarRespuesta();"
                        id="bRegistro">Enviar respuesta</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="{{ asset('js/eventos/preguntas.js') }}?v={{ time() }}"></script>


    <script src="{{ asset('js/inicio/modales.js') }}?v={{ time() }}"></script>

    <!-- 1️⃣ Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- 2️⃣ Laravel Echo IIFE (correcto) -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.min.js"></script>

    <script>
        // 👇 ASÍ se instancia en IIFE
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        Echo.channel('preguntas-channel')
            .listen('.preguntas.event', (e) => {
                console.log('Pregunta recibido:', e);
                // alert('🔥 Pusher funciona SIN Vite');
                cargarTablaPreguntas();
            });
    </script>
@endsection
