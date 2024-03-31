<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RentLogController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\RentTransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'authenticating']);

    Route::get('register', [AuthController::class,'register'])->name('register');
    Route::post('register', [AuthController::class,'registerProcess']);
    Route::get('register', [RegisterController::class, 'showDistrictsandVillages'])->name('register');

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
    Route::get('penyewaan', [PageController::class,'rent'])->middleware('only_borrower','verified');
    Route::get('dashboard-superadmin', [DashboardController::class,'dashboardsuperadmin'])->middleware('only_superadmin');
    Route::get('dashboard-pemerintah', [DashboardController::class,'dashboardpemerintah'])->middleware('only_government');

    // POKTAN / LENDER START
    Route::get('home-poktan', [DashboardController::class,'homepoktan'])->middleware('only_lender');
    Route::get('akun-poktan', [PageController::class,'account'])->middleware('only_lender');

    Route::get('penyewaan-poktan', [PageController::class,'rent'])->middleware('only_lender');
    Route::get('penyewaan-poktan', [RentTransactionController::class, 'showRentTransactions'])->middleware('only_lender');
    Route::post('/update-rent-transaction/{id}', [RentTransactionController::class, 'update'])->name('update-rent-transaction');
    Route::post('penyewaan-poktan', [RentLogController::class, 'completeRent'])->middleware('only_lender');

    Route::get('alat-poktan', [PageController::class, 'productslender'])->middleware('only_lender');
    Route::get('alat-poktan', [ProductController::class, 'showProducts']);
    Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('update-product');
    Route::post('alat-poktan', [ProductController::class, 'store'])->name('store-product');
    
    Route::get('pengajuan-poktan', [PageController::class,'apply'])->middleware('only_lender');
    Route::get('riwayat-poktan', [DashboardController::class,'homepoktan'])->middleware('only_lender');
    // POKTAN / LENDER END

    Route::get('logout', [AuthController::class,'logout']);
});