<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_HomepageKT;
use App\Http\Controllers\C_DashboardSA;
use App\Http\Controllers\C_HalProfilKT;
use App\Http\Controllers\C_HalProfilSA;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\C_FormSewaAlat;
use App\Http\Controllers\C_HalRiwayatSA;
use App\Http\Controllers\C_HalDataAlatKT;
use App\Http\Controllers\C_HalDataAlatSA;
use App\Http\Controllers\C_HalPenyewaanKT;
use App\Http\Controllers\C_HalPenyewaanSA;
use App\Http\Controllers\C_HomepagePetani;
use App\Http\Controllers\C_HalProfilPetani;
use App\Http\Controllers\C_FormEditDataAlat;
use App\Http\Controllers\C_FormEditProfilKT;
use App\Http\Controllers\C_FormEditProfilSA;
use App\Http\Controllers\C_FormEditSewaAlat;
use App\Http\Controllers\C_HalAkunPenggunaSA;
use App\Http\Controllers\C_FormTambahDataAlat;
use App\Http\Controllers\C_HalDataPenyewaanSA;
use App\Http\Controllers\C_HalPenyewaanPetani;
use App\Http\Controllers\C_DashboardPemerintah;
use App\Http\Controllers\C_FormEditAkunKelompokTaniPemerintah;
use App\Http\Controllers\C_HalProfilPemerintah;
use App\Http\Controllers\C_FormEditProfilPetani;
use App\Http\Controllers\C_HalAkunPenggunaSA_KT;
use App\Http\Controllers\C_HalRiwayatPemerintah;
use App\Http\Controllers\C_HalPengajuanBantuanKT;
use App\Http\Controllers\C_HalRiwayatPenyewaanKT;
use App\Http\Controllers\C_HalRiwayatPenyewaanSA;
use App\Http\Controllers\C_FormEditProfilPemerintah;
use App\Http\Controllers\C_FormTambahAkunKelompokTaniPemerintah;
use App\Http\Controllers\C_FormTambahAkunPenggunaSA_Pemerintah;
use App\Http\Controllers\C_HalAkunKelompokTaniPemerintah;
use App\Http\Controllers\C_HalAkunPenggunaSA_Petani;
use App\Http\Controllers\C_HalDataAkunPenggunaSA_KT;
use App\Http\Controllers\C_HalRiwayatPenyewaanPetani;
use App\Http\Controllers\C_HalAkunPenggunaSA_Pemerintah;
use App\Http\Controllers\C_HalAkunPetaniKT;
use App\Http\Controllers\C_HalDataAkunKelompokTaniPemerintah;
use App\Http\Controllers\C_HalDataAkunPenggunaSA_Petani;
use App\Http\Controllers\C_HalRiwayatPengajuanBantuanKT;
use App\Http\Controllers\C_HalRiwayatPengajuanBantuanSA;
use App\Http\Controllers\C_HalPengajuanBantuanPemerintah;
use App\Http\Controllers\C_HalRiwayatPenyewaanPemerintah;
use App\Http\Controllers\C_HalDataAkunPenggunaSA_Pemerintah;
use App\Http\Controllers\C_HalDataAkunPetaniKT;
use App\Http\Controllers\C_HalDataPengajuanBantuanPemerintah;
use App\Http\Controllers\C_HalRiwayatPengajuanBantuanPemerintah;
use App\Http\Controllers\C_CheckEquipmentRequest;

Route::get('/', function () {
    return redirect()->route('login');
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

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect('HomepagePetani');
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::middleware('only_borrower')->group(function () {
        // PETANI / BORROWER START
        Route::get('HomepagePetani', [C_HomepagePetani::class, 'setHomepagePetani'])->name('HomepagePetani()');
        Route::get('/loading/HalPenyewaanPetani', [C_HomepagePetani::class, 'HalPenyewaanPetani'])->name('HalPenyewaanPetani()');
        Route::get('/loading/HalRiwayatPenyewaanPetani', [C_HomepagePetani::class, 'HalRiwayatPenyewaanPetani'])->name('HalRiwayatPenyewaanPetani()');
        Route::get('/loading/HalProfilPetani', [C_HomepagePetani::class, 'HalProfilPetani'])->name('HalProfilPetani()');

        Route::get('HalPenyewaanPetani', [C_HalPenyewaanPetani::class, 'setHalPenyewaanPetani']);
        Route::put('HalPenyewaanPetani/cancel-transaction/{id}', [C_HalPenyewaanPetani::class, 'BatalPenyewaanPetani'])->name('BatalPenyewaanPetani()');
        Route::get('/loading/HalPenyewaanPetani/FormSewaAlat', [C_HalPenyewaanPetani::class, 'SewaAlat'])->name('SewaAlat()');
        Route::get('HalPenyewaanPetani/FormSewaAlat/{product_id}', [C_FormSewaAlat::class, 'setFormSewaAlat'])->name('FormSewaAlat');
        Route::post('HalPenyewaanPetani/FormSewaAlat/SewaAlatPetani', [C_FormSewaAlat::class, 'SewaAlatPetani'])->name('SewaAlatPetani()');

        Route::get('HalRiwayatPenyewaanPetani', [C_HalRiwayatPenyewaanPetani::class, 'setHalRiwayatPenyewaanPetani']);

        Route::get('HalProfilPetani', [C_HalProfilPetani::class, 'setHalProfilPetani']);
        Route::get('loading/HalProfilPetani/FormEditProfilPetani', [C_HalProfilPetani::class, 'FormEditProfilPetani'])->name('EditProfilPetani()');
        Route::get('HalProfilPetani/FormEditProfilPetani', [C_FormEditProfilPetani::class, 'setFormEditProfilPetani']);
        Route::put('HalProfilPetani/FormEditProfilPetani/EditProfilPetani', [C_FormEditProfilPetani::class, 'EditProfilPetani'])->name('SimpanEditProfilPetani()');
        // PETANI / BORROWER END
    });

    Route::middleware('only_superadmin')->group(function () {
        // SUPERADMIN START
        Route::get('DashboardSA', [C_DashboardSA::class, 'setDashboardSA'])->name('DashboardSA()');
        Route::get('/loading/HalPenyewaanSA', [C_DashboardSA::class, 'HalPenyewaanSA'])->name('HalPenyewaanSA()');
        Route::get('/loading/HalRiwayatSA', [C_DashboardSA::class, 'HalRiwayatSA'])->name('HalRiwayatSA()');
        Route::get('/loading/HalProfilSA', [C_DashboardSA::class, 'HalProfilSA'])->name('HalProfilSA()');
        Route::get('/loading/HalAkunPenggunaSA', [C_DashboardSA::class, 'HalAkunPenggunaSA'])->name('HalAkunPenggunaSA()');

        Route::get('HalPenyewaanSA', [C_HalPenyewaanSA::class, 'setHalPenyewaanSA']);
        Route::post('HalPenyewaanSA/HalDataPenyewaanSA', [C_HalDataPenyewaanSA::class, 'setHalDataPenyewaanSA'])->name('HalDataPenyewaanSA');
        Route::post('HalPenyewaanSA/HalDataPenyewaanSA/HalDataAlatSA', [C_HalDataAlatSA::class, 'setHalDataAlatSA'])->name('HalDataAlatSA');

        Route::get('HalRiwayatSA', [C_HalRiwayatSA::class, 'setHalRiwayatSA']);
        Route::post('HalRiwayatSA/HalRiwayatPenyewaanSA', [C_HalRiwayatPenyewaanSA::class, 'setHalRiwayatPenyewaanSA'])->name('HalRiwayatPenyewaanSA()');
        Route::post('HalRiwayatSA/HalRiwayatPenyewaanSA/HalRiwayatPengajuanBantuanSA', [C_HalRiwayatPengajuanBantuanSA::class, 'setHalRiwayatPengajuanBantuanSA'])->name('HalRiwayatPengajuanBantuanSA()');

        Route::get('HalProfilSA', [C_HalProfilSA::class, 'setHalProfilSA']);
        Route::get('loading/HalProfilSA/FormEditProfilSA', [C_HalProfilSA::class, 'FormEditProfilSA'])->name('EditProfilSA()');
        Route::get('HalProfilSA/FormEditProfilSA', [C_FormEditProfilSA::class, 'setFormEditProfilSA']);
        Route::put('HalProfilSA/FormEditProfilSA/EditProfilSA', [C_FormEditProfilSA::class, 'EditProfilSA'])->name('SimpanEditProfilSA()');

        Route::get('HalAkunPenggunaSA', [C_HalAkunPenggunaSA::class, 'setHalAkunPenggunaSA']);
        Route::get('/loading/HalAkunPenggunaSA/AkunPemerintah', [C_HalAkunPenggunaSA::class, 'HalAkunPenggunaSA_Pemerintah'])->name('HalAkunPenggunaSA_Pemerintah()');
        Route::get('/loading/HalAkunPenggunaSA/AkunKT', [C_HalAkunPenggunaSA::class, 'HalAkunPenggunaSA_KT'])->name('HalAkunPenggunaSA_KT()');
        Route::get('/loading/HalAkunPenggunaSA/AkunPetani', [C_HalAkunPenggunaSA::class, 'HalAkunPenggunaSA_Petani'])->name('HalAkunPenggunaSA_Petani()');

        Route::get('HalAkunPenggunaSA/AkunPemerintah', [C_HalAkunPenggunaSA_Pemerintah::class, 'setHalAkunPenggunaSA_Pemerintah']);
        Route::get('loading/HalAkunPenggunaSA/AkunPemerintah/FormTambahAkunPemerintah', [C_HalAkunPenggunaSA_Pemerintah::class, 'TambahAkunPemerintah'])->name('TambahAkunPemerintah()');
        Route::get('HalAkunPenggunaSA/AkunPemerintah/FormTambahAkunPemerintah', [C_FormTambahAkunPenggunaSA_Pemerintah::class, 'setFormTambahAkunPenggunaSA_Pemerintah'])->name('TambahAkunPemerintah');
        Route::post('HalAkunPenggunaSA/AkunPemerintah/FormTambahAkunPemerintah/SimpanAkunPemerintah', [C_FormTambahAkunPenggunaSA_Pemerintah::class, 'SimpanTambahAkunPemerintah'])->name('SimpanTambahAkunPemerintah()');

        Route::get('HalAkunPenggunaSA/AkunKT', [C_HalAkunPenggunaSA_KT::class, 'setHalAkunPenggunaSA_KT']);
        Route::get('HalAkunPenggunaSA/AkunPetani', [C_HalAkunPenggunaSA_Petani::class, 'setHalAkunPenggunaSA_Petani']);

        Route::get('/loading/HalAkunPenggunaSA/AkunPemerintah/{government_id}', [C_HalAkunPenggunaSA_Pemerintah::class, 'HalDataAkunPenggunaSA_Pemerintah'])->name('HalDataAkunPenggunaSA_Pemerintah()');
        Route::get('/loading/HalAkunPenggunaSA/AkunKT/{lender_id}', [C_HalAkunPenggunaSA_KT::class, 'HalDataAkunPenggunaSA_KT'])->name('HalDataAkunPenggunaSA_KT()');
        Route::get('/loading/HalAkunPenggunaSA/AkunPetani/{borrower_id}', [C_HalAkunPenggunaSA_Petani::class, 'HalDataAkunPenggunaSA_Petani'])->name('HalDataAkunPenggunaSA_Petani()');

        Route::get('HalAkunPenggunaSA/AkunPemerintah/{government_id}', [C_HalDataAkunPenggunaSA_Pemerintah::class, 'setHalDataAkunPenggunaSA_Pemerintah'])->name('HalDataAkunPenggunaSA_Pemerintah');
        Route::get('HalAkunPenggunaSA/AkunKT/{lender_id}', [C_HalDataAkunPenggunaSA_KT::class, 'setHalDataAkunPenggunaSA_KT'])->name('HalDataAkunPenggunaSA_KT');
        Route::get('HalAkunPenggunaSA/AkunPetani/{borrower_id}', [C_HalDataAkunPenggunaSA_Petani::class, 'setHalDataAkunPenggunaSA_Petani'])->name('HalDataAkunPenggunaSA_Petani');

        Route::get('/get_dynamic_content', [C_HalRiwayatPenyewaanSA::class, 'getDynamicContent'])->name('getDynamicContent()');
        // SUPERADMIN END
    });

    Route::middleware('only_government')->group(function () {
        // GOVERNMENT START
        Route::get('DashboardPemerintah', [C_DashboardPemerintah::class, 'setDashboardPemerintah'])->name('DashboardPemerintah()');
        Route::get('/loading/HalPengajuanBantuanPemerintah', [C_DashboardPemerintah::class, 'HalPengajuanBantuanPemerintah'])->name('HalPengajuanBantuanPemerintah()');
        Route::get('/loading/HalRiwayatPemerintah', [C_DashboardPemerintah::class, 'HalRiwayatPemerintah'])->name('HalRiwayatPemerintah()');
        Route::get('/loading/HalProfilPemerintah', [C_DashboardPemerintah::class, 'HalProfilPemerintah'])->name('HalProfilPemerintah()');
        Route::get('/loading/HalAkunKelompokTaniPemerintah', [C_DashboardPemerintah::class, 'HalAkunKelompokTaniPemerintah'])->name('HalAkunKelompokTaniPemerintah()');

        Route::get('HalPengajuanBantuanPemerintah', [C_HalPengajuanBantuanPemerintah::class, 'setHalPengajuanBantuanPemerintah']);
        Route::get('loading/HalPengajuanBantuanPemerintah/HalDataPengajuanBantuanPemerintah/{lender_id}', [C_HalPengajuanBantuanPemerintah::class, 'HalDataPengajuanBantuanPemerintah'])->name('HalDataPengajuanBantuanPemerintah()');
        Route::get('HalPengajuanBantuanPemerintah/HalDataPengajuanBantuanPemerintah/{lender_id}', [C_HalDataPengajuanBantuanPemerintah::class, 'setHalDataPengajuanBantuanPemerintah'])->name('HalDataPengajuanBantuanPemerintah');
        Route::patch('HalPengajuanBantuanPemerintah/HalDataPengajuanBantuanPemerintah/accept-equipment-request/{id}', [C_HalDataPengajuanBantuanPemerintah::class, 'SetujuiPengajuanBantuan'])->name('SetujuiPengajuanBantuan()');
        Route::patch('HalPengajuanBantuanPemerintah/HalDataPengajuanBantuanPemerintah/reject-equipment-request/{id}', [C_HalDataPengajuanBantuanPemerintah::class, 'TolakPengajuanBantuan'])->name('TolakPengajuanBantuan()');

        Route::get('HalRiwayatPemerintah', [C_HalRiwayatPemerintah::class, 'setHalRiwayatPemerintah']);
        Route::post('HalRiwayatPemerintah/HalRiwayatPenyewaanPemerintah', [C_HalRiwayatPenyewaanPemerintah::class, 'setHalRiwayatPenyewaanPemerintah'])->name('HalRiwayatPenyewaanPemerintah()');
        Route::post('HalRiwayatPemerintah/HalRiwayatPenyewaanPemerintah/HalRiwayatPengajuanBantuanPemerintah', [C_HalRiwayatPengajuanBantuanPemerintah::class, 'setHalRiwayatPengajuanBantuanPemerintah'])->name('HalRiwayatPengajuanBantuanPemerintah()');

        Route::get('HalProfilPemerintah', [C_HalProfilPemerintah::class, 'setHalProfilPemerintah']);
        Route::get('loading/HalProfilPemerintah/FormEditProfilPemerintah', [C_HalProfilPemerintah::class, 'FormEditProfilPemerintah'])->name('EditProfilPemerintah()');
        Route::get('HalProfilPemerintah/FormEditProfilPemerintah', [C_FormEditProfilPemerintah::class, 'setFormEditProfilPemerintah']);
        Route::put('HalProfilPemerintah/FormEditProfilPemerintah/EditProfilPemerintah', [C_FormEditProfilPemerintah::class, 'EditProfilPemerintah'])->name('SimpanEditProfilPemerintah()');

        Route::get('HalAkunKelompokTaniPemerintah', [C_HalAkunKelompokTaniPemerintah::class, 'setHalAkunKelompokTaniPemerintah']);
        Route::get('loading/HalAkunKelompokTaniPemerintah/HalDataAkunKelompokTaniPemerintah/{lender_id}', [C_HalAkunKelompokTaniPemerintah::class, 'HalDataAkunKelompokTaniPemerintah'])->name('HalDataAkunKelompokTaniPemerintah()');
        Route::get('HalAkunKelompokTaniPemerintah/HalDataAkunKelompokTaniPemerintah/{lender_id}', [C_HalDataAkunKelompokTaniPemerintah::class, 'setHalDataAkunKelompokTaniPemerintah'])->name('HalDataAkunKelompokTaniPemerintah');

        Route::get('/loading/HalAkunKelompokTaniPemerintah/FormEditAkunKelompokTaniPemerintah/{lender_id}', [C_HalAkunKelompokTaniPemerintah::class, 'EditAkunKelompokTaniPemerintah'])->name('EditAkunKelompokTaniPemerintah()');
        Route::get('HalAkunKelompokTaniPemerintah/FormEditAkunKelompokTaniPemerintah/{lender_id}', [C_FormEditAkunKelompokTaniPemerintah::class, 'setFormEditAkunKelompokTaniPemerintah'])->name('EditAkunKelompokTaniPemerintah');
        Route::get('HalAkunKelompokTaniPemerintah/FormEditAkunKelompokTaniPemerintah/SimpanEditAkunKelompokTani/{lender_id}', [C_FormEditAkunKelompokTaniPemerintah::class, 'SimpanEditAkunKelompokTani'])->name('SimpanEditAkunKelompokTani()');

        Route::get('/loading/HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah', [C_HalAkunKelompokTaniPemerintah::class, 'TambahAkunKelompokTaniPemerintah'])->name('TambahAkunKelompokTaniPemerintah()');
        Route::get('HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah', [C_FormTambahAkunKelompokTaniPemerintah::class, 'setFormTambahAkunKelompokTaniPemerintah'])->name('TambahAkunKelompokTaniPemerintah');
        Route::post('HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah/SimpanTambahAkunKelompokTani', [C_FormTambahAkunKelompokTaniPemerintah::class, 'SimpanTambahAkunKelompokTani'])->name('SimpanTambahAkunKelompokTani()');
        // GOVERNMENT END
    });

    Route::middleware('only_lender')->group(function () {
        // POKTAN / LENDER START
        Route::get('HomepageKT', [C_HomepageKT::class, 'setHomepageKT'])->name('HomepageKT()');
        Route::get('/loading/HalPenyewaanKT', [C_HomepageKT::class, 'HalPenyewaanKT'])->name('HalPenyewaanKT()');
        Route::get('/loading/HalPengajuanBantuanKT', [C_HomepageKT::class, 'HalPengajuanBantuanKT'])->name('HalPengajuanBantuanKT()');
        Route::get('/loading/HalRiwayatPenyewaanKT', [C_HomepageKT::class, 'HalRiwayatPenyewaanKT'])->name('HalRiwayatPenyewaanKT()');
        Route::get('/loading/HalProfilKT', [C_HomepageKT::class, 'HalProfilKT'])->name('HalProfilKT()');
        Route::get('/loading/HalAkunPetaniKT', [C_HomepageKT::class, 'HalAkunPetaniKT'])->name('HalAkunPetaniKT()');

        Route::get('HalPenyewaanKT', [C_HalPenyewaanKT::class, 'setHalPenyewaanKT']);
        Route::patch('HalPenyewaanKT/force-cancel-transaction/{id}', [C_HalPenyewaanKT::class, 'BatalPenyewaan'])->name('BatalPenyewaan()');
        Route::patch('HalPenyewaanKT/update-rent-transaction/{id}', [C_FormEditSewaAlat::class, 'EditSewaAlat'])->name('EditSewaAlat()');
        Route::patch('HalPenyewaanKT/complete-rent-transaction/{id}', [C_HalPenyewaanKT::class, 'SelesaiPenyewaan'])->name('SelesaiPenyewaan()');

        Route::get('/loading/HalPenyewaanKT/HalDataAlatKT', [C_HalPenyewaanKT::class, 'DataAlatKT'])->name('DataAlatKT()');
        Route::get('HalPenyewaanKT/HalDataAlatKT', [C_HalDataAlatKT::class, 'setHalDataAlatKT']);
        Route::post('HalPenyewaanKT/HalDataAlatKT/update-product/{id}', [C_FormEditDataAlat::class, 'EditDataAlat'])->name('EditDataAlat()');
        Route::post('HalPenyewaanKT/HalDataAlatKT/HalDataAlatKT', [C_FormTambahDataAlat::class, 'TambahDataAlat'])->name('TambahDataAlat()');

        Route::get('HalPengajuanBantuanKT', [C_HalPengajuanBantuanKT::class, 'setHalPengajuanBantuanKT']);
        Route::post('HalPengajuanBantuanKT', [C_HalPengajuanBantuanKT::class, 'store'])->name('send-equipment-request-document');

        Route::get('HalRiwayatPenyewaanKT', [C_HalRiwayatPenyewaanKT::class, 'setHalRiwayatPenyewaanKT']);

        Route::get('/loading/HalRiwayatPenyewaanKT/HalRiwayatPengajuanBantuanKT', [C_HalRiwayatPenyewaanKT::class, 'RiwayatPengajuanBantuanKT'])->name('RiwayatPengajuanBantuanKT()');
        Route::get('HalRiwayatPenyewaanKT/HalRiwayatPengajuanBantuanKT', [C_HalRiwayatPengajuanBantuanKT::class, 'setHalRiwayatPengajuanBantuanKT']);

        Route::get('HalProfilKT', [C_HalProfilKT::class, 'setHalProfilKT']);
        Route::get('loading/HalProfilKT/FormEditProfilKT', [C_HalProfilKT::class, 'FormEditProfilKT'])->name('EditProfilKT()');
        Route::get('HalProfilKT/FormEditProfilKT', [C_FormEditProfilKT::class, 'setFormEditProfilKT']);
        Route::put('HalProfilKT/FormEditProfilKT/EditProfilKT', [C_FormEditProfilKT::class, 'EditProfilKT'])->name('SimpanEditProfilKT()');

        Route::get('HalAkunPetaniKT', [C_HalAkunPetaniKT::class, 'setHalAkunPetaniKT']);
        Route::patch('HalAkunPetaniKT/{borrower_id}', [C_HalAkunPetaniKT::class, 'BlokirAkunPetani'])->name('BlokirAkunPetani()');
        Route::get('loading/HalAkunPetaniKT/HalDataAkunPetaniKT/{borrower_id}', [C_HalAkunPetaniKT::class, 'HalDataAkunPetaniKT'])->name('HalDataAkunPetaniKT()');
        Route::get('HalAkunPetaniKT/HalDataAkunPetaniKT/{borrower_id}', [C_HalDataAkunPetaniKT::class, 'setHalDataAkunPetaniKT'])->name('HalDataAkunPetaniKT');
        // POKTAN / LENDER END
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/blocked', [AuthController::class, 'blocked'])->name('blocked');
});

Route::get('/checkEquipmentRequestData', [C_CheckEquipmentRequest::class, 'check'])->name('checkEquipmentRequest()');
