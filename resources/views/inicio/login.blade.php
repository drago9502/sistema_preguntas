@extends('inicio.plantilla')

@section('contenido')
    
<div class="row">
    <div class="col-12 text-center">
        <h1>Inicia Sesión</h1>
        
    </div>
    
</div>
<div class="row">
    <div class="col-12">
        <form method="post" action="{{ URL('/iniciar') }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Correo</label>
                <input type="email" class="form-control" id="exampleInputEmail1"
                    placeholder="Introduce tu correo" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Introdice tu contraseña" id="passwor" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar</button> 
            {{-- <a href="{{url('/registrar')}}" class="btn btn-success">Registrar</a> 
            <a href="{{url('/google-auth/redirect')}}" class="btn btn-danger">Iniciar con google</a> --}}
            {{-- <a onclick="borrarCache()" class="btn btn-warning">Borrar caché y cookies</a> --}}
        </form>
    </div>
</div>
<script>
  function borrarCache() {
    alert('Borrar cache');
    window.location.reload(true);
}
</script>
@endsection

@section('js')

@endsection

@section('css')

@endsection