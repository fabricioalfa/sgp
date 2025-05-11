<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Usuario; // tu modelo de usuarios

class PasswordResetController extends Controller
{
    // 1) Mostrar formulario para solicitar el enlace
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    // 2) Enviar el enlace al email
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        $token = Str::random(64);

        // Guardar (o actualizar) el token
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        // Construir URL de reset
        $url = url("/password/restablecer?token={$token}&email=" . urlencode($request->email));

        // Enviar correo
        Mail::send('emails.password_reset', ['url' => $url], function($m) use ($request) {
            $m->to($request->email)
              ->subject('Restablecer contraseña');
        });

        return back()->with('status', 'Te hemos enviado por email el enlace para restablecer tu contraseña.');
    }

    // 3) Mostrar formulario para poner la nueva contraseña
    public function showResetForm(Request $request)
    {
        return view('auth.passwords.reset', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    // 4) Validar y actualizar la contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email|exists:usuarios,email',
            'password'              => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'El enlace no es válido o ha expirado.']);
        }

        // Opcional: caducidad de 60 minutos
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'El enlace ha expirado.']);
        }

        // Actualizar contraseña
        Usuario::where('email', $request->email)
               ->update(['password' => Hash::make($request->password)]);

        // Borrar token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida correctamente.');
    }
}