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
    /**
     * Mostrar el formulario de "Olvidé mi contraseña".
     */
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Procesar el envío del enlace de restablecimiento.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|exists:usuarios,correo_electronico',
        ]);

        $email   = $request->correo_electronico;
        $usuario = Usuario::where('correo_electronico', $email)->first();

        // Generar token de 64 caracteres
        $token = Str::random(64);

        // Insertar o actualizar el registro en password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email'      => $email],
            ['token'      => $token,
             'created_at' => Carbon::now()]
        );

        // Construir URL de restablecimiento
        $resetUrl = url("/password/restablecer?token={$token}&email=" . urlencode($email));

        // Enviar correo en texto plano
        Mail::raw(
            "Hola {$usuario->nombres},\n\n" .
            "Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n" .
            $resetUrl . "\n\n" .
            "Si no solicitaste este cambio, ignora este correo.\n\n" .
            "Saludos,\nEquipo de Soporte",
            function ($message) use ($email) {
                $message
                    ->to($email)
                    ->subject('Recuperación de contraseña');
            }
        );

        return back()->with('success', 'Te hemos enviado un enlace para restablecer tu contraseña.');
    }

    /**
     * Mostrar el formulario de restablecimiento con token.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('auth.passwords.reset', compact('token', 'email'));
    }

    /**
     * Procesar la actualización de la contraseña.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:usuarios,correo_electronico',
            'token'    => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Buscar el token en password_resets
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $reset) {
            return back()->with('error', 'Token inválido.');
        }

        // Verificar expiración (60 minutos)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->with('error', 'El enlace ha expirado. Solicita uno nuevo.');
        }

        // Actualizar la contraseña del usuario
        $usuario = Usuario::where('correo_electronico', $request->email)->first();
        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // Borrar el registro de reset
        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada correctamente.');
    }
}
