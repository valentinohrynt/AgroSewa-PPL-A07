@extends('layouts.dashboard-profil-layout')

@section('title', 'Edit Profil SA')

@section('content-head-title')
<div class="left">
    <h1>Profil</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalProfilSA()')}}">Profil</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Edit Data Akun</a>
        </li>
    </ul>
</div>
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
    <li>
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
    <li>
        <a href="{{route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('back-button')
<div class="box-info" style="display:flex; justify-content: flex-start;">
    <form id="" action="{{route('HalProfilSA()')}}">
        @csrf
        <input type="hidden" name="lender_id" value="">
        <button class="btn btn-info" style="width: 10rem;"><i class="fa fa-arrow-left"></i> Kembali</button>
    </form>
</div>
@endsection

@section('content-box-info')
<form id="formEditProfil" action="{{route('SimpanEditProfilSA()')}}" method="post">
    @csrf
    <div class="box-info">
        <li style="display: flex; flex-direction: column; align-items: start;">
            <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-person"></i>
            <span class="text-profil">
                <h3 style="text-align: center; padding-bottom: 1rem;">Profil</h3>
                <div class="profil">
                    <h4>Nama</h4>
                    <input type="text" name="name" value="{{old('name', $superadmin->name)}}">
                </div>
                <div class="profil">
                    <h4>Alamat Email</h4>
                    <input type="email" name="email" value="{{old('email',$user->email)}}">
                </div>
                <div class="profil">
                    <h4>Nomor HP</h4>
                    <input type="tel" name="phone" value="{{old('phone',$superadmin->phone)}}">
                </div>
                <div class="profil">
                    <h4>Alamat</h4>
                    <select name="district_id" id="district" class="">
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" @if(old('district_id', $superadmin->village->district->id) == $district->id) selected @endif>{{ $district->name }}</option>
                        @endforeach
                    </select>
                    @php
                    $selectedVillageId = old('village_id', $superadmin->village_id);
                    @endphp
                    <select name="village_id" id="village" style="cursor: not-allowed;" disabled>
                        @foreach ($villages as $village)
                        <option value="{{ $village->id }}" data-district="{{ $village->district_id }}" @if($selectedVillageId==$village->id) selected @endif>{{ $village->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="street" value="{{ old('address', $superadmin->street) }}">
                </div>
            </span>
        </li>
        <li style="display: flex; flex-direction: column; align-items: start;">
            <i style="width: 10rem; height: 10rem; font-size: 6rem; position:relative; left: 50%; transform: translateX(-50%);" class="fas fa-right-to-bracket"></i>
            <span class="text-kredensial">
                <h3 style="text-align: center; padding-bottom: 1rem;">Kredensial Login</h3>
                <div class="kredensial">
                    <h4>Username</h4>
                    <input type="text" name="username" value="{{ old('username', $user->username)}}">
                </div>
                <div class="kredensial">
                    @php
                    $passwordLength = strlen($user->password);
                    $displayedPassword = str_repeat("-", $passwordLength);
                    @endphp
                    <h4>Kata Sandi Lama</h4>
                    <input type="password" name="oldPassword" placeholder="Masukkan kata sandi lama Anda!">
                    <p style="padding-left: 0.8rem; font-size: smaller; color:red;">Wajib diisi</p>
                </div>
                <div class="kredensial">
                    <h4>Kata Sandi Baru</h4>
                    <input type="password" name="newPassword" placeholder="Masukkan kata sandi baru Anda!">
                    <p style="padding-left: 0.8rem; font-size: smaller; color:orange;">Opsional / Tidak wajib diisi</p>
                    <br>
                    <p style="font-size: smaller; color: gray;">Keterangan: <br>Untuk melakukan perubahan profil dan atau kredensial login, Anda harus memasukkan kata sandi lama Anda.
                        <br>Jika Anda lupa kata sandi lama, Anda bisa melakukan logout dan lalu menekan lupa sandi pada halaman login.
                    </p>
                </div>
            </span>
        </li>
    </div>
    <div class="edit-button">
        @method('PUT')
        <button type="submit" class="btn btn-success">Simpan Perubahan <i class="fas fa-floppy-disk" style="padding-left: 1rem;"></i> </button>
    </div>
</form>
@endsection