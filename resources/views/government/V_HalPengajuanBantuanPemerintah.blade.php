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
            <a href="{{route('HalPengajuanBantuanPemerintah()')}}" class="active">Pengajuan Bantuan</a>
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
        <h3>Daftar Kelompok Tani</h3>
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
                <th style="text-align:left; padding-left:1rem;">No.</th>
                <th style="text-align:left; padding-left:0.8rem;">Nama Poktan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lenders as $item)
            @php
            $encryptedLenderId = encrypt($item->id)
            @endphp
            <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                <td style="text-align:left; padding-left:0.8rem;"><a onclick="event.stopPropagation();" data-bs-toggle="modal" data-bs-target="#lenderDetailModal{{ $item->id }}">{{ $item->name }}</a></td>
                <form id="form_{{ $item->id }}" action="{{ route('HalDataPengajuanBantuanPemerintah()', ['lender_id'=>$encryptedLenderId]) }}">
                    @csrf
                    <input type="hidden" name="lender_id" value="{{ $encryptedLenderId }}">
                </form>
            </tr>
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
                            {{ $item->name }}
                            <br><br>
                            <h6>Nomor Telepon:</h6>
                            {{ $item->phone }}
                            <br><br>
                            <h6>Alamat:</h6>
                            {{ $item->street }}, {{ $item->village->name }}, {{ $item->village->district->name }}
                            <br><br>
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
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        function filterRows(searchText) {
            $('.table tbody tr').each(function() {
                var lenderName = $(this).find('td:eq(1)').text().toLowerCase();
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