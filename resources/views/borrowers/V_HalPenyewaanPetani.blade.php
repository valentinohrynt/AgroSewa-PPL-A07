@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan')

@section('navbar-nav')
<li><a class="nav-link" href="{{route('HomepagePetani()')}}">Home</a></li>
<li><a class="nav-link active" href="{{route('HalPenyewaanPetani()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanPetani()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
  <ul>
    <li><a href="{{ route('HalProfilPetani()') }}">Profil <i class="bi-person-circle"></i></a></li>
    <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">Logout <i class="bi-box-arrow-right"></i></a></li>
  </ul>
</li>
@endsection

@section('content')

<section id="product-display" class="product-display">
  <div class="container pt-5" data-aos="fade-up">
    <div class="row-2">
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
      @if ($errors->any())
      <div class="alert alert-danger mb-5">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
      </div>
      @endif
      <div class="section-title">
        <h2>PENYEWAAN</h2>
        <h6>DAFTAR PENYEWAAN ALAT PERTANIAN</h6>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>No. Transaksi</th>
            <th>Nama Alat</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rentTransactions as $item)
          <tr data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->transaction_number }}</td>
            <td>{{ $item->product->name }}</td>
            <td> @php
              $returnDate = Carbon\Carbon::parse($item->return_date);
              $rentDate = Carbon\Carbon::parse($item->rent_date);
              $price = floatval($item->product->price);
              $daysDifference = ($rentDate->diffInDays($returnDate))+1;
              $total = $price * $daysDifference;
              @endphp
              Rp{{ $total }}
            </td>
            <td>
              <div class="row">
                <div class="col-12">
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $item->id }}"><i class="bi-x-lg"></i>
                    <span>Batal</span>
                  </button>
                </div>
              </div>
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
                    <img src="{{ asset('storage/product_img/'.$item->product->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                  </div>
                  <p>Nama Alat:<br>{{ $item->product->name }}</p>
                  <p>Tanggal peminjaman:<br>{{ \Carbon\Carbon::parse($item->rent_date)->translatedFormat('j F Y') }}</p>
                  <p>Tanggal pengembalian:<br>{{ \Carbon\Carbon::parse($item->return_date)->translatedFormat('j F Y') }}</p>
                  <p>Total Harga:<br>Rp{{ $total }}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="confirmationModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="confirmationModalLabel{{ $item->id }}">Konfirmasi Pembatalan Penyewaan
                  </h5>
                </div>
                <div class="modal-body">
                  Apakah Anda yakin ingin membatalkan penyewaan ini?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                  @php
                  $encryptedTotalPrice = encrypt($total);
                  @endphp
                  <form action="{{ route('BatalPenyewaanPetani()', $item->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{$encryptedTotalPrice}}">
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
    <br>
    <hr>
    <br>
    <div class="row-2">
      <div class="section-title">
        <h2>PENYEWAAN</h2>
        <h6>Daftar Alat Kelompok Tani <a href='#' data-bs-toggle="modal" data-bs-target="#lenderDetailModal{{ $lender->id }}">{{$lender->name}}</a></h6>
      </div>
      <div class="row">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 d-fix mt-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box h-100" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
            <img src="{{ asset('storage/product_img/'.$product->product_img) }}" class="card-img-top w-50 h-50" alt="{{ $product->name }}">
            <h4>{{ $product->name }}</h4>
            <hr>
            <h6>{{ $product->product_description }}</h6>
            <br>
            <h5>Harga sewa per hari: Rp{{ $product->price }}</h5>
            <br>
            @if($product->is_rented == 'yes')
            <h6 style="color:red">Sedang disewa</h6>
            @elseif($product->is_rented == 'no')
            <h6 style="color:green">Dapat disewa</h6>
            @endif
          </div>
        </div>
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detail Alat</h5>
              </div>
              <div class="modal-body">
                <div class="d-flex justify-content-center">
                  <img src="{{ asset('storage/product_img/'.$product->product_img) }}" class="img-fluid w-50 h-50" alt="Gambar Produk">
                </div>
                <p>Nama Alat:<br>{{ $product->name }}</p>
                <p>Deskripsi:<br>{{ $product->product_description }}</p>
                <p>Harga sewa per hari:<br>Rp{{ $product->price }}</p>
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button> -->
                <form action="{{route('SewaAlat()')}}" method="get">
                  @csrf
                  @php
                  $encryptedProductId = encrypt($product->id);
                  @endphp
                  <input type="hidden" name="product_id" value="{{ $encryptedProductId }}">
                  <button type="submit" class="btn btn-success">
                    Sewa
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="modal fade" id="lenderDetailModal{{ $lender->id }}" tabindex="-1" role="dialog" aria-labelledby="lenderDetailModalLabel{{ $lender->id }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <p class="modal-title" id="lenderDetailModalLabel{{ $lender->id }}">Detail Kelompok Tani</p>
              </div>
              <div class="modal-body">
                <div class="modal-img" style="display:flex; justify-content:center;">
                  <img src="{{asset('assets\img\user\default-img-kt.png')}}" style="width: 10rem; height: 10rem;">
                </div>
                <p>Nama Kelompok Tani:<br>{{ $lender->name }}</p>
                <p>Nomor Telepon:<br>{{ $lender->phone }}</p>
                <p>Alamat Kelompok Tani:<br>{{ $lender->street }}, {{ $lender->village->name }}, {{ $lender->village->district->name }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection