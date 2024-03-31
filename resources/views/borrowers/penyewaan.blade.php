@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan')

@section('navbar-nav')

<li><a class="nav-link" href="home">Home</a></li>
<li><a class="nav-link active" href="penyewaan">Penyewaan</a></li>
<li><a class="nav-link" href="riwayat">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Akun </span><i class="bi-person-circle"></i></a>
  <ul>
    <li><a href="#">Profil <i class="bi-person-circle"></i></a></li>
    <li><a href="logout">Logout <i class="bi-box-arrow-right"></i></a></li>
  </ul>
</li>

@endsection

@section('content')

@endsection