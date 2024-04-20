<?php

use App\Http\Controllers\C_HomepageKT;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_DashboardSA;
use App\Http\Controllers\C_HalDataAlatKT;
use App\Http\Controllers\C_HalDataAlatSA;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\C_DashboardPemerintah;
use App\Http\Controllers\C_FormSewaAlat;
use App\Http\Controllers\C_HalPenyewaanKT;
use App\Http\Controllers\C_HalRiwayatKT;
use App\Http\Controllers\C_HalPenyewaanSA;
use App\Http\Controllers\C_FormEditSewaAlat;
use App\Http\Controllers\C_FormEditDataAlat;
use App\Http\Controllers\C_FormTambahDataAlat;
use App\Http\Controllers\C_HalBantuanKT;
use App\Http\Controllers\C_HomepagePetani;
use App\Http\Controllers\C_HalDataPenyewaanSA;
use App\Http\Controllers\C_HalPenyewaanPetani;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Routing\Route as RoutingRoute;

Route::get('/', function () {
    return view('login');
})->middleware('auth');

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'authenticating']);

    Route::get('register', [AuthController::class,'register'])->name('register');
    Route::post('register', [AuthController::class,'registerProcess']);
    Route::get('register', [AuthController::class, 'showDistrictsandVillages'])->name('register');

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
    Route::get('HomepagePetani', [C_HomepagePetani::class,'setHomepagePetani'])->middleware('only_borrower','verified');
    Route::get('/loading/HalPenyewaanPetani', [C_HomepagePetani::class,'HalPenyewaanPetani'])->middleware('only_borrower','verified')->name('HalPenyewaanPetani()');

    Route::get('HalPenyewaanPetani', [C_HalPenyewaanPetani::class,'setHalPenyewaanPetani'])->middleware('only_borrower','verified');
    Route::put('/cancel-transaction/{id}', [C_HalPenyewaanPetani::class,'cancelTransaction'])->name('cancel-transaction');

    Route::get('FormSewaAlat', [C_FormSewaAlat::class, 'setFormSewaAlat'])->middleware('only_borrower','verified')->name('transaksi-penyewaan');
    Route::post('FormSewaAlat', [C_FormSewaAlat::class, 'store'])->middleware('only_borrower','verified');
    // PETANI / BORROWER END

    // SUPERADMIN START
    Route::get('DashboardSA', [C_DashboardSA::class,'setDashboardSA'])->name('DashboardSA')->middleware('only_superadmin');
    Route::get('HalPenyewaanSA', [C_HalPenyewaanSA::class,'setHalPenyewaanSA'])->name('HalPenyewaanSA')->middleware('only_superadmin');
    Route::post('HalDataPenyewaanSA', [C_HalDataPenyewaanSA::class,'setHalDataPenyewaanSA'])->name('HalDataPenyewaanSA')->middleware('only_superadmin');
    Route::post('HalDataAlatSA', [C_HalDataAlatSA::class,'setHalDataAlatSA'])->name('HalDataAlatSA')->middleware('only_superadmin');
    // SUPERADMIN END

    Route::get('DashboardPemerintah', [C_DashboardPemerintah::class,'setDashboardPemerintah'])->middleware('only_government');

    // POKTAN / LENDER START
    Route::get('HomepageKT', [C_HomepageKT::class,'setHomepageKT'])->middleware('only_lender');
    Route::get('/loading/HalPenyewaanKT', [C_HomepageKT::class,'HalPenyewaanKT'])->middleware('only_lender')->name('HalPenyewaanKT()');

    Route::get('HalPenyewaanKT', [C_HalPenyewaanKT::class, 'setHalPenyewaanKT'])->middleware('only_lender');
    Route::put('/force-cancel-transaction/{id}', [C_HalPenyewaanKT::class, 'forceCancelTransaction'])->name('force-cancel-transaction');
    Route::post('/update-rent-transaction/{id}', [C_FormEditSewaAlat::class, 'update'])->name('update-rent-transaction');
    Route::post('/complete-rent-transaction/{id}', [C_HalPenyewaanKT::class, 'completeRent'])->middleware('only_lender')->name('complete-rent-transaction');

    Route::get('HalDataAlatKT', [C_HalDataAlatKT::class, 'setHalDataAlatKT'])->middleware('only_lender')->name('HalDataAlatKT');
    Route::post('/update-product/{id}', [C_FormEditDataAlat::class, 'update'])->name('update-product');
    Route::post('HalDataAlatKT', [C_FormTambahDataAlat::class, 'store'])->name('store-product');

    Route::get('HalBantuanKT', [C_HalBantuanKT::class, 'setHalBantuanKT'])->name('HalBantuanKT');
    
    Route::get('HalRiwayatKT', [C_HalRiwayatKT::class, 'setHalRiwayatKT'])->name('HalRiwayatKT');
    
    // POKTAN / LENDER END

    Route::get('logout', [AuthController::class,'logout']);
});