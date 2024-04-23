@extends('layouts.riwayat-layout')

@section('title', 'Riwayat Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="HomepageKT">Home</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link active" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Akun </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="#">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="logout">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')

<section id="product-display" class="product-display">
    <div class="container pt-5" data-aos="fade-up">
        <div class="section-title">
            <h2>Riwayat</h2>
            <h6>DAFTAR RIWAYAT PENYEWAAN ALAT PERTANIAN</h6>
        </div>
        <div class="d-flex justify-content-end button-data-alat pb-2">
            <a href="{{ route('RiwayatPengajuanBantuanKT()') }}" class="btn btn-primary pb-2">Pengajuan Bantuan</a>
        </div>
        <div class="input-group mb-3 flex-column">
            <label for="dateFilterInput">Saring berdasarkan tanggal</label>
            <div class="input-group-prepend">
                <span class="input-group-text bg-white border-md border-right-0" style="width: 50%">
                    <i class="bi bi-filter"></i>
                    <input type="date" class="form-control" name="dateFilterInput" id="dateFilterInput" style="width: 100%; border:none;" pattern="\d{4}-\d{2}-\d{2}">
                </span>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Transaksi</th>
                    <th>Nama Alat</th>
                    <th>Nama Penyewa</th>
                    <th>Tanggal peminjaman selesai</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($rentLogs as $item)
                <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->rentTransaction->transaction_number }}</td>
                    <td>{{ $item->rentTransaction->product->name }}</td>
                    <td>{{ $item->rentTransaction->borrower->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->actual_return_date)->translatedFormat('j F Y') }}</td>
                    <td hidden> @php
                        $returnDate = Carbon\Carbon::parse($item->rentTransaction->return_date);
                        $rentDate = Carbon\Carbon::parse($item->rentTransaction->rent_date);
                        $price = floatval($item->rentTransaction->product->price);
                        $daysDifference = ($rentDate->diffInDays($returnDate))+1;
                        $total = $price * $daysDifference;
                        @endphp
                        {{ $total }}
                    </td>
                    <td>
                        @if($item->rentTransaction->is_completed == 'yes')
                        <p>
                            <font style="color: green;">Selesai</font>
                        </p>
                        @endif
                        @if($item->rentTransaction->is_completed == 'cancelled')
                        <p>
                            <font style="color: red">Dibatalkan</font>
                        </p>
                        @endif
                    </td>
                </tr>
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/product_img/'.$item->rentTransaction->product->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                                </div>
                                <h6><strong>Nama Alat:</strong><br> {{ $item->rentTransaction->product->name }}</h6>
                                <h6><strong>Nama Penyewa:</strong><br> {{ $item->rentTransaction->borrower->name }}</h6>
                                <h6><strong>Tanggal peminjaman:</strong><br> {{ \Carbon\Carbon::parse($item->rentTransaction->rent_date)->translatedFormat('j F Y') }}</h6>
                                <h6><strong>Tanggal pengembalian:</strong><br> {{ \Carbon\Carbon::parse($item->actual_return_date)->translatedFormat('j F Y') }}</h6>
                                <h6><strong>Total Harga:</strong><br> Rp{{ $total }}</h6>
                                <h6><strong>Status:</strong><br>
                                    @if($item->rentTransaction->is_completed == 'yes')
                                    <font style="color: green;">Selesai</font>
                                    @endif
                                    @if($item->rentTransaction->is_completed == 'cancelled')
                                    <font style="color: red">Dibatalkan</font>
                                    @endif
                                </h6>
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
</section>
<script>
    document.getElementById('rent_date').addEventListener('change', function() {
        var rentDate = new Date(this.value);
        var returnDateInput = document.getElementById('return_date');

        var minReturnDate = new Date(rentDate.getTime() + (24 * 60 * 60 * 1000));
        returnDateInput.setAttribute('min', minReturnDate.toISOString().split('T')[0]);

        if (returnDateInput.valueAsDate < minReturnDate) {
            returnDateInput.value = minReturnDate.toISOString().split('T')[0];
        }
    });
</script>
@endsection

@if (session('editTransactionErrors'))
@section('script')
<script>
    $(document).ready(function() {
        @if(session('editTransactionId'))
        var transactionId = {
            !!json_encode(session('editTransactionId')) !!
        };
        $('#editModal' + transactionId).modal('show');
        @endif
    });
</script>
@endsection
@endif