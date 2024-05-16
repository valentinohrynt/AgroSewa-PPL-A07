@extends('layouts.dashboard-penyewaan-layout')

@section('title', 'Data Sewa Poktan')

@section('content-head-title')
<div class="left">
    <h1>Penyewaan</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route ('HalPenyewaanSA()') }}">Penyewaan</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Penyewaan {{ $lender->name }}</a>
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
    <li>
        <a href="{{ route ('DashboardSA()') }}" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route ('HalAkunPenggunaSA()') }}" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun Pengguna</span>
        </a>
    </li>
    <li class="active">
        <a href="{{route('HalPenyewaanSA()')}}" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li>
        <a href="{{route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('content-box-info')
<div class="box-info" style="display:flex; justify-content: flex-end;">
    <form id="form_{{ $lender->id }}" action="{{ route('HalDataAlatSA') }}" method="post">
        @csrf
        <input type="hidden" name="lender_id" value="{{ $lender->id }}">
        <button type="submit" onclick="submitForm('{{ $lender->id }}')" class="btn btn-success" style="width:10rem;">Data Alat</button>
    </form>
</div>
@endsection

@section('content-table-data')
<div class="order">
    <div class="head">
        Penyewaan Poktan {{$lender->name}}
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
            <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->transaction_number }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->borrower->name }}</td>
                <td> @php
                    $returnDate = Carbon\Carbon::parse($item->return_date);
                    $rentDate = Carbon\Carbon::parse($item->rent_date);
                    $price = floatval($item->product->price);
                    $daysDifference = ($rentDate->diffInDays($returnDate))+1;
                    $total = $price * $daysDifference;
                    @endphp
                    {{ $total }}
                </td>
            </tr>
            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-size:large;" id="detailModalLabel{{ $item->id }}">Detail Penyewaan</h5>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('storage/product_img/'.$item->product->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                            </div>
                            <h6>Nama Alat:</h6>
                            {{ $item->product->name }}
                            <br><br>
                            <h6>Nama Penyewa:</h6>
                            {{ $item->borrower->name }}
                            <br><br>
                            <h6>Tanggal peminjaman:</h6>
                            {{ $item->rent_date }}
                            <br><br>
                            <h6>Tanggal pengembalian:</h6>
                            {{ $item->return_date }}
                            <br><br>
                            <h6>Total Harga:</h6>
                            Rp{{ $total }}
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

@section('script')

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
