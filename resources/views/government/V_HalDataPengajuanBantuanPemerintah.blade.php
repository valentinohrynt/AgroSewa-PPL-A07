@extends('layouts.dashboard-pengajuanbantuan-layout')

@section('title', 'Pengajuan Bantuan Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Pengajuan Bantuan</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{route('DashboardPemerintah()')}}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalPengajuanBantuanPemerintah()')}}">Daftar Kelompok Tani</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            @php
            $encryptedLenderId = encrypt($lender->id);
            @endphp
            <a href="{{route('HalDataPengajuanBantuanPemerintah()',['lender_id'=> $encryptedLenderId])}}" class="active">Pengajuan Bantuan {{$lender->name}}</a>
        </li>
    </ul>
</div>
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
    <li class="active">
        <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="nav-link">
            <i class="fas fa-chart-simple"></i>
            <span class="text">Pengajuan Bantuan</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalRiwayatPemerintah()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('content-table-data')
<div class="order">
    <div class="head">
        <h3>Daftar Pengajuan Bantuan</h3>
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
                <th>Nama Poktan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipmentRequest as $item)
            <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->equipment_request_number }}</td>
                @php
                $timestamp_created_at = $item->created_at;
                $unix_timestamp = \Carbon\Carbon::parse($timestamp_created_at)->timestamp;
                $timestamp_converted = \Carbon\Carbon::createFromTimestamp($unix_timestamp)->toDateString();
                @endphp
                <td>{{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}</td>
                <td>{{ $item->lender->name }}</td>
                <td>
                    <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $item->id }}"><i class="fa fa-check"></i>
                        <span>Setujui</span></button>
                    <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}"><i class="fa fa-close"></i>
                        <span>Tolak</span>
                    </button>
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
                            {{ $item->equipment_request_number }}
                            <br><br>
                            <h6>Tanggal Pengajuan:</h6>
                            {{ \Carbon\Carbon::parse($timestamp_converted)->translatedFormat('j F Y') }}
                            <br><br>
                            <h6>Nama Kelompok Tani:</h6>
                            {{ $item->lender->name }}
                            <br><br>
                            <embed src="{{ asset('storage/pdf_files/'.$item->pdf_file_name) }}" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></embed>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="acceptModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="acceptModalLabel{{ $item->id }}">Konfirmasi Setuju</h5>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin akan menyetujui pengajuan bantuan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                            <form action="{{ route('SetujuiPengajuanBantuan()', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel{{ $item->id }}">Konfirmasi Tolak</h5>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin akan menolak pengajuan bantuan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                            <form action="{{ route('TolakPengajuanBantuan()', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('keterangan')
<p style="font-size: smaller; color: gray;">Keterangan: <br>Klik atau Tekan salah satu baris Daftar Pengajuan Bantuan untuk melihat detail dan dokumen pengajuan.
    @endsection

    @section('scripts')
    <script>
        $(document).ready(function() {
            function filterRows(searchText) {
                $('.table tbody tr').each(function() {
                    var lenderName = $(this).find('td:eq(3)').text().toLowerCase();
                    if (searchText === '' || lenderName.includes(searchText)) {
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