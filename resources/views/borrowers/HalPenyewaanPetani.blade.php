@extends('layouts.penyewaan-layout')

@section('title', 'Penyewaan')

@section('navbar-nav')
<li><a class="nav-link" href="HomepagePetani">Home</a></li>
<li><a class="nav-link active" href="#">Penyewaan</a></li>
<li><a class="nav-link" href="riwayat">Riwayat</a></li>
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
    <div class="row-2">
      @if (session('status')=='error')
      <div class="alert alert-danger mb-5">
        {{session('message')}}
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
        <h6>Penyewaan yang sedang berjalan</h6>
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
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rentTransactions as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->transaction_number }}</td>
            <td>{{ $item->product->name }}</td>
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
              <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#editModal{{ $item->id }}"><i class="bi-info-circle"></i>
                Detail
              </button>
            </td>
          </tr>
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
        <h6>Daftar Alat</h6>
      </div>

      <div class="row">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 d-fix mt-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box h-100" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
            <img src="{{ asset('storage/product_img/'.$product->product_img) }}" class="card-img-top w-50 h-50"
              alt="{{ $product->name }}">
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
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex justify-content-center">
                  <img src="{{ asset('storage/product_img/'.$product->product_img) }}" class="img-fluid w-50 h-50"
                    alt="Gambar Produk">
                </div>
                <h6><strong>Nama Alat:</strong><br> {{ $product->name }}</p>
                  <h6><strong>Deskripsi:</strong><br> {{ $product->product_description }}</p>
                    <h6><strong>Harga sewa per hari:</strong><br> Rp{{ $product->price }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <form action="" method="post">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  <a class="btn btn-success"
                    href="{{ route('transaksi-penyewaan', ['product_id' => $product->id]) }}">Sewa</a>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection