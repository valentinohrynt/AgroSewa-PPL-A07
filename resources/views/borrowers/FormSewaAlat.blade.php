@extends('layouts.penyewaan-layout')

@section('title', 'Transaksi Penyewaan')

@section('navbar-nav')

<li><a class="nav-link" href="HomepagePetani">Home</a></li>
<li><a class="nav-link active" href="HalPenyewaanPetani">Penyewaan</a></li>
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
            <h2>TRANSAKSI PENYEWAAN</h2>
            <h6>Silahkan lengkapi formulir berikut</h6>
        </div>
        <div class="row">
            <div class="col-md-4 pb-sm-5 pb-5">
                <div id="calendar"></div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="row px-5 py-5">
                        <div class="col">
                            <div class="row-2 d-flex justify-content-center">
                                <img src="{{ asset('storage/product_img/'.$product->product_img) }}"
                                    class="card-img-top w-50 h-50" alt="{{ $product->name }}">
                            </div>
                            <div class="row-2 pt-5 px-5">
                                <div class="d-flex justify-content-center pb-5">
                                    <h4>Detail Alat</h4>
                                </div>
                                <h5>Nama Alat: {{$product->name}}</h5>
                                <h5>Harga sewa per hari: Rp{{$product->price}}</h5>
                            </div>
                        </div>
                        <br>
                        <div class="col">
                            <form action="{{ route('transaksi-penyewaan') }}" method="post" role="form"
                                class="transaction-form px-5 pb-5">
                                @csrf
                                <div class="col pt-5">
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
                                        <input name="product_id" value={{$product->id}} hidden>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="form-control btn btn-success mt-5">Sewa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: {!! json_encode($events) !!},
    });
    calendar.render();
});
</script>
@endsection