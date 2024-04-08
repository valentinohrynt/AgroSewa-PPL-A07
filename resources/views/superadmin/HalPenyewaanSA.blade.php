@extends('layouts.dashboard-penyewaan-layout')

@section('title', 'Penyewaan')

@section('content-head-title')
<div class="left">
  <h1>Penyewaan</h1>
  <ul class="breadcrumb">
    <li>
      <a href="#">Dashboard</a>
    </li>
    <i class="fas fa-chevron-right"></i>
    <li>
      <a href="#" class="active">Daftar Kelompok Tani</a>
    </li>
  </ul>
</div>
@endsection

@section('sidebar')
<a href="#" class="logo">
  <i class="fa fa-user-tie"></i>
  <span class="text">Admin Agrosewa</span>
</a>

<ul class="side-menu top">
  <li>
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
  <li class="active">
    <a href="HalPenyewaanSA" class="nav-link">
      <i class="fas fa-shopping-cart"></i>
      <span class="text">Penyewaan</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link">
      <i class="fas fa-chart-simple"></i>
      <span class="text">Pengajuan Bantuan</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link">
      <i class="fas fa-history"></i>
      <span class="text">Riwayat</span>
    </a>
  </li>
</ul>

<ul class="side-menu">
  <li>
    <a href="#">
      <i class="fas fa-cog"></i>
      <span class="text">Settings</span>
    </a>
  </li>
  <li>
    <a href="logout" class="logout">
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
        <input type="text" id="searchInput" placeholder="Pencarian"/>
        <button type="button" id="searchBtn" class="search-btn">
          <i class="fas fa-search search-icon"></i>
        </button>
      </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Poktan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lenders as $item)
      <tr onclick="submitForm('{{ $item->id }}')" style="cursor: pointer;">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <form id="form_{{ $item->id }}" action="{{ route('HalDataPenyewaanSA') }}" method="post">
          @csrf
          <input type="hidden" name="lender_id" value="{{ $item->id }}">
        </form>
      </tr>
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