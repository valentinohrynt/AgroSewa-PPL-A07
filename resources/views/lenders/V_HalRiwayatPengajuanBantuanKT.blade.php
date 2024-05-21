@extends('layouts.riwayat-layout')

@section('title', 'Riwayat Pengajuan Poktan')

@section('navbar-nav')
<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link active" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
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
        <div class="section-title">
            <h2>Riwayat</h2>
            <h6>DAFTAR RIWAYAT PENGAJUAN BANTUAN</h6>
        </div>
        <div class="row pb-2 justify-content-between">
            <div class="col-4">
                <a href="{{route('HalRiwayatPenyewaanKT()')}}" class="btn btn-secondary"><i class="bi-arrow-left-square"></i> Kembali</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Pengajuan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Kategori Alat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipmentRequestLogs as $item)
                <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->equipmentRequest->equipment_request_number }}</td>
                    @php
                    $timestamp_created_at = $item->created_at;
                    $unix_timestamp = \Carbon\Carbon::parse($timestamp_created_at)->timestamp;
                    $timestamp_converted = \Carbon\Carbon::createFromTimestamp($unix_timestamp)->toDateString();
                    @endphp
                    <td>{{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}</td>
                    <td>{{ $item->equipmentRequest->productCategory->name }}</td>
                    <td>
                        @if($item->equipmentRequest->is_approved == 'accepted')
                        <p class="approval-status approved">Disetujui</p>
                        @endif
                        @if($item->equipmentRequest->is_approved == 'process')
                        <p class="approval-status in-process">Sedang diproses</p>
                        @endif
                        @if($item->equipmentRequest->is_approved == 'rejected')
                        <p class="approval-status rejected">Ditolak</p>
                        @endif
                    </td>
                </tr>
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Pengajuan Bantuan
                                </h5>
                            </div>
                            <div class="modal-body" style="height: 80vh; overflow-y: hidden;">
                                <p>Nomor Pengajuan:<br>{{ $item->equipmentRequest->equipment_request_number }}</p>
                                <p>Tanggal Pengajuan:<br>{{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}</p>
                                <p>Status:<br>
                                    @if($item->equipmentRequest->is_approved == 'accepted')
                                    <font style="color: green;">Disetujui</font>
                                    @endif
                                    @if($item->equipmentRequest->is_approved == 'process')
                                    <font style="color: orange;">Sedang diproses</font>
                                    @endif
                                    @if($item->equipmentRequest->is_approved == 'rejected')
                                    <font style="color: red">Ditolak</font>
                                    @endif
                                    <div class="pdf d-flex align-items-center justify-content-center">
                                        <embed src="{{ asset('storage/pdf_files/'.$item->equipmentRequest->pdf_file_name) }}" type="application/pdf" frameBorder="0" scrolling="auto" height="3000px" width="95%"></embed>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
