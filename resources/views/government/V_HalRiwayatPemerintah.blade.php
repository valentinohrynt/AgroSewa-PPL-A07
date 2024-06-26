@extends('layouts.dashboard-riwayat-layout')

@section('title', 'Riwayat Pemerintah')

@section('content-head-title')
    <div class="left">
        <h1>Riwayat</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('DashboardPemerintah()') }}">Dashboard</a>
            </li>
            <i class="fas fa-chevron-right"></i>
            <li>
                <a href="#" class="active">Riwayat</a>
            </li>
        </ul>
    </div>
@endsection

@section('sidebar')
    <a href="{{ route('DashboardPemerintah()') }}" class="logo">
        <img src="{{asset('assets/img/logo/jemberkab_logo_original.png')}}" id="logo-jemberkab" alt="">
        <span id="text-logo">Dinas TPHP</span>
    </a>

    <ul class="side-menu top">
        <li class="">
            <a href="{{ route('DashboardPemerintah()') }}" class="nav-link">
                <i class="fa fa-dashboard"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('HalAkunKelompokTaniPemerintah()') }}" class="nav-link">
                <i class="fas fa-people-group"></i>
                <span class="text">Akun Kelompok Tani</span>
            </a>
        </li>
        <li class="">
            <a href="{{ route('HalPengajuanBantuanPemerintah()') }}" class="nav-link">
                <i class="fas fa-chart-simple"></i>
                <span class="text">Pengajuan Bantuan <span id="penyewaan-dot" class="red-dot"></span></span>
            </a>
        </li>
        <li class="active">
            <a href="{{ route('HalRiwayatPemerintah()') }}" class="nav-link">
                <i class="fas fa-history"></i>
                <span class="text">Riwayat</span>
            </a>
        </li>
    </ul>
@endsection

@section('nav')
    <i class="fas fa-bars menu-btn"></i>
    <li class="dropdown"><a href="#"><i class="fas fa-user"></i></a>
        <ul>
            <li><a href="{{ route('HalProfilPemerintah()') }}">Profil <i class="fas fa-user"></i></a></li>
            <li><a data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <font style="color: red;">Logout <i class="fas fa-sign-out"></i></font>
                </a></li>
        </ul>
    </li>
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
                    <th style="text-align:left; padding-left:0.8rem;">Kecamatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lenders as $item)
                    <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
                        <td style="text-align:left; padding-left:0.8rem;">{{ $loop->iteration }}</td>
                        <td style="text-align:left; padding-left:0.8rem;">{{ $item->name }}</td>
                        <td style="text-align:left; padding-left:0.8rem;">{{ $item->village->district->name }}</td>
                        <form id="form_{{ $item->id }}" action="{{ route('HalRiwayatPenyewaanPemerintah()') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="lender_id" value="{{ $item->id }}">
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function filterRows(searchText) {
                $('.table tbody tr').each(function() {
                    var lenderName = $(this).find('td:eq(1)').text().toLowerCase();
                var districtName = $(this).find('td:eq(2)').text().toLowerCase();
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
        $(document).ready(function() {
            function checkEquipmentRequest() {
                $.ajax({
                    url: '{{ route('checkEquipmentRequest()') }}',
                    method: 'GET',
                    success: function(response) {
                        
                        if (response === true) {
                            
                            $('#penyewaan-dot').css('display', 'inline-block');
                        } else {
                            $('#penyewaan-dot').css('display', 'none');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#penyewaan-dot').css('display', 'none');
                        console.error('Error checking for new data:', error);
                    }
                });
            }
            $('#penyewaan-dot').parent().click(function() {
                $('#penyewaan-dot').css('display', 'none');
            });
            setInterval(checkEquipmentRequest, 15000);
            checkEquipmentRequest();
        });
    </script>
@endsection
