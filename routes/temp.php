<?php

Route::get('/loading/HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah/{lender_id}', [C_HalAkunKelompokTaniPemerintah::class, 'TambahAkunKelompokTaniPemerintah'])->name('TambahAkunKelompokTaniPemerintah()');
Route::get('HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah/{lender_id}', [C_FormTambahAkunKelompokTaniPemerintah::class, 'setFormTambahAkunKelompokTaniPemerintah'])->name('TambahAkunKelompokTaniPemerintah');
Route::get('HalAkunKelompokTaniPemerintah/FormTambahAkunKelompokTaniPemerintah/SimpanTambahAkunKelompokTani/{lender_id}', [C_FormTambahAkunKelompokTaniPemerintah::class, 'SimpanTambahAkunKelompokTani'])->name('SimpanTambahAkunKelompokTani()');