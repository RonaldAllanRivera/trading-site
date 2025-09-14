<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;

// Public landing pages
Route::match(['GET', 'HEAD'], '/', function () {
    return view('landing.home');
})->name('home')->middleware(\App\Http\Middleware\CloakerMiddleware::class);
Route::view('/privacy', 'landing.privacy')->name('privacy');
Route::view('/terms', 'landing.terms')->name('terms');
Route::view('/cookie', 'landing.cookie')->name('cookie');
Route::view('/safe', 'landing.safe')->name('safe');
Route::view('/login', 'landing.login')->name('login');
Route::match(['GET', 'HEAD'], '/sign-up', function () {
    return view('landing.sign-up');
})->name('sign-up')->middleware(\App\Http\Middleware\CloakerMiddleware::class);

// Lead submissions
Route::post('/leads', [LeadsController::class, 'store'])->name('leads.store');
// Export leads CSV (admin check is performed in the controller)
Route::get('/leads/export', [LeadsController::class, 'exportCsv'])->name('leads.export');

// Authentication routes for public users
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset (forgot/reset)
Route::get('/forgot-password', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');

// Public user dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('landing.dashboard');
    })->name('dashboard');

    // Change password
    Route::get('/settings/password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/settings/password', [PasswordController::class, 'change'])->name('password.change.perform');
});
