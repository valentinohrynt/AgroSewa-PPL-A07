@extends('layouts.bantuan-layout')

@section('title', 'Pengajuan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</span></a></li>
<li><a class="nav-link active" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilKT()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')
<section id="product-display" class="product-display">
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
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
            <h2>PENGAJUAN BANTUAN</h2>
            <h6>Silahkan unggah proposal pengajuan bantuan</h6>
        </div>
        <div class="row">
            <div class="col-md-4 mb-2">
                <div class="card" style="height: 50vh;">
                    <embed src="{{ asset('storage\proposal_template\template_proposal_pengajuan_alat.pdf') }}" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></embed>
                    <button class="btn btn-secondary"><i class="bi bi-file-pdf-fill"></i> Contoh Proposal</button>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="row px-5 py-5">
                        <div class="col">
                            @if (!$equipmentRequest -> isEmpty())
                            <div class="px-5 pb-5">
                                <div class="col pt-5">
                                    <div class="alert alert-danger">
                                        Anda masih memiliki pengajuan bantuan yang sedang diproses!
                                    </div>
                                </div>
                            </div>
                            @elseif ($equipmentRequest -> isEmpty())
                            <form action="{{ route('send-equipment-request-document') }}" method="post" role="form" class="px-5 pb-5" enctype="multipart/form-data">
                                @csrf
                                <div class="col pt-5">
                                    <div class="form-group">
                                        <label for="product_category_id" class="mb-2">Jenis alat</label>
                                        <select name="product_category_id" id="" class="form-select">
                                            @foreach ($productCategories as $productCategory)
                                            <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col pt-5">
                                    <label for="pdf_file" class="mb-2">Proposal</label>
                                    <div class="dropbox" id="dropbox">
                                        <input type="file" name="pdf_file" id="pdf_file" class="dropbox-input" accept=".pdf" />
                                        <label for="pdf_file" class="dropbox-label">
                                            <span class="dropbox-icon"><i class="bi bi-cloud-upload"></i></span>
                                            <span class="dropbox-text">Tarik dan lepas berkas di sini atau klik untuk memilih berkas</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="form-control btn btn-success mt-5">Kirim</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
