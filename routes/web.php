<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $request->route('id');
    $request->route('hash');

    if (!hash_equals((string)$request->route('id'), (string)$request->user()->getKey())) {
        throw new AuthorizationException;
    }

    if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
        throw new AuthorizationException;
    }

    if ($request->user()->hasVerifiedEmail()) {
        return redirect($this->redirectPath());
    }

    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }

    return redirect($this->redirectPath())->with('verified', true);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::group(['middleware' => ['throttle:6,1']], function () {
    Route::post('/email/verify/resend', [VerifyEmailController::class, 'resend'])->name('verification.resend');
});
Auth::routes(['verify' => true]);


Route::get('login', [UserAuthController::class, 'index'])->name('login');
Route::post('login', [UserAuthController::class, 'customLogin'])->name('login.custom');
Route::get('signup', [UserAuthController::class, 'registration'])->name('register-user');
Route::post('signup', [UserAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [UserAuthController::class, 'signOut'])->name('signout');


Route::get('dashboard', [UserAuthController::class, 'dashboard'])->middleware('verified')->name('dashboard');
