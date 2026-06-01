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
            'github_username' => ['required', 'string', 'max:255'],
            'allow_feedback_emails' => ['nullable', 'boolean'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'city_id' => $validated['city_id'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'github_username' => $validated['github_username'] ?? null,
            'allow_feedback_emails' => $validated['allow_feedback_emails'] ?? true,
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

            // Redirect berdasarkan role atau intended URL
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Redirect ke halaman yang user coba akses sebelumnya (feedback, etc)
            // Jika tidak ada, redirect sesuai role
            if ($user->isAdmin()) {
                return redirect()->intended(route('backoffice.index'));
            }

            // return redirect()->route('dashboard');
            // Jika user berasal dari onboarding/pretest
            if (session()->has('pretest_done')) {
                // dd('PRETEST DETECTED');
                return redirect()->route('student.index');
            }
            // Default redirect
            return redirect()->intended(route('dashboard'));
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

    // Di RegisteredUserController (atau AuthController) — setelah user berhasil dibuat:

    protected function registered(Request $request, $user)
    {
        if (session()->has('pretest_answers')) {
            // Simpan jawaban pretest ke DB
            $attempt = TestAttempt::create([
                'user_id' => $user->id,
                'type' => 'pretest', // ← tambah kolom ini di migration
                'started_at' => now(),
                'finished_at' => now(),
            ]);
            foreach (session('pretest_answers') as $questionId => $answer) {
                Answer::create([
                    'question_id' => $questionId,
                    'test_attempt_id' => $attempt->id,
                    'answer' => $answer,
                ]);
            }
            session()->forget(['pretest_answers', 'pretest_done']);
        }
        return redirect()->route('student.index');
    }
}
