<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    // function untuk mengirmklan email reset password
    public function sendResetLinkEmail(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // KIRIM LINK RESET PASSWORD
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }

    // show form reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }   

    // function untuk melakukan reset password
    public function reset(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // PROSES RESET PASSWORD
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }

    // function untuk menampilkan form forgot password
    public function showForgotForm()
    {
        return view('auth.forgot_password');
    }
}
