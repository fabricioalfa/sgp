<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Usuario;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
        ]);

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();

        if (!$usuario) {
            return back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['correo_electronico' => $request->correo_electronico],
            ['token' => $token, 'creado_en' => Carbon::now()]
        );

        // Enviar correo con enlace
        Mail::raw("Haz clic en el siguiente enlace para restablecer tu contraseña:\n" .
            url('/password/restablecer?token=' . $token . '&correo=' . $request->correo_electronico), 
            function($message) use ($request) {
                $message->to($request->correo_electronico);
                $message->subject('Recuperación de contraseña');
            });

        return back()->with('success', 'Te hemos enviado un enlace para restablecer tu contraseña.');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $correo = $request->query('correo');

        return view('auth.passwords.reset', compact('token', 'correo'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
            'token' => 'required',
            'contrasena' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('correo_electronico', $request->correo_electronico)
            ->where('token', $request->token)
            ->first();

        if (!$reset || Carbon::parse($reset->creado_en)->addMinutes(60)->isPast()) {
            return back()->with('error', 'Token inválido o expirado.');
        }

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();

        if (!$usuario) {
            return back()->with('error', 'Usuario no encontrado.');
        }

        $usuario->contrasena = Hash::make($request->contrasena);
        $usuario->save();

        DB::table('password_resets')->where('correo_electronico', $request->correo_electronico)->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada correctamente.');
    }
}
