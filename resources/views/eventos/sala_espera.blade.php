@extends('eventos.plantilla')

@section('contenido')
    <div class="row">
        <div class="col-12 text-center">
            <h1>
                Sala de espera
            </h1>
            <h2>
                {{ $evento->nombre }}
            </h2>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="idEvento" id="idEvento" value="{{$evento->id}}">
        <div class="col">
            Espera hasta que se active el acceso
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

    <script src="{{ asset('js/eventos/sala_espera.js') }}?v={{ time() }}"></script>
@endsection