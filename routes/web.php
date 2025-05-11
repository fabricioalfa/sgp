<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RrhhController;
use App\Http\Controllers\SacerdoteController;
use App\Http\Controllers\CebController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MisaController;
use App\Http\Controllers\BautizoController;
use App\Http\Controllers\ComunionController;
use App\Http\Controllers\ConfirmacionController;
use App\Http\Controllers\MatrimonioController;
use App\Http\Controllers\SacramentoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;  
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CertificadoController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecretarioMiddleware;

use function Laravel\Prompts\search;

//mail test
Route::get('/mail-test', function () {
    // Envía un correo “en blanco” al log
    Mail::raw('Este es un test de correo usando el driver log', function ($message) {
        $message
            ->to('tu@correo.com')      // cámbialo por un email cualquiera
            ->subject('Prueba de driver log');
    });

    return 'Correo registrado en log. Revisa storage/logs/laravel.log';
});

// ✅ Mostrar formulario de login tanto en '/' como en '/login'
Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Procesar login y logout
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Rutas protegidas por sesión
Route::middleware([CheckSession::class])->group(function () {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');
    Route::get('/perfil', function () {
        $usuario = session('usuario');
        return view('perfil.index', compact('usuario'));
    })->name('perfil');
    Route::get('/perfil/contrasena', [PerfilController::class, 'showChangePassword'])->name('cambiar.contrasena');
    Route::post('/perfil/contrasena', [PerfilController::class, 'updatePassword'])->name('cambiar.contrasena.update');

    // ✅ Rutas solo para ADMINISTRADOR
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('/usuarios', UsuarioController::class);
        Route::resource('/rrhh', RrhhController::class);
        //finanzass
        // Ruta para generar el recibo
        Route::get('/ingresos/{ingreso}/generateRecibo', [IngresoController::class, 'generateRecibo'])->name('ingresos.generateRecibo');
        Route::resource('ingresos', IngresoController::class);

        Route::get('/egresos/informe', [EgresoController::class, 'generateInforme'])->name('egresos.informe');
        Route::resource('egresos', EgresoController::class);
        

        Route::resource('finanzas', FinanzasController::class);

        Route::resource('sacramentos', SacramentoController::class);

    }); 

    // ✅ Rutas solo para SECRETARIO
    Route::middleware([SecretarioMiddleware::class])->group(function () {
        Route::resource('/sacerdotes', SacerdoteController::class);
        Route::resource('/cebs', CebController::class);
        Route::resource('/misas', MisaController::class);

        Route::get('/sacramentos/search', [SacramentoController::class, 'search'])->name('sacramentos.search');
        
        
        Route::get('/certificados',          [CertificadoController::class, 'index'])
        ->name('certificados.index');

        Route::get('/certificados/crear',    [CertificadoController::class, 'create'])
        ->name('certificados.create');

        Route::post('/certificados',         [CertificadoController::class, 'store'])
        ->name('certificados.store');


        Route::resource('/actividades', ActividadController::class) -> parameters(['actividades' => 'actividad']);
        // Rutas para sacramentos
        Route::resource('/sacramentos', SacramentoController::class); // Asegúrate de tener esta ruta
        Route::resource('/bautizos', BautizoController::class);
        Route::resource('/comuniones', ComunionController::class);
        Route::resource('/confirmaciones', ConfirmacionController::class);
        Route::resource('/matrimonios', MatrimonioController::class);
    });
});

// Recuperación de contraseña
Route::get('/password/solicitar',    [PasswordResetController::class, 'showRequestForm'])
     ->name('password.request');

Route::post('/password/solicitar',   [PasswordResetController::class, 'sendResetLink'])
     ->name('password.send');

Route::get('/password/restablecer',  [PasswordResetController::class, 'showResetForm'])
     ->name('password.reset');

Route::post('/password/restablecer', [PasswordResetController::class, 'updatePassword'])
     ->name('password.update');



