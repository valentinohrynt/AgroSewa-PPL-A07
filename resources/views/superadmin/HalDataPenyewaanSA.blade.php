@extends('layouts.dashboard-penyewaan-layout')

@section('title', 'Data Sewa Poktan')

@section('content-head-title')
<div class="left">
    <h1>Penyewaan</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route ('HalPenyewaanSA') }}">Daftar Kelompok Tani</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Penyewaan {{ $lender->name }}</a>
        </li>
    </ul>
</div>
@endsection

@section('sidebar')
<a href="#" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
    <li>
        <a href="DashboardSA" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun</span>
        </a>
    </li>
    <li class="active">
        <a href="HalPenyewaanSA" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li>
        <a href="#" class="nav-link">
            <i class="fas fa-chart-simple"></i>
            <span class="text">Pengajuan Bantuan</span>
        </a>
    </li>
    <li>
        <a href="#" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>

<ul class="side-menu">
    <li>
        <a href="logout" class="logout">
            <i class="fas fa-right-from-bracket"></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
@endsection

@section('content-box-info')
<form id="form_{{ $lender->id }}" action="{{ route('HalDataAlatSA') }}" method="post">
    @csrf
    <input type="hidden" name="lender_id" value="{{ $lender->id }}">
    <button type="submit" onclick="submitForm('{{ $lender->id }}')" class="btn-primary" style="width: 5rem;">Data Alat</button>
</form>
@endsection

@section('content-table-data')
<div class="order">
    <div class="head">
        <h3>Penyewaan Poktan {{$lender->name}}</h3>
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
                <th>Nomor Transaksi</th>
                <th>Alat</th>
                <th>Nama Penyewa</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($rentTransactions -> isNotEmpty())
            @foreach ($rentTransactions as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->transaction_number }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->borrower->name }}</td>
                <td> @php
                    $returnDate = Carbon\Carbon::parse($item->return_date);
                    $rentDate = Carbon\Carbon::parse($item->rent_date);
                    $price = floatval($item->product->price);
                    $daysDifference = $rentDate->diffInDays($returnDate);
                    $total = $price * $daysDifference;
                    @endphp
                    {{ $total }}
                </td>
            </tr>
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