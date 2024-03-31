@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="home-poktan">Home</a></li>
<li><a class="nav-link active" href="#">Penyewaan</a></li>
<li><a class="nav-link" href="pengajuan-poktan">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="riwayat-poktan">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Akun </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="#">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="logout">Logout <i class="bi-box-arrow-right"></i></a></li>
    </ul>
</li>

@endsection

@section('content')

<section id="penyewaan_dt" class="penyewaan-data-table">
    <div class="container pt-5 ">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Penyewaan</h2>
            <p>Berikut penyewaan yang sedang berjalan</p>
        </div>
        <div class="d-flex justify-content-end button-data-alat pb-2">
            <a href="alat-poktan" class="btn btn-primary pb-2">Data Alat</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Transaksi</th>
                    <th>Nama Alat</th>
                    <th>Nama Penyewa</th>
                    <th>Tanggal awal</th>
                    <th>Tanggal pengembalian</th>
                    <th>Total</th>
                    <th>Ubah</th>
                    <th>Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentTransactions as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->transaction_number }}</td>
                    <td><a href="">{{ $item->product->name }}</a></td>
                    <td>{{ $item->borrower->name }}</td>
                    <td>{{ $item->rent_date }}</td>
                    <td>{{ $item->return_date }}</td>
                    <td> @php
                        $returnDate = Carbon\Carbon::parse($item->return_date);
                        $rentDate = Carbon\Carbon::parse($item->rent_date);
                        $price = floatval($item->product->price);
                        $daysDifference = $rentDate->diffInDays($returnDate);
                        $total = $price * $daysDifference;
                        @endphp
                        {{ $total }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}"><i class="bi-pencil"></i>
                            Ubah
                        </button>
                    </td>
                    <td>
                        <form action="#" method="post">
                            @csrf
                            <input type="hidden" name="rent_transaction_id" value="{{ $item->id }}">
                            <input type="hidden" name="total_price" value="{{ $total }}">
                            <input type="hidden" name="actual_return_date" value="2024-02-02 19:05:12">
                            <button type="submit" class="btn btn-success"><i class="bi-check"></i> Selesai</button>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Ubah Tanggal Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                <form id="editDateForm"
                                    action="{{ route('update-rent-transaction', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="rent_date" class="pb-2">Tanggal awal</label>
                                        <input type="datetime-local" name="rent_date" id="rent_date"
                                            class="form-control">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="return_date" class="pb-2">Tanggal pengembalian</label>
                                        <input type="datetime-local" name="return_date" id="return_date"
                                            class="form-control">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                <button id="saveChangesButton" type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection