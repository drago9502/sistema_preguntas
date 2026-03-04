<?php


use App\Events\TestPusher;
use App\Http\Controllers\Admin\EmpresasController;
use App\Http\Controllers\Admin\EventosController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\AsistentesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('inicio.login');
})->name('inicio');
route::get('/registrar', function () {
    return view('inicio.registro');
})->name('registro');


route::post('/registrarUsuario', [UsuariosController::class, 'registrarUsuario']);
route::post('/iniciar', [UsuariosController::class, 'inicioSesion']);
// Auth::routes();

Route::middleware(['auth'])->group(function () {
    // route::middleware('role:superadministrador')->group(function () {
    // Route::get('/usuario/notificaciones/get/{usuario}', [HomeController::class, 'obtenerNumeroNotificaciones']);
    // route::get('/usuario/notificaciones/show/{usuario}', [HomeController::class, 'obtenerNotificaciones']);
    // route::get('/usuario/notificaciones/leerNotificaciones/{notificaciones}', [HomeController::class, 'leerNotificacion']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    route::get('/usuario/informacion', [UsuariosController::class, 'informacionUsuario']);
    route::get('/usario/get/{id}', [UsuariosController::class, 'usuarioGet']);
    route::post('/usuario/update', [UsuariosController::class, 'usuarioUpdate']);
    route::post('/cerrarSesion', [UsuariosController::class, 'eliminarSesion'])->name('cerrar');

    // usuarios
    route::get('/admin/usarios', [UsuariosController::class, 'index']);
    route::get('/admin/usarios/get', [UsuariosController::class, 'usuarios']);
    route::post('/admin/usarios/add', [UsuariosController::class, 'usuarioAdd']);
    route::get('/admin/usario/get/{id}', [UsuariosController::class, 'usuarioGet']);
    route::post('/admin/usario/update', [UsuariosController::class, 'usuarioUpdate']);
    route::get('/admin/usario/eliminar/{id}', [UsuariosController::class, 'eliminarUpdate']);

    // empresas
    route::get('/admin/empresas', [EmpresasController::class, 'index']);
    route::get('/admin/empresas/get', [EmpresasController::class, 'empresas']);
    route::post('/admin/empresa/add', [EmpresasController::class, 'empresaAdd']);
    route::get('/admin/empresa/get/{id}', [EmpresasController::class, 'empresaGet']);
    route::post('/admin/empresa/update', [EmpresasController::class, 'empresaUpdate']);
    route::get('/admin/empresa/eliminar/{id}', [EmpresasController::class, 'eliminarEmpresa']);

    // eventos
    route::get('/admin/empresa-eventos/{id_empresa}', [EventosController::class, 'index']);
    route::get('/admin/empresa-obtener-eventos/{id_empresa}', [EventosController::class, 'eventos']);
    route::post('/admin/evento/add', [EventosController::class, 'eventoAdd']);
    route::get('/admin/evento/get/{id}', [EventosController::class, 'eventoGet']);
    route::post('/admin/evento/update', [EventosController::class, 'eventoUpdate']);
    route::get('/admin/evento/eliminar/{id}', [EventosController::class, 'eliminarEvento']);
    route::get('/admin/evento/accion/{id}/{accion}', [EventosController::class, 'accionEvento']);

    route::get('/admin/evento-preguntas/{id_evento}', [EventosController::class, 'eventoPreguntas']);
    route::get('/admin/evento-preguntas-obtener/{id_evento}', [EventosController::class, 'eventoPreguntasObtener']);
    route::post('/admin/evento-preguntas-registrar', [EventosController::class, 'eventoPreguntaRegistrar']);

    // });





    Route::get('/test-pusher', function () {
        broadcast(new TestPusher());
        return 'Evento enviado';
    });

    route::get('/ver-test', function () {
        return view('test-pusher.index');
    });
});


// registro evento

route::get('/evento/registro/{id_evento}', [EventosController::class, 'registroEvento']);
route::post('/evento/registroAsistente', [AsistentesController::class, 'asistenteAdd']);
route::post('/evento/iniciar-sesion', [AsistentesController::class, 'inicioSesion']);

Route::middleware('auth:asistente')->group(function () {
    route::get('/evento-preguntas/{id_evento}', [AsistentesController::class, 'eventoPreguntas']);
    route::get('/evento-preguntas-obtener/{id_evento}', [AsistentesController::class, 'eventoPreguntasObtener']);
    route::get('/evento-pregunta-respuestas/{id_pregunta}',[AsistentesController::class,'preguntaRespuestas']);
    route::post('/evento-agregar-respuesta',[AsistentesController::class,'agregarRespuesta']);
    route::post('/asistentes/cerrarSesion', [AsistentesController::class, 'eliminarSesion'])->name('cerrarAsistente');
});
