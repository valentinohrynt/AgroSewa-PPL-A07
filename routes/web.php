<?php

use App\Http\Controllers\HomepageKT;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormSewaAlat;
use App\Http\Controllers\HalDataAlatKT;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HalPenyewaanKT;
use App\Http\Controllers\HomepagePetani;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FormEditDataAlat;
use App\Http\Controllers\FormEditSewaAlat;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentLogController;
use App\Http\Controllers\HalPenyewaanPetani;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\RentTransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProductAndRentTransactionController;


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
    return redirect('HomepagePetani');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware('auth')->group(function () {

    // PETANI / BORROWER START
    Route::get('HomepagePetani', [HomepagePetani::class,'setHomepagePetani'])->middleware('only_borrower','verified');
    Route::get('/loading/HalPenyewaanPetani', [HomepagePetani::class,'HalPenyewaanPetani'])->middleware('only_borrower','verified')->name('HalPenyewaanPetani()');

    Route::get('HalPenyewaanPetani', [HalPenyewaanPetani::class,'setHalPenyewaanPetani'])->middleware('only_borrower','verified');
    Route::put('/cancel-transaction/{id}', [HalPenyewaanPetani::class,'cancelTransaction'])->name('cancel-transaction');
    // Route::get('penyewaan', [ProductAndRentTransactionController::class, 'showProductsAndRentTransactionstoPetani'])->middleware('only_borrower','verified');

    Route::get('FormSewaAlat', [FormSewaAlat::class, 'setFormSewaAlat'])->middleware('only_borrower','verified')->name('transaksi-penyewaan');
    Route::post('FormSewaAlat', [FormSewaAlat::class, 'store'])->middleware('only_borrower','verified');
    // PETANI / BORROWER END

    Route::get('dashboard-superadmin', [DashboardController::class,'dashboardsuperadmin'])->middleware('only_superadmin');
    Route::get('dashboard-pemerintah', [DashboardController::class,'dashboardpemerintah'])->middleware('only_government');

    // POKTAN / LENDER START
    Route::get('HomepageKT', [HomepageKT::class,'setHomepageKT'])->middleware('only_lender');
    Route::get('/loading/HalPenyewaanKT', [HomepageKT::class,'HalPenyewaanKT'])->middleware('only_lender')->name('HalPenyewaanKT()');

    Route::get('HalPenyewaanKT', [HalPenyewaanKT::class, 'setHalPenyewaanKT'])->middleware('only_lender');
    Route::put('/force-cancel-transaction/{id}', [HalPenyewaanKT::class, 'forceCancelTransaction'])->name('force-cancel-transaction');
    Route::post('/update-rent-transaction/{id}', [FormEditSewaAlat::class, 'update'])->name('update-rent-transaction');
    Route::post('/complete-rent-transaction/{id}', [HalPenyewaanKT::class, 'completeRent'])->middleware('only_lender')->name('complete-rent-transaction');

    Route::get('HalDataAlatKT', [HalDataAlatKT::class, 'setHalDataAlatKT'])->middleware('only_lender')->name('HalDataAlatKT');
    Route::post('/update-product/{id}', [FormEditDataAlat::class, 'update'])->name('update-product');
    Route::post('HalDataAlatKT', [ProductController::class, 'store'])->name('store-product');
    
    // Route::get('pengajuan-poktan', [PageController::class,'apply'])->middleware('only_lender');
    // Route::get('riwayat-poktan', [DashboardController::class,'homepoktan'])->middleware('only_lender');
    // POKTAN / LENDER END

    Route::get('logout', [AuthController::class,'logout']);
});