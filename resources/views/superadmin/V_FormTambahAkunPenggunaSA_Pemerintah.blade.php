@extends('layouts.dashboard-profil-layout')

@section('title', 'Tambah Akun Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Akun Pengguna</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route ('HalAkunPenggunaSA()') }}" class="">Akun Pengguna</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route ('HalAkunPenggunaSA_Pemerintah()') }}">Daftar Akun Pemerintah</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Tambah Akun Pemerintah</a>
        </li>
    </ul>
</div>
@endsection

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
    <ul>
        <li><a href="{{route('HalProfilSA()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('sidebar')
<a href="#" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="{{ route ('DashboardSA()') }}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route ('HalAkunPenggunaSA()') }}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Pengguna</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalPenyewaanSA()')}}" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('back-button')
<div class="box-info" style="display:flex; justify-content: flex-start;">
    <form id="" action="{{ route ('HalAkunPenggunaSA_Pemerintah()') }}">
        @csrf
        <button class="btn btn-info" style="width: 10rem;"><i class="fa fa-arrow-left"></i> Kembali</button>
    </form>
</div>
@endsection

@section('content-box-info')
<form id="formEditProfil" action="{{route('SimpanTambahAkunPemerintah()')}}" method="post">
    @csrf
    <div class="box-info">
        <li style="display: flex; flex-direction: column; align-items: start;">
            <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-person"></i>
            <span class="text-profil">
                <h3 style="text-align: center; padding-bottom: 1rem;">Data Akun</h3>
                <div class="profil">
                    <h4>Nama</h4>
                    <input type="text" name="name" placeholder="Masukkan nama">
                </div>
                <div class="profil">
                    <h4>Alamat Email</h4>
                    <input type="email" name="email" placeholder="Masukkan alamat email">
                </div>
                <div class="profil">
                    <h4>Nomor HP</h4>
                    <input type="tel" name="phone" placeholder="Masukkan nomor HP Aktif">
                </div>
                <div class="profil">
                    <h4>Alamat</h4>
                    <select name="district_id" id="district" class="">
                        <option>Pilih Kecamatan</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <select name="village_id" id="village" style="cursor: not-allowed;" disabled>
                        <option>Pilih Desa</option>
                        @foreach ($villages as $village)
                        <option value="{{ $village->id }}" data-district="{{ $village->district_id }}">{{ $village->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="street" placeholder="Masukkan alamat (nama jalan)">
                </div>
            </span>
        </li>
        <li style="display: flex; flex-direction: column; align-items: start;">
            <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-right-to-bracket"></i>
            <span class="text-kredensial">
                <h3 style="text-align: center; padding-bottom: 1rem;">Kredensial Login</h3>
                <div class="kredensial">
                    <h4>Username</h4>
                    <input type="text" name="username" placeholder="Masukkan kata username">
                </div>
                <div class="kredensial">
                    <h4>Kata Sandi</h4>
                    <input type="password" name="password" placeholder="Masukkan kata sandi minimal 8 karakter">
                </div>
            </span>
        </li>
    </div>
    <div class="edit-button">
        <button type="submit" class="btn btn-success">Simpan <i class="fas fa-floppy-disk" style="padding-left: 1rem;"></i> </button>
    </div>
</form>
@endsection