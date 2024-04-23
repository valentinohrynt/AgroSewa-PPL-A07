<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_HomepageKT;
use App\Http\Controllers\C_DashboardSA;
use App\Http\Controllers\C_HalDataAlatKT;
use App\Http\Controllers\C_HalDataAlatSA;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\C_DashboardPemerintah;
use App\Http\Controllers\C_FormSewaAlat;
use App\Http\Controllers\C_HalPenyewaanKT;
use App\Http\Controllers\C_HalRiwayatPenyewaanKT;
use App\Http\Controllers\C_HalRiwayatPengajuanBantuanKT;
use App\Http\Controllers\C_HalPenyewaanSA;
use App\Http\Controllers\C_FormEditSewaAlat;
use App\Http\Controllers\C_FormEditDataAlat;
use App\Http\Controllers\C_FormTambahDataAlat;
use App\Http\Controllers\C_HalPengajuanBantuanKT;
use App\Http\Controllers\C_HalPengajuanBantuanPemerintah;
use App\Http\Controllers\C_HomepagePetani;
use App\Http\Controllers\C_HalDataPenyewaanSA;
use App\Http\Controllers\C_HalPenyewaanPetani;
use App\Http\Controllers\C_HalRiwayatPenyewaanPetani;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('login');
})->middleware('auth');

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerProcess']);
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
    Route::middleware('only_borrower')->group(function () {
        // PETANI / BORROWER START
        Route::get('HomepagePetani', [C_HomepagePetani::class, 'setHomepagePetani'])->middleware('verified');
        Route::get('/loading/HalPenyewaanPetani', [C_HomepagePetani::class, 'HalPenyewaanPetani'])->middleware('verified')->name('HalPenyewaanPetani()');
        Route::get('/loading/HalRiwayatPenyewaanPetani', [C_HomepagePetani::class, 'HalRiwayatPenyewaanPetani'])->middleware('verified')->name('HalRiwayatPenyewaanPetani()');

        Route::get('HalPenyewaanPetani', [C_HalPenyewaanPetani::class, 'setHalPenyewaanPetani'])->middleware('verified');
        Route::put('/cancel-transaction/{id}', [C_HalPenyewaanPetani::class, 'BatalPenyewaanPetani'])->name('BatalPenyewaanPetani()');
        Route::get('/loading/FormSewaAlat', [C_HalPenyewaanPetani::class, 'SewaAlat'])->middleware('verified')->name('SewaAlat()');

        Route::get('FormSewaAlat', [C_FormSewaAlat::class, 'setFormSewaAlat'])->middleware('verified');
        Route::post('FormSewaAlat', [C_FormSewaAlat::class, 'SewaAlat'])->middleware('verified')->name('SewaAlatPetani()');

        Route::get('HalRiwayatPenyewaanPetani', [C_HalRiwayatPenyewaanPetani::class, 'setHalRiwayatPenyewaanPetani'])->middleware('verified');
        // PETANI / BORROWER END
    });

    // SUPERADMIN START
    Route::get('DashboardSA', [C_DashboardSA::class, 'setDashboardSA'])->name('DashboardSA')->middleware('only_superadmin');
    Route::get('HalPenyewaanSA', [C_HalPenyewaanSA::class, 'setHalPenyewaanSA'])->name('HalPenyewaanSA')->middleware('only_superadmin');
    Route::post('HalDataPenyewaanSA', [C_HalDataPenyewaanSA::class, 'setHalDataPenyewaanSA'])->name('HalDataPenyewaanSA')->middleware('only_superadmin');
    Route::post('HalDataAlatSA', [C_HalDataAlatSA::class, 'setHalDataAlatSA'])->name('HalDataAlatSA')->middleware('only_superadmin');
    // SUPERADMIN END

    // GOVERNMENT START
    Route::get('DashboardPemerintah', [C_DashboardPemerintah::class, 'setDashboardPemerintah'])->middleware('only_government');
    Route::get('/loading/HalPengajuanBantuanPemerintah', [C_DashboardPemerintah::class, 'HalPengajuanBantuanPemerintah'])->middleware('only_government')->name('HalPengajuanBantuanPemerintah()');


    Route::patch('/accept-equipment-request/{id}', [C_HalPengajuanBantuanPemerintah::class, 'SetujuiPengajuanBantuan'])->name('SetujuiPengajuanBantuan()');
    Route::patch('/reject-equipment-request/{id}', [C_HalPengajuanBantuanPemerintah::class, 'TolakPengajuanBantuan'])->name('TolakPengajuanBantuan()');
    Route::get('HalPengajuanBantuanPemerintah', [C_HalPengajuanBantuanPemerintah::class, 'setHalPengajuanBantuanPemerintah'])->middleware('only_government');
    // GOVERNMENT END

    Route::middleware('only_lender')->group(function () {
        // POKTAN / LENDER START
        Route::get('HomepageKT', [C_HomepageKT::class, 'setHomepageKT']);
        Route::get('/loading/HalPenyewaanKT', [C_HomepageKT::class, 'HalPenyewaanKT'])->name('HalPenyewaanKT()');
        Route::get('/loading/HalPengajuanBantuanKT', [C_HomepageKT::class, 'HalPengajuanBantuanKT'])->name('HalPengajuanBantuanKT()');
        Route::get('/loading/HalRiwayatPenyewaanKT', [C_HomepageKT::class, 'HalRiwayatPenyewaanKT'])->name('HalRiwayatPenyewaanKT()');

        Route::get('HalPenyewaanKT', [C_HalPenyewaanKT::class, 'setHalPenyewaanKT']);
        Route::patch('/force-cancel-transaction/{id}', [C_HalPenyewaanKT::class, 'BatalPenyewaan'])->name('BatalPenyewaan()');
        Route::patch('/update-rent-transaction/{id}', [C_FormEditSewaAlat::class, 'EditSewaAlat'])->name('EditSewaAlat()');
        Route::patch('/complete-rent-transaction/{id}', [C_HalPenyewaanKT::class, 'SelesaiPenyewaan'])->name('SelesaiPenyewaan()');

        Route::get('/loading/HalDataAlatKT', [C_HalPenyewaanKT::class, 'DataAlatKT'])->name('DataAlatKT()');
        Route::get('HalDataAlatKT', [C_HalDataAlatKT::class, 'setHalDataAlatKT']);
        Route::post('/update-product/{id}', [C_FormEditDataAlat::class, 'EditDataAlat'])->name('EditDataAlat()');
        Route::post('HalDataAlatKT', [C_FormTambahDataAlat::class, 'TambahDataAlat'])->name('TambahDataAlat()');

        Route::get('HalPengajuanBantuanKT', [C_HalPengajuanBantuanKT::class, 'setHalPengajuanBantuanKT']);
        Route::post('HalPengajuanBantuanKT', [C_HalPengajuanBantuanKT::class, 'store'])->name('send-equipment-request-document');

        Route::get('HalRiwayatPenyewaanKT', [C_HalRiwayatPenyewaanKT::class, 'setHalRiwayatPenyewaanKT']);

        Route::get('/loading/HalRiwayatPengajuanBantuanKT', [C_HalRiwayatPenyewaanKT::class, 'RiwayatPengajuanBantuanKT'])->name('RiwayatPengajuanBantuanKT()');
        Route::get('HalRiwayatPengajuanBantuanKT', [C_HalRiwayatPengajuanBantuanKT::class, 'setHalRiwayatPengajuanBantuanKT']);
        // POKTAN / LENDER END
    });

    Route::get('logout', [AuthController::class, 'logout']);
});
