@extends('layouts.dashboard-profil-layout')

@section('title', 'Data Akun Pengguna Kelompok Tani')

@section('content-head-title')
<div class="left">
    <h1>Akun Kelompok Tani</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{route('DashboardPemerintah()')}}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalAkunKelompokTaniPemerintah()')}}">Akun Kelompok Tani</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Data Akun Kelompok Tani {{$lender->name}}</a>
        </li>
    </ul>
</div>
@endsection

@section('sidebar')
<a href="{{route('DashboardPemerintah()')}}" class="logo">
    <img src="{{asset('assets/img/logo/jemberkab_logo_original.png')}}" id="logo-jemberkab" alt="">
    <span id="text-logo">Dinas TPHP</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="{{route('DashboardPemerintah()')}}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{route('HalAkunKelompokTaniPemerintah()')}}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Kelompok Tani</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="nav-link">
            <i class="fas fa-chart-simple"></i>
            <span class="text">Pengajuan Bantuan <span id="penyewaan-dot" class="red-dot"></span></span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalRiwayatPemerintah()')}}" class="nav-link">
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
        <li><a href="{{route('HalProfilPemerintah()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('back-button')
<div class="box-info" style="display:flex; justify-content: flex-start;">
    <form id="" action="{{route('HalAkunKelompokTaniPemerintah()')}}">
        @csrf
        <input type="hidden" name="lender_id" value="">
        <button class="btn btn-info" style="width: 10rem;"><i class="fa fa-arrow-left"></i> Kembali</button>
    </form>
</div>
@endsection

@section('content-box-info')
<div class="box-info">
    <li style="display: flex; flex-direction: column; align-items: start;">
        <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-person"></i>
        <span class="text-profil">
            <h3 style="text-align: center; padding-bottom: 1rem;">Data Akun</h3>
            <div class="profil">
                <h4>Nama</h4>
                <input type="text" value="{{$lender->name}}" disabled>
            </div>
            <div class="profil">
                <h4>NIK</h4>
                <input type="text" value="{{$lender->nik}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat Email</h4>
                <input type="text" value="{{$user->email}}" disabled>
            </div>
            <div class="profil">
                <h4>Nomor HP</h4>
                <input type="text" value="{{$lender->phone}}" disabled>
            </div>
            <div class="profil">
                <h4>Alamat</h4>
                <input type="text" value="{{$lender->street}}, {{$lender->village->name}}, {{$lender->village->district->name}}" disabled>
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

@section('script')
<script>
    $(document).ready(function() {
        function checkEquipmentRequest() {
            $.ajax({
                url: '{{ route('checkEquipmentRequest()') }}'
                , method: 'GET'
                , success: function(response) {
                    
                    if (response === true) {
                        
                        $('#penyewaan-dot').css('display', 'inline-block');
                    } else {
                        $('#penyewaan-dot').css('display', 'none');
                    }
                }
                , error: function(xhr, status, error) {
                    $('#penyewaan-dot').css('display', 'none');
                    console.error('Error checking for new data:', error);
                }
            });
        }
        $('#penyewaan-dot').parent().click(function() {
            $('#penyewaan-dot').css('display', 'none');
        });
        setInterval(checkEquipmentRequest, 15000);
        checkEquipmentRequest();
    });

</script>
@endsection
