<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackofficeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\TestSubmissionController;
use App\Http\Controllers\Api\CityController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\ResultController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\CityController as BackofficeCityController;

// ─── Public ───────────────────────────────────────────────────────────────────

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Compatibility route for Laravel auth middleware redirect
// Some middleware redirects to route('login') when unauthenticated.
// We map it to the landing page and add a query flag to trigger the modal.
Route::get('/login', function () {
    return redirect()->to(route('dashboard') . '?showLogin=1');
})->name('login');

// ─── Auth ─────────────────────────────────────────────────────────────────────
// forget password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Registrasi
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// ─── Feedback Routes ───────────────────────────────────────────────────────────
Route::get('/feedback/{token}', [FeedbackController::class, 'showForm'])->middleware('auth')->name('feedback.form');  // Require auth
Route::post('/feedback/{token}', [FeedbackController::class, 'submitFeedback'])->middleware('auth')->name('feedback.submit');

// route untuk onboarding questionenr sebelum login
Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
Route::post('/onboarding/submit', [OnboardingController::class, 'submit'])->name('pretest.submit');


// ─── Student Routes (Authenticated Only) ───────────────────────────────────────

Route::prefix('student')
    ->middleware('auth')
    ->name('student.')
    ->group(function () {
        Route::get('/instruction', [InstructionController::class, 'index'])->name('index');
        Route::get('/test', [TestController::class, 'index'])->name('test');
        Route::post('/test/submit', [TestController::class, 'submit'])->name('test.submit');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/feedback/reminders', [FeedbackController::class, 'listPendingReminders'])->name('feedback.reminders');
        // try and eror route untuk google calendar
        Route::get('/calendar/{result}', [ResultController::class, 'googleCalendar'])->name('calendar');
    });

// routeuntuk menampilkan hasil rekomendasi berdasarkan test attempt id
Route::get('/result/{attemptId}', [ResultController::class, 'downloadPdf'])->name('result.pdf');

// ─── Backoffice (admin only) ───────────────────────────────────────────────────

Route::prefix('backoffice')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('backoffice.')
    ->group(function () {
        Route::get('/', [BackofficeController::class, 'index'])->name('index');
        Route::get('/question', [QuestionController::class, 'index'])->name('question');
        Route::get('/question/create', [QuestionController::class, 'create'])->name('question.create');
        Route::post('/question', [QuestionController::class, 'store'])->name('questions.store');
        Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
        Route::get('/question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
        Route::put('/question/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::get('/question/{question}', [QuestionController::class, 'show'])->name('question.show');

        // Cities Routes
        Route::get('/cities', [BackofficeCityController::class, 'index'])->name('cities');
        Route::get('/cities/create', [BackofficeCityController::class, 'create'])->name('cities.create');
        Route::post('/cities', [BackofficeCityController::class, 'store'])->name('cities.store');
        Route::get('/cities/{city}', [BackofficeCityController::class, 'show'])->name('cities.show');
        Route::get('/cities/{city}/edit', [BackofficeCityController::class, 'edit'])->name('cities.edit');
        Route::put('/cities/{city}', [BackofficeCityController::class, 'update'])->name('cities.update');
        Route::delete('/cities/{city}', [BackofficeCityController::class, 'destroy'])->name('cities.destroy');
    });
