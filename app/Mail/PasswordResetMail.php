<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class PasswordResetController extends Controller
{
    /**
     * Show the "forgot password" form.
     */
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Handle a POST request to send the password reset link.
     */
    public function sendResetLink(Request $request)
    {
        // 1) Validate that the email exists in your usuarios table
        $request->validate([
            'correo_electronico' => 'required|email|exists:usuarios,correo_electronico',
        ]);

        // 2) Send the link via the "usuarios" broker, passing the user-column name
        $response = Password::broker() // defaults to 'usuarios' broker
            ->sendResetLink([
                'correo_electronico' => $request->correo_electronico,
            ]);

        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()->withErrors(['correo_electronico' => trans($response)]);
    }

    /**
     * Show the password reset form (with token).
     */
    public function showResetForm(string $token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Handle the submission of the new password.
     */
    public function updatePassword(Request $request)
    {
        // 1) Validate input
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|confirmed|min:8',
        ]);

        // 2) Attempt to reset the password
        $response = Password::broker()->reset(
            // map the password_resets 'email' back to Usuarios.correo_electronico:
            [
                'correo_electronico'    => $request->email,
                'password'              => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token'                 => $request->token,
            ],
            function (Usuario $user, string $password) {
                // callback: set the new password
                $user->contrasena = Hash::make($password);
                $user->save();

                // clean up the reset record:
                DB::table('password_resets')
                    ->where('email', $user->getEmailForPasswordReset())
                    ->delete();
            }
        );

        return $response === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }
}
