@extends('layouts.dashboard-penyewaan-layout')

@section('title', 'Data Alat Poktan')

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
            <form id="form_{{ $lender->id }}" action="{{ route('HalDataPenyewaanSA') }}" method="post">
                @csrf
                <input type="hidden" name="lender_id" value="{{ $lender->id }}">
                <a onclick="submitForm('{{ $lender->id }}')" style="cursor:pointer;">Penyewaan {{$lender->name}}</a>
            </form>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Data Alat {{$lender->name}}</a>
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
                <th>Kode Alat</th>
                <th>Nama Alat</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isNotEmpty())
            @foreach ($products as $item)
            <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product_code }}</td>
                <td>{{ $item->name }}</td>
            </tr>
            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-size:large;" id="detailModalLabel{{ $item->id }}">Detail Alat</h5>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('storage/product_img/'.$item->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                            </div>
                            <h6><strong>Nama:</strong></h6>
                            {{ $item->name }}
                            <br><br>
                            <h6><strong>Kode Alat:</strong></h6>
                            {{ $item->product_code }}
                            <br><br>
                            <h6><strong>Deskripsi:</strong></h6>
                            {{ $item->product_description }}
                            <br><br>
                            <h6><strong>Harga:</strong></h6>
                            {{ $item->price }}
                            <br><br>
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
                var productCode = $(this).find('td:eq(1)').text().toLowerCase();
                var productName = $(this).find('td:eq(2)').text().toLowerCase();
                if (searchText === '' || productCode.includes(searchText) || productName.includes(
                        searchText)) {
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