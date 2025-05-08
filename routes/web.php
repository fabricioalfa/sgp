<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\FinanzasController;

use App\Http\Middleware\CheckSession;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecretarioMiddleware;

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
        Route::get('/finanzas', [FinanzasController::class, 'index'])->name('finanzas.index');
        Route::get('/finanzas/ingreso/create', [FinanzasController::class, 'createIngreso'])->name('finanzas.create_ingreso');
        Route::post('/finanzas/ingreso', [FinanzasController::class, 'storeIngreso'])->name('finanzas.store_ingreso');
        Route::get('/finanzas/ingreso/{id}', [FinanzasController::class, 'showIngreso'])->name('finanzas.show_ingreso');
        Route::get('/finanzas/ingreso/{id}/edit', [FinanzasController::class, 'editIngreso'])->name('finanzas.edit_ingreso');
        Route::put('/finanzas/ingreso/{id}', [FinanzasController::class, 'updateIngreso'])->name('finanzas.update_ingreso');
        Route::delete('/finanzas/ingreso/{id}', [FinanzasController::class, 'destroyIngreso'])->name('finanzas.destroy_ingreso');

        Route::get('/finanzas/egreso/create', [FinanzasController::class, 'createEgreso'])->name('finanzas.create_egreso');
        Route::post('/finanzas/egreso', [FinanzasController::class, 'storeEgreso'])->name('finanzas.store_egreso');
        Route::get('/finanzas/egreso/{id}', [FinanzasController::class, 'showEgreso'])->name('finanzas.show_egreso');
        Route::get('/finanzas/egreso/{id}/edit', [FinanzasController::class, 'editEgreso'])->name('finanzas.edit_egreso');
        Route::put('/finanzas/egreso/{id}', [FinanzasController::class, 'updateEgreso'])->name('finanzas.update_egreso');
        Route::delete('/finanzas/egreso/{id}', [FinanzasController::class, 'destroyEgreso'])->name('finanzas.destroy_egreso');
    });

    // ✅ Rutas solo para SECRETARIO
    Route::middleware([SecretarioMiddleware::class])->group(function () {
        Route::resource('/sacerdotes', SacerdoteController::class);
        Route::resource('/cebs', CebController::class);
        Route::resource('/misas', MisaController::class);

        // Rutas para sacramentos
        Route::resource('/sacramentos', SacramentoController::class); // Asegúrate de tener esta ruta
        Route::resource('/bautizos', BautizoController::class);
        Route::resource('/comuniones', ComunionController::class);
        Route::resource('/confirmaciones', ConfirmacionController::class);
        Route::resource('/matrimonios', MatrimonioController::class);
    });
});

// 🔁 Recuperación de contraseña
Route::get('/password/solicitar', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/solicitar', [PasswordResetController::class, 'sendResetLink'])->name('password.send');
Route::get('/password/restablecer', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/restablecer', [PasswordResetController::class, 'updatePassword'])->name('password.update');
