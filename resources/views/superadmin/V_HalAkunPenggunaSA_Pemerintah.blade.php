@extends('layouts.dashboard-akun-layout')

@section('title', 'Akun Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Akun Pengguna</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route ('HalAkunPenggunaSA()') }}" class="">Akun Pengguna</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Daftar Akun Pemerintah</a>
        </li>
    </ul>
</div>
@endsection

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
    <ul>
        <li><a href="{{route('HalProfilSA()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('sidebar')
<a href="#" class="logo">
    <img src="{{asset('assets/img/logo/agrosewa_logo.png')}}" id="logo-jemberkab" alt="">
    <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="{{ route ('DashboardSA()') }}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route ('HalAkunPenggunaSA()') }}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Pengguna</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalPenyewaanSA()')}}" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li class="">
        <a href="{{ route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('content-box-info')
<div class="box-info" style="display:flex; justify-content: flex-end;">
    <form action="{{route('TambahAkunPemerintah()')}}">
        <button type="submit" class="btn btn-info" style="width: 15rem;"><i class="fas fa-user-plus"></i> Tambah Akun</button></button>
    </form>
</div>
@endsection

@section('content-table-data')

<div class="order">
    <div class="head">
        <h3>Daftar Akun Pemerintah</h3>
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
                <th style="text-align:left; padding-left:0.8rem;">Kecamatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($government as $item)
            @php
            $encryptedGovernmentId = encrypt($item->id)
            @endphp
            <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                <td style="text-align:left; padding-left:0.8rem;">{{ $item->name }}</td>
                <td style="text-align:left; padding-left:0.8rem;">{{ $item->village->district->name }}</td>
                <form id="form_{{ $item->id }}" action="{{route('HalDataAkunPenggunaSA_Pemerintah()',['government_id' => $encryptedGovernmentId])}}">
                    @csrf
                    <input type="hidden" name="government_id" value="{{ $encryptedGovernmentId }}">
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        function filterRows(searchText) {
            $('.table tbody tr').each(function() {
                var governmentName = $(this).find('td:eq(1)').text().toLowerCase();
                var districtName = $(this).find('td:eq(2)').text().toLowerCase();
                if (searchText === '' || governmentName.includes(searchText) || districtName.includes(searchText)) {
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
        $('#searchInput').on('keydown', function(event) {
            if (event.key === "Enter") {
                var searchText = $(this).val().toLowerCase();
                filterRows(searchText);
            }
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
