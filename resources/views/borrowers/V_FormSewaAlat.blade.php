@extends('layouts.penyewaan-layout')

@section('title', 'Transaksi Penyewaan')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepagePetani()')}}">Home</a></li>
<li><a class="nav-link active" href="{{route('HalPenyewaanPetani()')}}">Penyewaan</a></li>
<li><a class="nav-link" href="{{route('HalRiwayatPenyewaanPetani()')}}">Riwayat</a></li>
<li class="dropdown"><a href="#"><span>Profil </span><i class="bi-person-circle"></i></a>
    <ul>
        <li><a href="{{ route('HalProfilPetani()') }}">Profil <i class="bi-person-circle"></i></a></li>
        <li><a href="" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout <i class="bi-box-arrow-right"></i></a></li>
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
                                <img src="{{ asset('storage/product_img/'.$product->product_img) }}" class="card-img-top w-50 h-50" alt="{{ $product->name }}">
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
                            <form action="{{ route('SewaAlatPetani()') }}" method="post" role="form" class="transaction-form px-5 pb-5">
                                @csrf
                                <div class="col pt-5">
                                    <div class="form-group">
                                        <label for="rent_date" class="pb-2">Tanggal awal</label>
                                        <input type="date" name="rent_date" id="rent_date" min="{{ date('Y-m-d') }}" value="{{ isset($rent_date) ? $rent_date : date('Y-m-d') }}" class="form-control">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="return_date" class="pb-2">Tanggal pengembalian</label>
                                        <input type="date" name="return_date" id="return_date" class="form-control" min="{{ date('Y-m-d') }}">
                                        @php
                                        $encryptedProductId = encrypt($product->id);
                                        @endphp
                                        <input name="product_id" value="{{ $encryptedProductId }}" hidden>
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
        var events = @json($events);
        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: events,
        });
        calendar.render();
    });
</script>
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