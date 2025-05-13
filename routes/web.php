<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController; // Ensure this file exists in the specified namespace
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
use App\Http\Controllers\PanelController;
use Illuminate\Http\Request;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Procesar login y logout
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Rutas protegidas por sesión
Route::middleware([CheckSession::class])->group(function () {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');

    // ✅ Rutas para perfil (Ver perfil y Cambiar contraseña)
    Route::middleware([CheckSession::class])->group(function () {
        Route::get('/panel', [PanelController::class, 'index'])->name('panel');
        
       // Panel principal y perfil del usuario
    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    // Rutas para cambiar la contraseña
    Route::get('/perfil/cambiar-contraseña', [PanelController::class, 'showChangePassword'])->name('perfil.cambiar-contrasena');
    Route::post('/perfil/cambiar-contraseña', [PanelController::class, 'updatePassword'])->name('perfil.cambiar-contrasena.update');
    });

    // ✅ Rutas solo para ADMINISTRADOR
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('/usuarios', UsuarioController::class);
        Route::resource('/rrhh', RrhhController::class);
        Route::resource('finanzas', FinanzasController::class);
        Route::resource('sacramentos', SacramentoController::class); 
    }); 

    // ✅ Rutas solo para SECRETARIO
    Route::middleware([SecretarioMiddleware::class])->group(function () {
        Route::resource('finanzas', FinanzasController::class);
        // Definir la ruta para el reporte de finanzas
        Route::get('/finanzas/reporte', [FinanzasController::class, 'generateReport'])->name('finanzas.reporte');



        Route::resource('/ingresos', IngresoController::class);
        Route::get('/ingresos/{ingreso}/generateRecibo', [IngresoController::class, 'generateRecibo'])->name('ingresos.generateRecibo');
        Route::get('/egresos/informe', [EgresoController::class, 'generarInforme'])->name('egresos.informe');

        Route::resource('/egresos', EgresoController::class);  
        Route::resource('/sacerdotes', SacerdoteController::class);
        Route::resource('/cebs', CebController::class);
        Route::resource('misas', MisaController::class);
        Route::get('misas/{misa}/verRecibo', [MisaController::class, 'verRecibo'])->name('misas.verRecibo');
        Route::post('/eliminar-archivo', function (Request $request) {
            $filePath = $request->input('filePath');
        
            if (file_exists($filePath)) {
                unlink($filePath);  // Eliminar el archivo
                return response()->json(['status' => 'ok']);
            }
        
            return response()->json(['status' => 'error'], 400);
        });

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