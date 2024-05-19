@extends('layouts.dashboard-riwayat-layout')

@section('title', 'Riwayat Penyewaan Superadmin')

@section('content-head-title')
<div class="left">
    <h1>Riwayat</h1>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route ('DashboardSA()') }}">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="{{ route('HalRiwayatSA()')}}">Riwayat</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <form id="form_{{ $lender->id }}" action="{{ route('HalRiwayatPenyewaanSA()') }}" method="post">
                @csrf
                <input type="hidden" name="lender_id" value="{{ $lender->id }}">
                <a class="active" onclick="submitForm('{{ $lender->id }}')" style="cursor:pointer;">Riwayat Penyewaan {{$lender->name}}</a>
            </form>
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
    <li>
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
    <li class="active">
        <a href="{{ route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>
@endsection

@section('content-box-info')
<div class="box-info" style="display:flex; justify-content: flex-end;">
    <form id="form_{{ $lender->id }}" action="{{ route('HalRiwayatPengajuanBantuanSA()') }}" method="post">
        @csrf
        <input type="hidden" name="lender_id" value="{{ $lender->id }}">
        <button type="submit" onclick="submitForm('{{ $lender->id }}')" class="btn btn-success" style="width: 10rem;">Pengajuan Bantuan</button>
    </form>
</div>
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
                <th>Tanggal peminjaman selesai</th>
                <th>Alat</th>
                <th>Nama Penyewa</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($rentLogs -> isNotEmpty())
            @foreach ($rentLogs as $item)
            <tr data-item-id = "{{ $item->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->rentTransaction->transaction_number }}</td>
                <td>{{ \Carbon\Carbon::parse($item->actual_return_date)->translatedFormat('j F Y') }}</td>
                <td>{{ $item->rentTransaction->product->name }}</td>
                <td>{{ $item->rentTransaction->borrower->name }}</td>
                <td> @php
                    $returnDate = Carbon\Carbon::parse($item->rentTransaction->return_date);
                    $rentDate = Carbon\Carbon::parse($item->rentTransaction->rent_date);
                    $price = floatval($item->rentTransaction->product->price);
                    $daysDifference = ($rentDate->diffInDays($returnDate))+1;
                    $total = $price * $daysDifference;
                    @endphp
                    {{ $total }}
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size:large;" id="detailModalLabel">Detail Riwayat Penyewaan</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <img id="productImage" class="img-fluid w-50 h-50" alt="Gambar Produk">
                    </div>
                    <h6>Nama Alat:</h6>
                    <span id="productName"></span>
                    <br><br>
                    <h6>Nama Penyewa:</h6>
                    <span id="borrowerName"></span>
                    <br><br>
                    <h6>Luas Lahan:</h6>
                    <span id="landArea"></span>
                    <br><br>
                    <h6>Tanggal peminjaman:</h6>
                    <span id="rentDate"></span>
                    <br><br>
                    <h6>Tanggal pengembalian:</h6>
                    <span id="returnDate"></span>
                    <br><br>
                    <h6>Total Harga:</h6>
                    <span id="totalPrice"></span>
                    <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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
    $(document).ready(function() {
        $('tbody tr').on('click', function() {
            var itemId = $(this).data('item-id');
            showModal(itemId);
        });

        $('#detailModal').on('hidden.bs.modal', function () {
            clearModalContent();
        });
    });

    function showModal(itemId) {
        $.ajax({
            url: '{{ route('getDynamicContent()') }}',
            type: 'GET',
            data: { itemId: itemId },
            success: function(response) {
                $('#detailModal #productName').text(response.productName);
                $('#detailModal #borrowerName').text(response.borrowerName);
                $('#detailModal #landArea').text((response.landArea)+" m2"); 
                $('#detailModal #rentDate').text(response.rentDate);
                $('#detailModal #returnDate').text(response.returnDate);
                $('#detailModal #totalPrice').text(response.totalPrice);
                $('#detailModal #productImage').attr('src', response.productImage);
                $('#detailModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function clearModalContent() {
        $('#detailModal #productName').text('');
        $('#detailModal #borrowerName').text('');
        $('#detailModal #landArea').text('');
        $('#detailModal #rentDate').text('');
        $('#detailModal #returnDate').text('');
        $('#detailModal #totalPrice').text('');
        $('#detailModal #productImage').attr('src', '');
    }
</script>

@endsection
