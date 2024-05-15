@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link active" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
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

<section id="penyewaan_dt" class="penyewaan-data-table">
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
        @endif
        <div class="section-title">
            <h2>Alat</h2>
            <h6>Berikut alat yang Anda sediakan</h6>
        </div>
        <table class="table">
            <div class="row pb-2 justify-content-between">
                <div class="col-4">
                    <a href="{{route('HalPenyewaanKT()')}}" class="btn btn-secondary"><i class="bi-arrow-left-square"></i> Kembali</a>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Tambah <i class="bi-plus-circle"></i>
                    </button>
                </div>
            </div>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Alat</th>
                    <th>Nama Alat</th>
                    <th>Harga</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>Rp{{ $item->price }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"><i class="bi-pencil"></i>
                            <span>Edit</span>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true" data-item-id="{{ $item->id }}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Alat</h5>
                            </div>
                            <div class="modal-body">
                                @if (session('editItemErrors'))
                                <div class="alert alert-danger mb-5">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                    @endforeach
                                </div>
                                @endif
                                <form id="editProductForm" action="{{ route('EditDataAlat()', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group py-2">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{old('name', $item->name)}}">
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="description">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="product_description" rows="3">{{old('product_description', $item->product_description)}}</textarea>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="price">Harga sewa per hari</label>
                                        <input type="number" class="form-control" id="price" name="price" value="{{old('price', $item->price)}}">
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="image">Gambar</label>
                                        <input class="form-control" type="file" id="image" name="product_img">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Alat</h5>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/product_img/'.$item->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                                </div>
                                <p>Nama Alat:<br>{{ $item->name }}</p>
                                <p>Kode Alat:<br>{{ $item->product_code }}</p>
                                <p>Deskripsi:<br>{{ $item->product_description }}</p>
                                <p>Harga sewa per hari:<br>Rp{{ $item->price }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Tambah Data Alat</h5>
                        </div>
                        <div class="modal-body">
                            @if (session('addItemErrors'))
                            <div class="alert alert-danger mb-5">
                                @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                                @endforeach
                            </div>
                            @endif
                            <form id="addProductForm" action="{{ route('TambahDataAlat()') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group py-2">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group py-2">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="product_description" rows="3"></textarea>
                                </div>
                                <div class="form-group py-2">
                                    <label for="price">Harga sewa per hari</label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>
                                <div class="form-group py-2">
                                    <label for="image">Gambar</label>
                                    <input class="form-control" type="file" id="image" name="product_img">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" form="addProductForm" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </div>
</section>

@endsection

@section('script')
@if (session('editItemErrors') && session('editItemId'))
<script>
    $(document).ready(function() {
        var modalId = {
            !!(session('editItemId')) !!
        };
        $('#editModal' + modalId).modal('show');
    });
</script>
@endif

@if(session('addItemErrors'))
<script>
    $(document).ready(function() {
        $('#addProductModal').modal('show');
    });
</script>
@endif
@endsection