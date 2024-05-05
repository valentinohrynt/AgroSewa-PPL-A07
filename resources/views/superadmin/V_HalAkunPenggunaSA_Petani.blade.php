@extends('layouts.dashboard-akun-layout')

@section('title', 'Akun Petani')

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
            <a href="#" class="active">Daftar Akun Petani</a>
        </li>
    </ul>
</div>
@endsection

@section('nav')
<i class="fas fa-bars menu-btn"></i>
<li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
    <ul>
        <li><a href="{{route('HalProfilSA()')}}">Profil <i class="fas fa-user"></i></a></li>
        <li><a href="{{ route('logout') }}">
                <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
            </a></li>
    </ul>
</li>
@endsection

@section('sidebar')
<a href="#" class="logo">
    <i class="fa fa-user-tie"></i>
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

@section('content-table-data')

<div class="order">
    <div class="head">
        <h3>Daftar Akun Petani</h3>
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
            @foreach ($borrowers as $item)
            @php
            $encryptedBorrowerId = encrypt($item->id)
            @endphp
            <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                <td style="text-align:left; padding-left:0.8rem;">{{ $item->name }}</td>
                <form id="form_{{ $item->id }}" action="{{route('HalDataAkunPenggunaSA_Petani()',['borrower_id' => $encryptedBorrowerId])}}">
                    @csrf
                    <input type="hidden" name="borrower_id" value="{{ $encryptedBorrowerId }}">
                </form>
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
                var borrowerName = $(this).find('td:eq(1)').text().toLowerCase();
                if (searchText === '' || borrowerName.includes(searchText)) {
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