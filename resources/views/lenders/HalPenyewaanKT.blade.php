@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="HomepageKT">Home</a></li>
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

<section id="product-display" class="product-display">
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger mb-5">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
        <div class="section-title">
            <h2>Penyewaan</h2>
            <h6>DAFTAR PENYEWAAN ALAT PERTANIAN</h6>
        </div>
        <div class="d-flex justify-content-end button-data-alat pb-2">
            <a href="{{ route('HalDataAlatKT') }}" class="btn btn-primary pb-2">Data Alat</a>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Pencarian" id="searchInput">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Transaksi</th>
                    <th>Nama Alat</th>
                    <th>Nama Penyewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentTransactions as $item)
                <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->transaction_number }}</td>
                    <td><a href="">{{ $item->product->name }}</a></td>
                    <td>{{ $item->borrower->name }}</td>
                    <td hidden> @php
                        $returnDate = Carbon\Carbon::parse($item->return_date);
                        $rentDate = Carbon\Carbon::parse($item->rent_date);
                        $price = floatval($item->product->price);
                        $daysDifference = $rentDate->diffInDays($returnDate);
                        $total = $price * $daysDifference;
                        @endphp
                        {{ $total }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}">
                            <i class="bi bi-pencil"></i>
                            <span>Ubah</span>
                        </button>
                        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal"
                            data-bs-target="#confirmationCompleteModal{{ $item->id }}"><i class="bi-check-lg"></i>
                            <span>Selesai</span></button>
                        <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal{{ $item->id }}"><i class="bi-x-lg"></i>
                            <span>Batal</span>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/product_img/'.$item->product->product_img) }}"
                                        class="img-fluid w-50 h-50" alt="Gambar Produk">
                                </div>
                                <h6><strong>Nama Alat:</strong><br> {{ $item->product->name }}</h6>
                                <h6><strong>Nama Penyewa:</strong><br> {{ $item->borrower->name }}</h6>
                                <h6><strong>Tanggal sewa:</strong><br> {{ $item->rent_date }}</h6>
                                <h6><strong>Tanggal pengembalian:</strong><br> {{ $item->return_date }}</h6>
                                <h6><strong>Total Harga:</strong><br> Rp{{ $total }}</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input type="date" name="rent_date" id="rent_date" min="{{ date('Y-m-d') }}"
                                            class="form-control">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="return_date" class="pb-2">Tanggal pengembalian</label>
                                        <input type="date" name="return_date" id="return_date" min="{{ date('Y-m-d') }}"
                                            class="form-control">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $encryptedTotalPrice = encrypt($total);
                @endphp
                <div class="modal fade" id="confirmationCompleteModal{{ $item->id }}" tabindex="-1"
                    aria-labelledby="confirmationCompleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationCompleteModalLabel{{ $item->id }}">Konfirmasi
                                    Selesai
                                    Penyewaan
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menyelesaikan Penyewaan ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                <form action="{{ route('complete-rent-transaction', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $encryptedTotalPrice }}">
                                    <button type="submit" class="btn btn-success">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmationModal{{ $item->id }}" tabindex="-1"
                    aria-labelledby="confirmationModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $item->id }}">Konfirmasi Pembatalan
                                    Penyewaan
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin membatalkan Penyewaan ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                <form action="{{ route('force-cancel-transaction', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $encryptedTotalPrice }}">
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Ya</button>
                                </form>
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