@extends('layouts.riwayat-layout')

@section('title', 'Riwayat Pengajuan Poktan')

@section('navbar-nav')
<li><a class="nav-link" href="HomepageKT">Home</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link active" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Akun </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="#">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="logout">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>
@endsection

@section('content')
<section id="product-display" class="product-display">
    <div class="container pt-5" data-aos="fade-up">
        <div class="section-title">
            <h2>Riwayat</h2>
            <h6>DAFTAR RIWAYAT PENYEWAAN ALAT PERTANIAN</h6>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Pengajuan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Proposal Pengajuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipmentRequestLogs as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->equipmentRequest->equipment_request_number }}</td>
                    @php
                    $timestamp_created_at = $item->created_at;
                    $unix_timestamp = \Carbon\Carbon::parse($timestamp_created_at)->timestamp;
                    $timestamp_converted = \Carbon\Carbon::createFromTimestamp($unix_timestamp)->toDateString();
                    @endphp
                    <td>{{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#pdfModal{{ $item->id }}">
                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                        </button>
                    </td>
                    <td>
                        @if($item->equipmentRequest->is_approved == 'accepted')
                        <p>
                            <font style="color: green;">Disetujui</font>
                        </p>
                        @endif
                        @if($item->equipmentRequest->is_approved == 'process')
                        <p>
                            <font style="color: orange;">Sedang diproses</font>
                        </p>
                        @endif
                        @if($item->equipmentRequest->is_approved == 'rejected')
                        <p>
                            <font style="color: red">Ditolak</font>
                        </p>
                        @endif
                    </td>
                </tr>
                <div class="modal fade" id="pdfModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 100%; width: 90vh !important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdfModalLabel{{ $item->id }}">PROPOSAL PENGAJUAN BANTUAN
                                </h5>
                            </div>
                            <div class="modal-body" style="height: 80vh; overflow-y: hidden;">
                                <embed src="{{ asset('storage/pdf_files/'.$item->equipmentRequest->pdf_file_name) }}" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></embed>
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