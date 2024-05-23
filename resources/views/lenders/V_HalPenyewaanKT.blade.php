@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link active" href="{{route('HalPenyewaanKT()')}}">Penyewaan</span></a></li>
<li><a class="nav-link" href="{{route('HalPengajuanBantuanKT()')}}">Pengajuan Bantuan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanKT()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilKT()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout <i class="bi-box-arrow-right"></i></a></li>
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
        @elseif(session('error'))
        <div class="alert alert-danger mb-5">
          {{ session('error') }}
        </div>
        @elseif ($errors->any())
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
            <a href="{{ route('DataAlatKT()') }}" class="btn btn-primary pb-2">Data Alat</a>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari berdasarkan No. Transaksi / Nama Alat / Nama Penyewa" id="searchInput">
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
                    <td>{{ $item->product->name }}</td>
                    <td><a href onclick="event.stopPropagation();" data-bs-toggle="modal" data-bs-target="#borrowerDetailModal{{ $item->borrower->id }}">{{ $item->borrower->name }}</a></td>
                    <td hidden> @php
                        $returnDate = Carbon\Carbon::parse($item->return_date);
                        $rentDate = Carbon\Carbon::parse($item->rent_date);
                        $price = floatval($item->product->price);
                        $daysDifference = ($rentDate->diffInDays($returnDate))+1;
                        $total = $price * $daysDifference;
                        @endphp
                        {{ $total }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="bi bi-pencil"></i>
                            <span>Edit</span>
                        </button>
                        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $item->id }}">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>Konfirmasi</span>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="borrowerDetailModal{{ $item->borrower->id }}" tabindex="-1" role="dialog" aria-labelledby="borrowerDetailModalLabel{{ $item->borrower->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="borrowerDetailModalLabel{{ $item->borrower->id }}">Detail Petani Penyewa</h6>
                            </div>
                            <div class="modal-body">
                                <div class="modal-img" style="display:flex; justify-content:center;">
                                    <img src="{{asset('assets\img\user\default-img-user.png')}}" style="width: 10rem; height: 10rem;">
                                </div>
                                <p>Nama Petani:<br>{{ $item->borrower->name }}</p>
                                <p>Nomor Telepon:<br>{{ $item->borrower->phone }}</p>
                                <p>Alamat:<br>{{ $item->borrower->street }}, {{ $item->borrower->village->name }}, {{ $item->borrower->village->district->name }}</p>
                                <p>Total Harga:<br>Rp{{ $total }}</p>
                                <p>Luas lahan milik Petani:<br>{{ $item->borrower->land_area }} m2</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/product_img/'.$item->product->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                                </div>
                                <p>Nama Alat:<br>{{ $item->product->name }}</p>
                                <p>Nama Penyewa:<br>{{ $item->borrower->name }}</p>
                                <p>Tanggal peminjaman:<br>{{ $item->rent_date }}</p>
                                <p>Tanggal pengembalian:<br>{{ $item->return_date }}</p>
                                <p>Total Harga:<br>Rp{{ $total }}</p>
                                <p>Luas lahan milik Petani:<br>{{ $item->borrower->land_area }} m2</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Tanggal Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                @if ($errors->any())
                                <div class="alert alert-danger mb-5">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                    @endforeach
                                </div>
                                @endif
                                <form id="editDateForm" action="{{ route('EditSewaAlat()', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="rent_date" class="pb-2">Tanggal awal</label>
                                        <input type="date" name="rent_date" id="rent_date" min="{{ date('Y-m-d') }}" value="{{ isset($rent_date) ? $rent_date : date('Y-m-d') }}" class="form-control">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="return_date" class="pb-2">Tanggal pengembalian</label>
                                        <input type="date" name="return_date" id="return_date" class="form-control" min="{{ date('Y-m-d') }}">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmationModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $item->id }}">Konfirmasi Status Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                Silahkan tambahkan status konfirmasi penyewaan
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#confirmationCancelModal{{ $item->id }}"><i class="bi-x-lg"></i> Batalkan Penyewaan</button>
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#confirmationCompleteModal{{ $item->id }}"><i class="bi-check-lg"></i> Selesaikan Penyewaan</button>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $encryptedTotalPrice = encrypt($total);
                @endphp
                <div class="modal fade" id="confirmationCompleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationCompleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationCompleteModalLabel{{ $item->id }}">Konfirmasi Selesai Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menyelesaikan penyewaan?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                <form action="{{ route('SelesaiPenyewaan()', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $encryptedTotalPrice }}">
                                    <input type="hidden" name="land_area" value="{{ $item->borrower->land_area }}">
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmationCancelModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationCancelModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationCancelModalLabel{{ $item->id }}">Konfirmasi Pembatalan Penyewaan</h5>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin membatalkan penyewaan?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                <form action="{{ route('BatalPenyewaan()', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $encryptedTotalPrice }}">
                                    <input type="hidden" name="land_area" value="">
                                    @method('PATCH')
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
<script>
    document.getElementById('rent_date').addEventListener('change', function() {
        var rentDate = new Date(this.value);
        var returnDateInput = document.getElementById('return_date');

        var minReturnDate = new Date(rentDate.getTime());
        returnDateInput.setAttribute('min', minReturnDate.toISOString().split('T')[0]);

        if (returnDateInput.valueAsDate < minReturnDate) {
            returnDateInput.value = minReturnDate.toISOString().split('T')[0];
        }
    });
    // document.getElementById('rent_date').addEventListener('change', function() {
    //     var rentDate = new Date(this.value);
    //     var returnDateInput = document.getElementById('return_date');

    //     var minReturnDate = new Date(rentDate.getTime() + (24 * 60 * 60 * 1000));
    //     returnDateInput.setAttribute('min', minReturnDate.toISOString().split('T')[0]);

    //     if (returnDateInput.valueAsDate < minReturnDate) {
    //         returnDateInput.value = minReturnDate.toISOString().split('T')[0];
    //     }
    // });
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
