@extends('layouts.dashboard-profil-layout')

@section('title', 'Data Akun Pengguna Petani')

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
            <a href="{{ route ('HalAkunPenggunaSA_Petani()') }}">Daftar Akun Petani</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Data Akun Pengguna Petani {{$borrower->name}}</a>
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
    <img src="{{asset('assets/img/logo/agrosewa_logo.png')}}" id="logo-jemberkab" alt="">
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

@section('content-box-info')
<div class="box-info">
    <li style="display: flex; flex-direction: column; align-items: start;">
        <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-person"></i>
        <span class="text-profil">
            <h3 style="text-align: center; padding-bottom: 1rem;">Data Akun</h3>
            <div class="profil">
                <h4>Nama</h4>
                <input type="text" value="{{$borrower->name}}" disabled>
            </div>
            <div class="profil">
                <h4>NIK</h4>
                <input type="text" value="{{$borrower->nik}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat Email</h4>
                <input type="text" value="{{$user->email}}" disabled>
            </div>
            <div class="profil">
                <h4>Nomor HP</h4>
                <input type="text" value="{{$borrower->phone}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat</h4>
                <input type="text" value="{{$borrower->street}}, {{$borrower->village->name}}, {{$borrower->village->district->name}}" disabled>
            </div>
            <div class="profil">
                <h4>Luas Lahan</h4>
                <input type="text" value="{{$borrower->land_area}} m2" disabled>
            </div>
        </span>
    </li>
    <li style="display: flex; flex-direction: column; align-items: start;">
        <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-right-to-bracket"></i>
        <span class="text-kredensial">
            <h3 style="text-align: center; padding-bottom: 1rem;">Kredensial Login</h3>
            <div class="kredensial">
                <h4>Username</h4>
                <input type="text" value="{{$user->username}}" disabled>
            </div>
            <div class="kredensial">
                @php
                $passwordLength = strlen($user->password);
                $displayedPassword = str_repeat("-", $passwordLength);
                @endphp
                <h4>Kata Sandi</h4>
                <input type="password" value="{{$displayedPassword}}" disabled>
            </div>
        </span>
    </li>
</div>
@endsection