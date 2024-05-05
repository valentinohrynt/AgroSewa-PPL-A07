@extends('layouts.dashboard-riwayat-layout')

@section('title', 'Riwayat Pengajuan Bantuan Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Riwayat</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{route('DashboardPemerintah()')}}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalRiwayatPemerintah()')}}">Daftar Kelompok Tani</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <form id="form_{{ $lender->id }}" action="{{ route('HalRiwayatPenyewaanPemerintah()') }}" method="post">
                @csrf
                <input type="hidden" name="lender_id" value="{{ $lender->id }}">
                <a onclick="submitForm('{{ $lender->id }}')" style="cursor:pointer;">Riwayat Penyewaan {{$lender->name}}</a>
            </form>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Riwayat Pengajuan Bantuan {{$lender->name}}</a>
        </li>
    </ul>
</div>
@endsection

@section('sidebar')
<a href="{{route('DashboardPemerintah()')}}" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Dinas TPHP</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="{{route('DashboardPemerintah()')}}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalAkunKelompokTaniPemerintah()')}}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Kelompok Tani</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="nav-link">
            <i class="fas fa-chart-simple"></i>
            <span class="text">Pengajuan Bantuan</span>
        </a>
    </li>
    <li class="active">
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
        <li><a href="{{ route('logout') }}">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('content-box-info')
<div class="box-info" style="display:flex; justify-content: flex-start;">
    <form id="form_{{ $lender->id }}" action="{{ route('HalRiwayatPenyewaanPemerintah()') }}" method="post">
        @csrf
        <input type="hidden" name="lender_id" value="{{ $lender->id }}">
        <button class="btn btn-info" onclick="submitForm('{{ $lender->id }}')" style="width: 10rem;"><i class="fa fa-arrow-left"></i> Kembali</button>
    </form>
</div>
@endsection

@section('content-table-data')
<div class="order">
    <div class="head">
        <h3>Pengajuan Bantuan Poktan {{$lender->name}}</h3>
        <div class="form-input">
            <input type="text" id="searchInput" placeholder="Pencarian" />
            <button type="button" id="searchBtn" class="search-btn">
                <i class="fas fa-search search-icon"></i>
            </button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Pengajuan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($equipmentRequestLogs -> isNotEmpty())
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
            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 80%; width: 90vh !important;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-size: larger;" id="detailModalLabel{{ $item->id }}">Detail Pengajuan Bantuan
                            </h5>
                        </div>
                        <div class="modal-body" style="height: 80vh; overflow-y: hidden;">
                            <h6>Nomor Pengajuan:</h6>
                            {{ $item->equipmentRequest->equipment_request_number }}
                            <br><br>
                            <h6>Tanggal Pengajuan:</h6>
                            {{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}
                            <br><br>
                            <h6>Nama Kelompok Tani:</h6>
                            {{ $item->equipmentRequest->lender->name }}
                            <br><br>
                            <h6>Status:</h6>
                            @if($item->equipmentRequest->is_approved == 'accepted')
                            <font style="color: green;">Disetujui</font>
                            @endif
                            @if($item->equipmentRequest->is_approved == 'process')
                            <font style="color: orange;">Sedang diproses</font>
                            @endif
                            @if($item->equipmentRequest->is_approved == 'rejected')
                            <font style="color: red">Ditolak</font>
                            @endif
                            <br><br>
                            <embed src="{{ asset('storage/pdf_files/'.$item->equipmentRequest->pdf_file_name) }}" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></embed>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        function filterRows(searchText) {
            $('.table tbody tr').each(function() {
                var transactionNumber = $(this).find('td:eq(1)').text().toLowerCase();
                var productName = $(this).find('td:eq(2)').text().toLowerCase();
                var borrowerName = $(this).find('td:eq(3)').text().toLowerCase();
                if (searchText === '' || transactionNumber.includes(searchText) || productName.includes(
                        searchText) || borrowerName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        $('#searchBtn').on('click', function() {
            var searchText = $('#searchInput').val().toLowerCase();
            filterRows(searchText);
        });
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            if (searchText === '') {
                $('.table tbody tr').show();
            }
        });
    });
</script>

@endsection