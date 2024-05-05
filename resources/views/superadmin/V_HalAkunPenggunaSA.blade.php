@extends('layouts.dashboard-layout')

@section('title', 'Akun Pengguna')

@section('sidebar')
<a href="#" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
    <li>
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
    <li>
        <a href="{{ route('HalPenyewaanSA()')}}" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
    <ul>
        <li><a href="{{route('HalProfilSA()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a href="{{ route('logout') }}">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('content-head-title')

<div class="left">
    <h1>Akun Pengguna</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Akun Pengguna</a>
        </li>
    </ul>
</div>

@endsection

@section('content-box-info')
<li class="clickable" data-url="{{route('HalAkunPenggunaSA_Pemerintah()')}}">
    <i class="fas fa-building-columns"></i>
    <span class="text">
        <h3>{{$countofGov}}</h3>
        <p>Akun Pemerintah</p>
    </span>
</li>
<li class="clickable" data-url="{{route('HalAkunPenggunaSA_KT()')}}">
    <i class="fas fa-people-group"></i>
    <span class="text">
        <h3>{{$countofLenders}}</h3>
        <p>Akun Kelompok Tani</p>
    </span>
</li>
<li class="clickable" data-url="{{route('HalAkunPenggunaSA_Petani()')}}">
    <i class="fas fa-person"></i>
    <span class="text">
        <h3>{{$countofBorrowers}}</h3>
        <p>Akun Petani</p>
    </span>
</li>
@endsection