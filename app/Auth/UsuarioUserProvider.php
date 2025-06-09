<?php
// app/Auth/UsuarioUserProvider.php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class UsuarioUserProvider extends EloquentUserProvider
{
    /**
     * Cuando Laravel hace retrieveByCredentials(['email'=>xxx]),
     * lo convertimos en where('correo_electronico', xxx) para tu tabla.
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (isset($credentials['email'])) {
            $credentials['correo_electronico'] = $credentials['email'];
            unset($credentials['email']);
        }

        return parent::retrieveByCredentials($credentials);
    }
}
