<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'authenticating']);

    Route::get('register', [AuthController::class,'register']);
    Route::post('register', [AuthController::class,'registerProcess']);

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordProcess'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPasswordProcess'])->name('password.update');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('home', [DashboardController::class,'home'])->middleware('only_borrower','verified');
    Route::get('dashboard-superadmin', [DashboardController::class,'dashboardsuperadmin'])->middleware('only_superadmin');
    Route::get('dashboard-pemerintah', [DashboardController::class,'dashboardpemerintah'])->middleware('only_government');
    Route::get('dashboard-poktan', [DashboardController::class,'dashboardpoktan'])->middleware('only_lender');
    Route::get('logout', [AuthController::class,'logout']);
});

Route::get('register', [RegisterController::class, 'showDistrictsandVillages'])->name('register');