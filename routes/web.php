<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
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

Route::get('login', [UserAuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('login', [UserAuthController::class, 'customLogin'])->name('login.custom');
Route::get('signup', [UserAuthController::class, 'registration'])->middleware('guest')->name('register-user');
Route::post('signup', [UserAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [UserAuthController::class, 'signOut'])->name('signout');


Route::get('dashboard', [UserDataController::class, 'index'])->middleware('verified')->name('dashboard');
Route::post('dashboard', [UserDataController::class, 'userDataModify'])->middleware('verified')->name('user.modify');
Route::get('courses', [CourseController::class, 'index'])->middleware('verified')->name('courses');
Route::get('enrol', [CourseController::class, 'enrollUser'])->middleware('verified')->name('enroll');

Route::get('admin', [AdminController::class, 'index'])->middleware('verified')->name('admin.dashboard');
Route::get('admin/users', [AdminController::class, 'users'])->middleware('verified')->name('admin.users');
Route::post('admin/users', [AdminController::class, 'userDataModify'])->middleware('verified')->name('admin.userModify');
Route::get('admin/users/delete', [AdminController::class, 'userDelete'])->middleware('verified')->name('admin.userDelete');
Route::post('admin/users/add', [AdminController::class, 'userAdd'])->middleware('verified')->name('admin.userAdd');
Route::get('admin/courses', [AdminController::class, 'courses'])->middleware('verified')->name('admin.courses');
Route::post('admin/courses', [AdminController::class, 'courseDataModify'])->middleware('verified')->name('admin.courseModify');
Route::get('admin/courses/delete', [AdminController::class, 'courseDelete'])->middleware('verified')->name('admin.courseDelete');
Route::post('admin/courses/add', [AdminController::class, 'courseAdd'])->middleware('verified')->name('admin.courseAdd');
Route::get('admin/courses/active', [AdminController::class, 'coursesActive'])->middleware('verified')->name('admin.coursesActive');
Route::get('admin/modules', [AdminController::class, 'modules'])->middleware('verified')->name('admin.modules');
Route::post('admin/modules/add', [AdminController::class, 'moduleAdd'])->middleware('verified')->name('admin.moduleAdd');
Route::get('admin/modules/delete', [AdminController::class, 'moduleDelete'])->middleware('verified')->name('admin.moduleDelete');
Route::get('admin/enrolments', [AdminController::class, 'enrolments'])->middleware('verified')->name('admin.enrolments');
Route::get('admin/enrolments/approve', [AdminController::class, 'enrolmentApprove'])->middleware('verified')->name('admin.enrolmentApprove');
Route::get('admin/enrolments/decline', [AdminController::class, 'enrolmentDecline'])->middleware('verified')->name('admin.enrolmentDecline');
Route::post('admin/enrolments/add', [AdminController::class, 'enrolmentAdd'])->middleware('verified')->name('admin.enrolmentAdd');
Route::get('admin/enrolments/pending', [AdminController::class, 'enrolmentsPending'])->middleware('verified')->name('admin.enrolmentsPending');
Route::get('admin/certifications', [AdminController::class, 'certifications'])->middleware('verified')->name('admin.certifications');
Route::post('admin/certifications', [AdminController::class, 'certificateDataModify'])->middleware('verified')->name('admin.certificateModify');
Route::post('admin/certifications/add', [AdminController::class, 'certificateAdd'])->middleware('verified')->name('admin.certificateAdd');
Route::get('admin/certifications/delete', [AdminController::class, 'certificateDelete'])->middleware('verified')->name('admin.certificateDelete');


Route::get('verify-certificate', [CertificateController::class, 'index'])->name('verifyCertificate');
Route::get('generate-transcript', [CertificateController::class, 'generateTranscriptPDF'])->name('generateTranscript');

Route::get('admin/courses/student-list', [AdminController::class, 'downloadCourseStudentsList'])->middleware('verified')->name('admin.downloadCourseStudentsList');
Route::get('admin/courses/certificate-list', [AdminController::class, 'downloadCourseCertificatesList'])->middleware('verified')->name('admin.downloadCourseCertificatesList');