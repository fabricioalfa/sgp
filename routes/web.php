<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SacramentoController;
use App\Http\Controllers\BautizoController;
use App\Http\Controllers\ComunionController;
use App\Http\Controllers\ConfirmacionController;
use App\Http\Controllers\MatrimonioController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\MisaController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\RrhhController;
use App\Http\Controllers\SacerdoteController;
use App\Http\Controllers\CebController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecretarioMiddleware;
use App\Http\Controllers\PasswordResetController;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Procesar login y logout
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Rutas protegidas por sesión
Route::middleware([CheckSession::class])->group(function () {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');

    // ✅ Rutas para perfil (Ver perfil y Cambiar contraseña)
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index'); // Muestra el perfil
    Route::get('/perfil/cambiar-contraseña', [PerfilController::class, 'showChangePassword'])->name('perfil.cambiar_contrasena'); // Muestra el formulario para cambiar la contraseña
    Route::post('/perfil/cambiar-contraseña', [PerfilController::class, 'updatePassword'])->name('cambiar_contrasena.update'); // Actualiza la contraseña

    // ✅ Rutas solo para ADMINISTRADOR
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('/usuarios', UsuarioController::class);
        Route::resource('/rrhh', RrhhController::class);
        Route::resource('finanzas', FinanzasController::class);
        Route::resource('sacramentos', SacramentoController::class); 
    }); 

    // ✅ Rutas solo para SECRETARIO
    Route::middleware([SecretarioMiddleware::class])->group(function () {
        Route::resource('/sacerdotes', SacerdoteController::class);
        Route::resource('/cebs', CebController::class);
        Route::resource('/misas', MisaController::class);
        Route::resource('/actividades', ActividadController::class) -> parameters(['actividades' => 'actividad']);
        Route::resource('/sacramentos', SacramentoController::class);
        Route::resource('/bautizos', BautizoController::class);
        Route::resource('/comuniones', ComunionController::class);
        Route::resource('/confirmaciones', ConfirmacionController::class);
        Route::resource('/matrimonios', MatrimonioController::class);
        Route::get('/certificados', [CertificadoController::class, 'index'])->name('certificados.index');
        Route::get('/certificados/crear', [CertificadoController::class, 'create'])->name('certificados.create');
        Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');
        Route::post('/certificados/eliminar-temp', [CertificadoController::class, 'eliminarTemporal'])->name('certificados.eliminarTemporal');
    });
});

// Recuperación de contraseña
Route::get('/password/solicitar', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.send');
Route::get('/password/restablecer', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/restablecer', [PasswordResetController::class, 'updatePassword'])->name('password.update');