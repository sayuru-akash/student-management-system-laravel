<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return View::make('home');
});

Route::get('dashboard', [\App\Http\Controllers\UserAuthController::class, 'dashboard']);
Route::get('login', [\App\Http\Controllers\UserAuthController::class, 'index'])->name('login');
Route::post('custom-login', [\App\Http\Controllers\UserAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [\App\Http\Controllers\UserAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [\App\Http\Controllers\UserAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [\App\Http\Controllers\UserAuthController::class, 'signOut'])->name('signout');
