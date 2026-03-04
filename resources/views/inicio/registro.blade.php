@extends('inicio.plantilla')

@section('contenido')
    
<div class="row">
    <div class="col-12 text-center">
        <h1>Registrar usuario</h1>
        
    </div>
    
</div>
<div class="row">
    <div class="col-12">
        <form action="{{url('/registrarUsuario')}}" method="post">
            @csrf
    
            {{-- Name field --}}
            <div class="form-group">
            <label for="name">Nombre</label>
                <input type="text" class="form-control"
                    placeholder="Introduce tu nombre" id="name" name="name" required onchange="comprobarDatos()">
            </div>
            <div class="form-group">
                <label for="email">Correo</label>
                    <input type="email" class="form-control" 
                        placeholder="Introduce tu correo" id="email" name="email" required onchange="comprobarDatos()">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                        <input type="password" class="form-control" 
                            placeholder="Introduce tu Contraseña" id="password" name="password" required onchange="comprobarDatos()">
                    </div>
                    <input type="hidden" id="status" name="status" value="1">
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" class="form-control"
                                placeholder="Introduce tu correo" id="password_confirmation" name="password_confirmation" required onchange="comprobarDatos()">
                        </div>
                        <button type="submit" class="btn btn-success" id="bRegistro">Registrar</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/inicio/registro.js')}}?v={{time()}}"></script>
@endsection

@section('css')

@endsection