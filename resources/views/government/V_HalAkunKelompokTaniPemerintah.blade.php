@extends('layouts.dashboard-akun-layout')

@section('title', 'Akun Kelompok Tani')

@section('content-head-title')
<div class="left">
    <h1>Akun Kelompok Tani</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{route('DashboardPemerintah()')}}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Akun Kelompok Tani</a>
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
    <li class="active">
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
    <li class="">
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
        <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('content-box-info')
<div class="box-info" style="display:flex; justify-content: flex-end;">
    <form action="{{route('TambahAkunKelompokTaniPemerintah()')}}">
        <button type="submit" class="btn btn-info" style="width: 15rem;"><i class="fas fa-user-plus"></i> Tambah Akun</button></button>
    </form>
</div>
@endsection

@section('content-table-data')

<div class="order">
    <div class="head">
        <h3>Daftar Akun Kelompok Tani</h3>
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
                <th style="text-align:left; padding-left:0.8rem;">Nama Kelompok Tani</th>
                <th style="text-align:left; padding-left:2.7rem;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lenders as $item)
            @php
            $encryptedLenderId = encrypt($item->id)
            @endphp
            <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                <td style="text-align:left; padding-left:0.8rem;">{{ $item->name }}</td>
                <form id="form_{{ $item->id }}" action="{{ route('HalDataAkunKelompokTaniPemerintah()', ['lender_id' => $encryptedLenderId])}}">
                    @csrf
                    <input type="hidden" name="lender_id" value="{{ $encryptedLenderId }}">
                </form>
                <td style="text-align:left; padding-left:0.8rem;">
                    <form action="{{ route('EditAkunKelompokTaniPemerintah()',['lender_id' => $encryptedLenderId]) }}">
                        @csrf
                        <input type="hidden" name="lender_id" value="{{ $encryptedLenderId }}">
                        <button type="submit" class="btn mb-2" style="background-color: orange; color: white; font-weight:300;"><i class="fa fa-pencil"></i>
                            <span>Edit</span>
                        </button>
                    </form>
                </td>
            </tr>
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