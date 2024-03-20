<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('loginp', [AuthController::class,'loginp'])->name('loginp');
    Route::post('loginp', [AuthController::class,'authenticating_admin']);
    Route::get('login', [AuthController::class,'login'])->name('login');
    Route::post('login', [AuthController::class,'authenticating']);
    Route::get('register', [AuthController::class,'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class,'logout']);
    Route::get('homepage', [DashboardController::class,'homepage'])->middleware('only_borrower');
    Route::get('dashboard-admin', [DashboardController::class,'dashboardadmin'])->middleware('only_admin');
    Route::get('dashboard-pemerintah', [DashboardController::class,'dashboardpemerintah'])->middleware('only_government');
    Route::get('dashboard-poktan', [DashboardController::class,'dashboardpoktan'])->middleware('only_lender');
});