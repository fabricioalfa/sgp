<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

// Modelos a auditar
use App\Models\Sacerdote;
use App\Models\Misa;
use App\Models\Sacramento;
use App\Models\Usuario;
use App\Models\Ingreso;
use App\Models\Egreso;

// Observer genérico
use App\Observers\ModelObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rutas API (si existen)
        if (file_exists(base_path('routes/api.php'))) {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        }

        // Registrar el observer para auditar cambios en estos modelos
        Sacerdote::observe(ModelObserver::class);
        Misa::observe(ModelObserver::class);
        Sacramento::observe(ModelObserver::class);
        Usuario::observe(ModelObserver::class);
        Ingreso::observe(ModelObserver::class);
        Egreso::observe(ModelObserver::class);
    }
}
