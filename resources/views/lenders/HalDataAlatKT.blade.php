@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('navbar-nav')

<li><a class="nav-link" href="HomepageKT">Home</a></li>
<li><a class="nav-link active" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
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
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger mb-5">
            {{ session('error') }}
        </div>
        @endif
        <div class="section-title">
            <h2>Alat</h2>
            <h6>Berikut alat yang Anda sediakan</h6>
        </div>
        <table class="table">
            <div class="row pb-2 justify-content-between">
                <div class="col-4">
                    <a href="HalPenyewaanKT" class="btn btn-secondary"><i class="bi-arrow-left-square"></i> Kembali</a>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                        Tambah <i class="bi-plus-circle"></i>
                    </button>
                </div>
            </div>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Alat</th>
                    <th>Nama Alat</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Ubah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->product_description }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}"><i class="bi-pencil"></i>
                            <span>Ubah</span>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Ubah Data Alat</h5>
                            </div>
                            <div class="modal-body">
                                <form id="editDateForm" action="{{ route('update-product', ['id' => $item->id]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group py-2">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="description">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="product_description"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="price">Harga sewa per hari</label>
                                        <input type="number" class="form-control" id="price" name="price" required>
                                    </div>
                                    <div class="form-group py-2">
                                        <label for="image">Gambar</label>
                                        <input class="form-control" type="file" id="image" name="product_img">
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
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Alat</h5>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/product_img/'.$item->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                                </div>
                                <h6><strong>Nama:</strong><br> {{ $item->name }}</h6>
                                <h6><strong>Kode Alat:</strong><br> {{ $item->product_code }}</h6>
                                <h6><strong>Deskripsi:</strong><br> {{ $item->product_description }}</h6>
                                <h6><strong>Harga:</strong><br> {{ $item->price }}</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog"
                aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                        </div>
                        <div class="modal-body">
                            <form id="addProductForm" action="{{ route('store-product') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group py-2">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group py-2">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="product_description"
                                        rows="3"></textarea>
                                </div>
                                <div class="form-group py-2">
                                    <label for="price">Harga sewa per hari</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
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