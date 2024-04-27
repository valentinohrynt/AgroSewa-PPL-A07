@extends('layouts.dashboard-pengajuanbantuan-layout')

@section('title', 'Pengajuan Bantuan Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Pengajuan Bantuan</h1>
    <ul class="breadcrumb">
        <li>
            <a href="DashboardPemerintah">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="active">Daftar Pengajuan Bantuan</a>
        </li>
    </ul>
</div>
@endsection

@section('sidebar')
<a href="DashboardPemerintah" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Dinas TPHP</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="DashboardPemerintah" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
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

<ul class="side-menu">
    <li>
        <a href="{{ route('logout') }}" class="logout">
            <i class="fas fa-right-from-bracket"></i>
            <span class="text">Logout</span>
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
                <th>Proposal Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipmentRequest as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->equipment_request_number }}</td>
                <td>{{ $item->created_at }}</td>
                <td><a onclick="event.stopPropagation();" data-bs-toggle="modal" data-bs-target="#lenderDetailModal{{ $item->id }}">{{ $item->lender->name }}</a></td>
                <td>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#pdfModal{{ $item->id }}">
                        <i class="fa fa-solid fa-file-pdf"></i>
                        <span>PDF</span>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $item->id }}"><i class="fa fa-check"></i>
                        <span>Setujui</span></button>
                    <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}"><i class="fa fa-close"></i>
                        <span>Tolak</span>
                    </button>
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
                            <embed src="{{ asset('storage/pdf_files/'.$item->pdf_file_name) }}" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%"></embed>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="lenderDetailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="lenderDetailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="lenderDetailModalLabel{{ $item->id }}">Detail Kelompok Tani</h6>
                        </div>
                        <div class="modal-body">
                            <div class="modal-img" style="display:flex; justify-content:center;">
                                <img src="{{asset('assets\img\user\default-img-kt.png')}}" style="width: 10rem; height: 10rem;">
                            </div>
                            <h6>Nama Kelompok Tani:</h6>
                            <h3>{{ $item->lender->name }}</h3>
                            <br>
                            <h6><strong>Nomor Telepon:</strong></h6>
                            <h3>{{ $item->lender->phone }}</h3>
                            <br>
                            <h6><strong>Alamat:</strong></h6>
                            <h3>{{ $item->lender->street }}</h3>
                            <br>
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