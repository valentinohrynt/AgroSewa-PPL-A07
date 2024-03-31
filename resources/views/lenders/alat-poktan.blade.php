@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan Poktan')

@section('some-user')

<li><a class="nav-link" href="pengajuan-poktan">Pengajuan Bantuan</a></li>

@endsection

@section('content')

<section id="penyewaan_dt" class="penyewaan-data-table">
    <div class="container pt-5" data-aos="fade-up">
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
        <div class="section-title">
            <h2>Alat</h2>
            <p>Berikut alat yang Anda sediakan</p>
        </div>
        <table class="table">
            <div class="row pb-2 justify-content-between">
                <div class="col-4">
                    <a href="penyewaan-poktan" class="btn btn-warning"><i class="bi-arrow-left-short"></i> Kembali</a>
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
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->product_description }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}"><i class="bi-pencil"></i>
                            Ubah
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $item->id }}"><i class="bi-info-circle"></i> Detail</button>
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
                                <p><strong>Nama:</strong><br> {{ $item->name }}</p>
                                <p><strong>Kode Alat:</strong><br> {{ $item->product_code }}</p>
                                <p><strong>Deskripsi:</strong><br> {{ $item->product_description }}</p>
                                <p><strong>Harga:</strong><br> {{ $item->price }}</p>
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