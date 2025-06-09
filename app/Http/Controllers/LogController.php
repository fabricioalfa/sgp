<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // traemos los últimos 50 logs junto con el usuario
        $logs = SystemLog::with('usuario')
                         ->orderBy('created_at', 'desc')
                         ->limit(50)
                         ->get();

        return view('logs.index', compact('logs'));
    }
}
