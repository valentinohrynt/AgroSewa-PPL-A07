@extends('layouts.profil-layout')

@section('title', 'Hal Data Akun Petani')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link active" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilKT()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')
<section id="profile" class="profile">
    <div class="container pt-5" data-aos="fade-up">
        <div class="section-title">
            <h2>Data Akun Petani</h2>
            <h6>Berikut adalah data akun petani <span style="color: green;">{{$borrower->name}}</span></h6>
        </div>
        <div class="d-flex justify-content-start mb-2">
            <a class="btn btn-secondary text-white" href="{{route('HalAkunPetaniKT()')}}"><i class="bi-box-arrow-left"></i> Kembali</a>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="profile-container wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="petani_thumb"><img src="{{asset('assets\img\user\default-img-profil-petani.png')}}" alt=""></div>
                    <div class="petani_info">
                        <h6 style="font-size: large;">Data Akun</h6>
                        <p style="font-size: large;" class="designation">Berikut adalah data Akun <span style="color:green;">{{$borrower->name}}</span></p>
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
                        <h6>Luas Lahan</h6>
                        <p class="designation"><input class="form-control" type="text" value="{{$borrower->land_area}} m2" disabled></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
