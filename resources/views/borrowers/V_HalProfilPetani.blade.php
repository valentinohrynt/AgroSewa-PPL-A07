@extends('layouts.profil-layout')

@section('title', 'Profil')

@section('navbar-nav')

<li><a class="nav-link active" href="{{route('HomepagePetani()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanPetani()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanPetani()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilPetani()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="{{ route('logout') }}">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')
<section id="profile" class="profile">
    <div class="container pt-5" data-aos="fade-up">
        <div class="section-title">
            <h2>Profil</h2>
            <h6>Berikut adalah data akun anda</h6>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="profile-container wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="petani_thumb"><img src="{{asset('assets\img\user\default-img-profil-petani.png')}}" alt=""></div>
                    <div class="petani_info">
                        <h6>Data Profil</h6>
                        <p class="designation">Berikut adalah data profil Anda</p>
                    </div>
                    <div class="petani_input">
                        <h6>Nama</h6>
                        <p class="designation"><input class="form-control" type="text" value="{{$borrower->name}}" disabled></p>
                        <h6>NIK</h6>
                        <p class="designation"><input class="form-control" type="text" value="{{$borrower->nik}}" disabled></p>
                        <h6>Nomor Telepon</h6>
                        <p class="designation"><input class="form-control" type="tel" value="{{$borrower->phone}}" disabled></p>
                        <h6>Alamat Email</h6>
                        <p class="designation"><input class="form-control" type="email" value="{{$user->email}}" disabled></p>
                        <h6>Alamat</h6>
                        <p class="designation"><input class="form-control" type="text" value="{{$borrower->street}}, {{$borrower->village->name}}, {{$borrower->village->district->name}}" disabled></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="profile-container wow fadeInUp mb-3" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                    <div class="petani_thumb"><img src="{{asset('assets\img\user\default-img-kredensial-petani.png')}}" alt=""></div>
                    <div class="petani_info">
                        <h6>Data Kredensial Login</h6>
                        <p class="designation">Berikut adalah data kredensial login Anda</p>
                    </div>
                    <div class="petani_input">
                        <h6>Username</h6>
                        <p class="designation"><input class="form-control" type="text" value="{{$user->username}}" disabled></p>
                        <h6>Password</h6>
                        @php
                        $passwordLength = strlen($user->password);
                        $displayedPassword = str_repeat("-", $passwordLength);
                        @endphp
                        <p class="designation"><input class="form-control" type="password" value="{{$displayedPassword}}" disabled></p>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-info text-white" href="{{route('EditProfilPetani()')}}"><i class="bi-pencil-square"></i> Edit Data Akun</a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection