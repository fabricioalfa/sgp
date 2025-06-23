<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SacramentoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\MisaController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\RrhhController;
use App\Http\Controllers\SacerdoteController;
use App\Http\Controllers\CebController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\LogController;

// ✅ Rutas públicas
Route::get('/', [ActividadController::class, 'portal'])->name('portal');
Route::get('/actividad/{actividad}', [ActividadController::class, 'mostrarPublico'])->name('actividades.public.show');

// Autenticación personalizada
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([CheckSession::class])->group(function () {
    Route::get('/panel', [PanelController::class, 'index'])->name('panel');
    Route::get('/perfil/editar', [PerfilController::class, 'editar'])->name('perfil.editar');
    Route::post('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::get('/perfil/cambiar-contraseña', [PanelController::class, 'showChangePassword'])->name('perfil.cambiar-contrasena');
    Route::post('/perfil/cambiar-contraseña', [PanelController::class, 'updatePassword'])->name('perfil.cambiar-contrasena.update');

    Route::resource('sacerdotes', SacerdoteController::class);
    Route::resource('cebs', CebController::class);
    Route::resource('misas', MisaController::class);
    Route::get('misas/{misa}/recibo', [MisaController::class, 'recibo'])->name('misas.recibo');
    Route::resource('sacramentos', SacramentoController::class);
    Route::get('sacramentos/{sacramento}/fieles', [SacramentoController::class, 'fielesForm'])->name('sacramentos.fieles');
    Route::post('sacramentos/{sacramento}/fieles', [SacramentoController::class, 'storeFieles'])->name('sacramentos.fieles.store');
    Route::get('sacramentos/{sacramento}/recibo', [SacramentoController::class, 'mostrarRecibo'])->name('sacramentos.recibo');
    Route::get('sacramentos/{sacramento}/familiares', [SacramentoController::class, 'formFamiliares'])->name('sacramentos.familiares.create');
    Route::post('sacramentos/{sacramento}/familiares', [SacramentoController::class, 'storeFamiliares'])->name('sacramentos.familiares.store');
    Route::get('/sacramentos/{sacramento}/familiares/edit', [SacramentoController::class, 'editFamiliares'])->name('sacramentos.familiares.edit');
    Route::put('sacramentos/{sacramento}/familiares', [SacramentoController::class, 'updateFamiliares'])->name('sacramentos.familiares.update');

    Route::resource('actividades', ActividadController::class)->parameters(['actividades' => 'actividad']);
    Route::resource('certificados', CertificadoController::class)->only(['index','create','store']);
    Route::post('certificados/eliminar-temp', [CertificadoController::class, 'eliminarTemporal'])->name('certificados.eliminarTemporal');
    Route::resource('finanzas', FinanzasController::class);
    Route::get('finanzas/reporte', [FinanzasController::class, 'generateReport'])->name('finanzas.reporte');
    Route::resource('ingresos', IngresoController::class);
    Route::get('ingresos/{ingreso}/generateRecibo', [IngresoController::class, 'generateRecibo'])->name('ingresos.generateRecibo');
    Route::resource('egresos', EgresoController::class);
    Route::get('egresos/informe', [EgresoController::class, 'generarInforme'])->name('egresos.informe');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('rrhh', RrhhController::class);
        Route::get('estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
        Route::get('reportes', [LogController::class,'index'])->name('reportes.index');

        Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups/run', [BackupController::class, 'run'])->name('backups.run');
        Route::get('/backups/download/{filename}', [BackupController::class, 'download'])->where('filename', '.*')->name('backups.download');
        Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->where('filename', '.*')->name('backups.destroy');
    });
});

// Recuperación de contraseña
Route::get('/password/solicitar',   [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/solicitar',  [PasswordResetController::class, 'sendResetLink'])->name('password.send');
Route::get('/password/restablecer', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/restablecer',[PasswordResetController::class, 'updatePassword'])->name('password.update');
