@extends('bases.base')



@section('title', 'EVENTOS')



@section('encabezado')

    <div class="row">

        <div class="col-6">

            <h1>EVENTOS</h1>

        </div>

        <div class="col-6 text-right">



        </div>

    </div>

@endsection



@section('contenido')

    <div class="row">

        <div class="col-12 table-responsive">

            <table id="tablaEventos" style="width: 100%" class="table">

                <thead>

                    <th>

                        Clave

                    </th>

                    <th>

                        Cliente

                    </th>

                    <th>

                        Fecha inicio

                    </th>

                    <th>

                        Fecha fin

                    </th>
                    <th>
                        Fecha estimada de pago
                    </th>
                    <th>
                        Fecha cierre
                    </th>

                    <th>

                        Ciudad

                    </th>

                    {{-- <th>

                        Sede

                    </th>

                    <th>

                        Modalidad

                    </th>

                    <th>

                        Imagen

                    </th>
                    <th>
                        Director
                    </th>

                    <th>

                        Responsable captura

                    </th>

                    <th>

                        Contrato

                    </th> --}}

                    {{-- <th>

                        Ejecutivos

                    </th> --}}

                    {{-- <th>

                        Estado

                    </th> --}}
                    <th>
                        Ingresos
                    </th>
                    <th>
                        Egresos
                    </th>
                    {{-- <th>

                        Costo real

                    </th> --}}

                    <th>

                        Acciones

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
                                <div class="form-group">

                                    <label for="director_id">Director</label>

                                    <select name="director_id" id="director_id" class="form-control">

                                        <option value="">Selecciona un director</option>



                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="clave_evento">Clave</label>

                                    <input type="text" class="form-control" placeholder="Introduce la clave del evento"
                                        id="clave_evento" name="clave_evento" required>

                                </div>

                                <div class="form-group">

                                    <label for="cliente_id">Cliente</label>

                                    <select name="cliente_id" id="cliente_id" class="form-control">

                                        <option value="">Selecciona un cliente</option>



                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="fecha_inicio">Fecha inicio</label>

                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        required>

                                </div>

                                <div class="form-group">

                                    <label for="fecha_fin">Fecha fin</label>

                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>

                                </div>

                                <div class="form-group">

                                    <label for="fecha_estimada_pago">Fecha estimada de pago</label>

                                    <input type="date" class="form-control" id="fecha_estimada_pago"
                                        name="fecha_estimada_pago" required>

                                </div>

                                <div class="form-group">

                                    <label for="fecha_cierre">Fecha cierre</label>

                                    <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre"
                                        required>

                                </div>


                                <div class="form-group">

                                    <label for="ciudad">Ciudad</label>

                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required
                                        placeholder="Introduce la ciudad del evento">

                                </div>

                                <div class="form-group">

                                    <label for="sede">Sede</label>

                                    <input type="text" class="form-control" id="sede" name="sede" required
                                        placeholder="Introduce la sede del evento">

                                </div>

                                <div class="form-group">

                                    <label for="modalidad">Modalidad</label>

                                    <select name="modalidad" id="modalidad" class="form-control">

                                        <option value="">Selecciona una modalidad</option>

                                        <option value="Hibrido">Hibrido</option>

                                        <option value="Presencial">Presencial</option>

                                        <option value="Virtual">Virtual</option>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="imagen">Imagen del evento </label>

                                    <input type="file" class="form-control" placeholder="Introduce el logo del cliente"
                                        id="imagen" name="imagen" required accept=".png,.jpeg, .jpg">

                                </div>

                                <div class="form-group">

                                    <label for="responsable_id">Responsable de captura</label>

                                    <select name="responsable_id" id="responsable_id" class="form-control">

                                        <option value="">Selecciona un asistente</option>



                                    </select>

                                </div>

                                {{-- <div class="form-group">

                                    <label for="contrato">Contrato</label>

                                    <input type="file" class="form-control"

                                        id="contrato" name="contrato" required accept=".pdf" >

                                </div> --}}

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

        Echo.channel('test-channel')
            .listen('.test.event', (e) => {
                console.log('Evento recibido:', e);
                alert('🔥 Pusher funciona SIN Vite');
            });
    </script>
@endsection

</body>
</html>
