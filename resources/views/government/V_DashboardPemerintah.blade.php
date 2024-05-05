@extends('layouts.dashboard-layout')

@section('title', 'Dashboard Pemerintah')

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
  <ul>
    <li><a href="{{route('HalProfilPemerintah()')}}">Profil <i class="fas fa-user"></i></a></li>
    <li><a href="{{ route('logout') }}">
        <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
      </a></li>
  </ul>
</li>
@endsection

@section('sidebar')
<a href="#" class="logo">
  <i class="fa fa-user-tie"></i>
  <span class="text">Dinas TPHP</span>
</a>

<ul class="side-menu top">
  <li class="active">
    <a href="#" class="nav-link">
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

@section('content-head-title')

<div class="left">
  <h1>Dashboard</h1>
  <ul class="breadcrumb">
    <li>
      <a href="#">Dashboard</a>
    </li>
    <i class="fas fa-chevron-right"></i>
    <li>
      <a href="#" class="active">Home</a>
    </li>
  </ul>
</div>

@endsection

@section('content-box-info')
<li>
  <i class="fas fa-file-circle-question"></i>
  <span class="text">
    <h3>{{$countofApply}}</h3>
    <p>Pengajuan butuh disurvey</p>
  </span>
</li>
<li>
  <i class="fas fa-file-circle-check"></i>
  <span class="text">
    <h3>{{$countofDoneApply}}</h3>
    <p>Pengajuan selesai</p>
  </span>
</li>
<li>
  <i class="fas fa-user-group"></i>
  <span class="text">
    <h3>{{$countofBorrowers}}</h3>
    <p>Total Petani</p>
  </span>
</li>
<li>
  <i class="fas fa-user-group"></i>
  <span class="text">
    <h3>{{$countofLenders}}</h3>
    <p>Total Kelompok Tani</p>
  </span>
</li>
@endsection