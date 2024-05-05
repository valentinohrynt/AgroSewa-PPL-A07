@extends('layouts.riwayat-layout')

@section('title', 'Riwayat Penyewaan Petani')

@section('navbar-nav')
<li><a class="nav-link" href="{{route('HomepagePetani()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanPetani()')}}">Penyewaan</a></li>
<li><a class="nav-link active" href="{{route('HalRiwayatPenyewaanPetani()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilPetani()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="{{ route('logout') }}">Logout <i class="bi-box-arrow-right"></i></a></li>
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
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Transaksi</th>
                    <th>Nama Alat</th>
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
                    <td>{{ \Carbon\Carbon::parse($item->actual_return_date)->translatedFormat('j F Y') }}</td>
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
                                <p>Nama Alat:<br>{{ $item->rentTransaction->product->name }}</p>
                                <p>Tanggal peminjaman:<br>{{ \Carbon\Carbon::parse($item->rentTransaction->rent_date)->translatedFormat('j F Y') }}</p>
                                <p>Tanggal pengembalian:<br>{{ \Carbon\Carbon::parse($item->rentTransaction->return_date)->translatedFormat('j F Y') }}</p>
                                <p>Total Harga:<br>Rp{{ $item->total_price }}</p>
                                <p>
                                    Status:<br>
                                    @if($item->rentTransaction->is_completed == 'yes')
                                    <font style="color: green;">Selesai</font>
                                    @endif
                                    @if($item->rentTransaction->is_completed == 'cancelled')
                                    <font style="color: red">Dibatalkan</font>
                                    @endif
                                </p>
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