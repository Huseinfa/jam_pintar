<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi user baru
    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'gender' => ['nullable', 'in:LakiLaki,Perempuan'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'city_id' => $validated['city_id'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
        ]);

        // Jangan auto-login, instruksikan user untuk verify email dulu
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pendaftaran berhasil! Silakan verifikasi email Anda terlebih dahulu sebelum login.',
                'success' => true,
            ]);
        }
        
        return redirect()->route('auth.login')->with('success', 'Pendaftaran berhasil! Silakan verifikasi email Anda terlebih dahulu sebelum login.');
    }
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // definition remember
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
                // dd('LOGIN CONTROLLER DIPANGGIL');

            $request->session()->regenerate();

            // dd(session()->all());

            // add untuk remember me, jika checkbox remember me dicentang maka session akan bertahan selama 7 hari
            // function remember()
            if ($remember) {
                // 7 hari dalam menit = 10080
                config(['session.lifetime' => 10080]);
                $request->session()->put('expires_at', now()->addDays(7));
            } else {
                // 3 hari dalam menit = 4320 (sudah default di session.php)
                $request->session()->put('expires_at', now()->addDays(3));
            }

            // Redirect berdasarkan role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('backoffice.index');
            }
<<<<<<< Updated upstream

            return redirect()->route('dashboard');
=======
            // Jika user berasal dari onboarding/pretest
            if (session()->has('pretest_done')) {
                // dd('PRETEST DETECTED');
                return redirect()->route('student.index');
            }
            // Default redirect
            return redirect()->intended(route('dashboard'));
>>>>>>> Stashed changes
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
