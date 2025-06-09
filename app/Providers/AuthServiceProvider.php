<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\UsuarioUserProvider;     // tu provider personalizado
use App\Models\Usuario;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Las políticas de modelo que registres (si usas).
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registra los policies y tu provider personalizado.
     */
    public function boot(): void
    {
        // 1) Esto sí existe aquí:
        $this->registerPolicies();

        // 2) Registrar tu provider "usuarios" que mapea "email"→"correo_electronico"
        Auth::provider('usuarios', function($app, array $config) {
            return new UsuarioUserProvider($app['hash'], $config['model']);
        });
    }
}
