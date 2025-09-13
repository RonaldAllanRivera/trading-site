<?php

use Illuminate\Support\Facades\Route;

// Public landing pages
Route::view('/', 'landing.home')->name('home');
Route::view('/privacy', 'landing.privacy')->name('privacy');
Route::view('/terms', 'landing.terms')->name('terms');
Route::view('/cookie', 'landing.cookie')->name('cookie');
Route::view('/login', 'landing.login')->name('login');
Route::view('/sign-up', 'landing.sign-up')->name('sign-up');
