@extends('adminlte::page')

@section('content_header')
<input type="hidden" name="userId" id="userId" value="{{Auth::id()}}">

@yield('header')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @yield('encabezado')
            </div>
        </div>
    </div>
</div>
@stop

@section('content')   
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @yield('contenido')
            </div>
        </div>
    </div>
</div>
<div class="row d-none">
    {{-- <audio src="{{asset('images/sonidoNotificacion.mp3')}}" id="notificacionSonido" name="notificacionSonido"></audio> --}}
</div> 
<div class="modal fade" id="modalNotificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Mis notificaciones</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>

            </div>

            <div class="modal-body">

                <div class="row" id="notificacionesDiv">

                

                    

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

               
            </div>

        </div>

    </div>

</div>
@stop

@section('footer')
<div class="d-flex d-sm-block">
    Pie de pagina
</div>

@stop

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('/vendor/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/notifications.css') }}"> --}}
@stop

@section('js')

{{-- <script src="{{ asset('/vendor/pusher/pusher.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/js/notifications.js') }}"></script> --}}
@stop