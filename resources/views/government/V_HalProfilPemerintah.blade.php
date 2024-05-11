@extends('layouts.dashboard-profil-layout')

@section('title', 'Profil Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Profil</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardPemerintah()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalProfilPemerintah()')}}" class="active">Profil</a>
        </li>
    </ul>
</div>
@endsection

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
    <ul>
        <li class="active"><a href="{{route('HalProfilPemerintah()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('sidebar')
<a href="{{route('DashboardPemerintah()')}}" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Dinas TPHP</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="{{route('DashboardPemerintah()')}}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalAkunKelompokTaniPemerintah()')}}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Kelompok Tani</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="nav-link">
            <i class="fas fa-chart-simple"></i>
            <span class="text">Pengajuan Bantuan</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalRiwayatPemerintah()')}}" class="nav-link">
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
            <h3 style="text-align: center; padding-bottom: 1rem;">Profil</h3>
            <div class="profil">
                <h4>Nama</h4>
                <input type="text" value="{{$government->name}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat Email</h4>
                <input type="text" value="{{$user->email}}" disabled>
            </div>
            <div class="profil">
                <h4>Nomor HP</h4>
                <input type="text" value="{{$government->phone}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat</h4>
                <input type="text" value="{{$government->street}}, {{$government->village->name}}, {{$government->village->district->name}}" disabled>
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

@section('edit-button')
<a href="{{route('EditProfilPemerintah()')}}" class="btn btn-info">Edit Data Akun <i class="fa fa-pen-to-square"></i></a>
@endsection