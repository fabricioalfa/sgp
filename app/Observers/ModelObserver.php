<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\SystemLog;

class ModelObserver
{
    public function created(Model $model)
    {
        $this->writeLog('created', $model);
    }

    public function updated(Model $model)
    {
        $this->writeLog('updated', $model);
    }

    public function deleted(Model $model)
    {
        $this->writeLog('deleted', $model);
    }

    protected function writeLog(string $action, Model $model)
    {
        // Obtener el usuario actual de la sesión
        $user = Session::get('usuario');

        SystemLog::create([
            'user_id'    => $user ? $user->id_usuario : null,
            'model'      => get_class($model),
            'model_id'   => $model->getKey(),
            'action'     => $action,
            'old_values' => $action !== 'created'
                              ? json_encode($model->getOriginal())
                              : null,
            'new_values' => $action !== 'deleted'
                              ? json_encode($model->getAttributes())
                              : null,
            'created_at' => now(),
        ]);
    }
}
