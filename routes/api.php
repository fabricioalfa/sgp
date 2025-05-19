<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventosApiController;

Route::get('/eventos', [EventosApiController::class, 'index']);
