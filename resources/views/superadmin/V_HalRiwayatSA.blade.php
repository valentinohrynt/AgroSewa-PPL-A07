@extends('layouts.dashboard-riwayat-layout')

@section('title', 'Riwayat Pemerintah')

@section('content-head-title')
<div class="left">
    <h1>Riwayat</h1>
    <ul class="breadcrumb">
        <li>
            <a href="DashboardSA">Dashboard</a>
        </li>
        <i class="fas fa-chevron-right"></i>
        <li>
            <a href="#" class="active">Daftar Kelompok Tani</a>
        </li>
    </ul>
</div>
@endsection

@section('sidebar')
<a href="DashboardSA" class="logo">
    <i class="fa fa-user-tie"></i>
    <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
    <li class="">
        <a href="DashboardSA" class="nav-link">
            <i class="fa fa-dashboard"></i>
            <span class="text">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#" class="nav-link">
            <i class="fas fa-people-group"></i>
            <span class="text">Akun</span>
        </a>
    </li>
    <li class="">
        <a href="{{route('HalPenyewaanSA()')}}" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="text">Penyewaan</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('HalRiwayatSA()')}}" class="nav-link">
            <i class="fas fa-history"></i>
            <span class="text">Riwayat</span>
        </a>
    </li>
</ul>

<ul class="side-menu">
    <li>
        <a href="{{ route('logout') }}" class="logout">
            <i class="fas fa-right-from-bracket"></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>
@endsection

@section('content-table-data')

<div class="order">
    <div class="head">
        <h3>Daftar Kelompok Tani</h3>
        <div class="form-input">
            <input type="text" id="searchInput" placeholder="Pencarian" />
            <button type="button" id="searchBtn" class="search-btn">
                <i class="fas fa-search search-icon"></i>
            </button>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align:left; padding-left:1rem;">No.</th>
                <th style="text-align:left; padding-left:0.8rem;">Nama Poktan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lenders as $item)
            <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                <td style="text-align:left; padding-left:0.8rem;"><a onclick="event.stopPropagation();" data-bs-toggle="modal" data-bs-target="#lenderDetailModal{{ $item->id }}">{{ $item->name }}</a></td>
                <form id="form_{{ $item->id }}" action="{{ route('HalRiwayatPenyewaanSA()') }}" method="post">
                    @csrf
                    <input type="hidden" name="lender_id" value="{{ $item->id }}">
                </form>
            </tr>
            <div class="modal fade" id="lenderDetailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="lenderDetailModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="lenderDetailModalLabel{{ $item->id }}">Detail Kelompok Tani</h6>
                        </div>
                        <div class="modal-body">
                            <div class="modal-img" style="display:flex; justify-content:center;">
                                <img src="{{asset('assets\img\user\default-img-kt.png')}}" style="width: 10rem; height: 10rem;">
                            </div>
                            <h6>Nama Kelompok Tani:</h6>
                            <h3>{{ $item->name }}</h3>
                            <br>
                            <h6><strong>Nomor Telepon:</strong></h6>
                            <h3>{{ $item->phone }}</h3>
                            <br>
                            <h6><strong>Alamat:</strong></h6>
                            <h3>{{ $item->street }}, {{ $item->village->name }}, {{ $item->village->district->name }}</h3>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        function filterRows(searchText) {
            $('.table tbody tr').each(function() {
                var lenderName = $(this).find('td:eq(1)').text().toLowerCase();
                if (searchText === '' || lenderName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        $('#searchBtn').on('click', function() {
            var searchText = $('#searchInput').val().toLowerCase();
            filterRows(searchText);
        });
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            if (searchText === '') {
                $('.table tbody tr').show();
            }
        });
    });
</script>

@endsection