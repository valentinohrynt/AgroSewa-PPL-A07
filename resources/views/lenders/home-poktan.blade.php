@extends('layouts.home-layout')

@section('title', 'Home Poktan')

@section('navbar-nav')

<li><a class="nav-link active" href="home-poktan">Home</a></li>
<li><a class="nav-link" href="penyewaan-poktan">Penyewaan</a></li>
<li><a class="nav-link" href="pengajuan-poktan">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="riwayat-poktan">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Akun </span><i class="bi-person-circle"></i></a>
  <ul>
    <li><a href="#">Profil <i class="bi-person-circle"></i></a></li>
    <li><a href="logout">Logout <i class="bi-box-arrow-right"></i></a></li>
  </ul>
</li>

@endsection

@section('hero-btn')

<div class="col-xl-3 col-md-4">
    <div class="icon-box">
      <i class="ri-bar-chart-box-line"></i>
      <h3><a href="penyewaan-poktan">Penyewaan</a></h3>
    </div>
  </div>
<div class="col-xl-3 col-md-4">
    <div class="icon-box">
        <i class="ri-calendar-todo-line"></i>
        <h3><a href="">Pengajuan Bantuan</a></h3>
    </div>
</div>
<div class="col-xl-3 col-md-4">
    <div class="icon-box">
      <i class="ri-history-fill"></i>
      <h3><a href="riwayat-poktan">History</a></h3>
    </div>
  </div>

@endsection