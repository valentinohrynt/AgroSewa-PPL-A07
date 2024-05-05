@extends('layouts.profil-layout')

@section('title', 'Edit Profil')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown active"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a class="active" href="{{ route('HalProfilKT()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="{{ route('logout') }}">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')
<section id="profile" class="profile">
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger mb-5">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger mb-5">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
        <div class="section-title">
            <h2>Profil</h2>
            <h6>Form Edit Profil</h6>
        </div>
        <form id="formEditProfil" action="{{route('SimpanEditProfilKT()')}}" method="POST">
            <a class="btn btn-info mb-2 text-white" href="{{ route('HalProfilKT()') }}"><i class="bi-arrow-left-square"></i> Kembali</a>
            @csrf
            @method('PUT')
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
                            <p class="designation"><input class="form-control" type="text" value="{{$lender->name}}" disabled></p>
                            <h6>NIK</h6>
                            <p class="designation"><input class="form-control" type="text" value="{{$lender->nik}}" disabled></p>
                            <h6>Nomor Telepon</h6>
                            <p class="designation"><input name="phone" class="form-control" type="tel" value="{{old('phone',$lender->phone)}}"></p>
                            <h6>Alamat Email</h6>
                            <p class="designation"><input name="email" class="form-control" type="email" value="{{old('email',$user->email)}}"></p>
                            <h6>Alamat</h6>
                            <p class="designation"><input name="street" class="form-control" type="text" value="{{old('street',$lender->street)}}"></p>
                            <p class="designation">
                                <select class="form-select form-control" name="district_id" id="district" class="">
                                    @foreach($districts as $district)
                                    <option value="{{ $district->id }}" @if(old('district_id', $lender->village->district->id) == $district->id) selected @endif>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="designation">
                                @php
                                $selectedVillageId = old('village_id', $lender->village_id);
                                @endphp
                                <select class="form-select form-control" name="village_id" id="village" style="cursor: not-allowed;" disabled>
                                    @foreach ($villages as $village)
                                    <option value="{{ $village->id }}" data-district="{{ $village->district_id }}" @if($selectedVillageId==$village->id) selected @endif>{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </p>
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
                            <p class="designation"><input name="username" class="form-control" type="text" value="{{old('username',$user->username)}}"></p>
                            <h6>Kata Sandi Lama</h6>
                            @php
                            $passwordLength = strlen($user->password);
                            $displayedPassword = str_repeat("-", $passwordLength);
                            @endphp
                            <p class="designation mb-2"><input name="oldPassword" class="form-control" type="password" placeholder="Masukkan Kata Sandi Lama Anda!"></p>
                            <p class="mx-2 pt-0 mt-0 small" style="color: red;">Wajib diisi!</p>
                            <h6>Kata Sandi Baru</h6>
                            <p class="designation mb-2"><input name="newPassword" class="form-control" type="password" placeholder="Masukkan Kata Sandi Baru Anda! (Min. 8 Karakter)"></p>
                            <p class="mx-2 pt-0 mt-0 small" style="color: orange;">Opsional / Tidak wajib diisi</p>

                            <p style="font-size: smaller; color: gray;">Keterangan: <br><br>Untuk melakukan perubahan profil dan atau kredensial login, Anda harus memasukkan kata sandi lama Anda.
                                <br><br>Jika Anda lupa kata sandi lama, Anda bisa melakukan logout dan lalu menekan lupa sandi pada halaman login.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success text-white"><i class="bi-floppy"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection