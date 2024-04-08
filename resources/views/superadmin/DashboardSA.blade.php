@extends('layouts.dashboard-layout')

@section('title', 'Dashboard Superadmin')

@section('sidebar')
<a href="#" class="logo">
  <i class="fa fa-user-tie"></i>
  <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
  <li class="active">
    <a href="#" class="nav-link">
      <i class="fa fa-dashboard"></i>
      <span class="text">Dashboard</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link">
      <i class="fas fa-people-group"></i>
      <span class="text">Akun</span>
    </a>
  </li>
  <li>
    <a href="HalPenyewaanSA" class="nav-link">
      <i class="fas fa-shopping-cart"></i>
      <span class="text">Penyewaan</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link">
      <i class="fas fa-chart-simple"></i>
      <span class="text">Pengajuan Bantuan</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link">
      <i class="fas fa-history"></i>
      <span class="text">Riwayat</span>
    </a>
  </li>
</ul>

<ul class="side-menu">
  <li>
    <a href="logout" class="logout">
      <i class="fas fa-right-from-bracket"></i>
      <span class="text">Logout</span>
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
  <i class="fas fa-calendar"></i>
  <span class="text">
    <h3>{{$countofTRT}}</h3>
    <p>Penyewaan baru</p>
  </span>
</li>
<li>
  <i class="fas fa-people-group"></i>
  <span class="text">
    <h3>{{$countofTNU}}</h3>
    <p>Pengguna baru</p>
  </span>
</li>
<li>
  <i class="fas fa-calendar-check"></i>
  <span class="text">
    <h3>{{$countofART}}</h3>
    <p>Total Penyewaan</p>
  </span>
</li>
<li>
  <i class="fas fa-user-check"></i>
  <span class="text">
    <h3>{{$countofAU}}</h3>
    <p>Total Pengguna</p>
  </span>
</li>
@endsection