@extends('layouts.penyewaan-layout')

@section('title', 'Akun Petani')

@section('navbar-nav')

<li><a class="nav-link" href="{{route('HomepageKT()')}}">Home</a></li>
<li><a class="nav-link active" href="{{route('HalAkunPetaniKT()')}}">Akun Petani</a></li>
<li><a class="nav-link" href="{{route('HalPenyewaanKT()')}}">Penyewaan</a></li>
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

<section id="product-display" class="product-display">
    <div class="container pt-5" data-aos="fade-up">
        @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
        @endif
        <div class="section-title">
            <h2>Akun Petani</h2>
            <h6>DAFTAR AKUN PETANI</h6>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari berdasarkan Nama Petani" id="searchInput">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Petani</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowers as $item)
                @php
                $encryptedBorrowerId = encrypt($item->id);
                @endphp
                <tr onclick="submitForm('{{ $item->id }}')">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <form id="form_{{ $item->id }}" action="{{ route('HalDataAkunPetaniKT', ['borrower_id' => $encryptedBorrowerId]) }}" method="get">
                            @csrf
                            <input type="hidden" name="borrower_id" value="{{ $encryptedBorrowerId }}">
                        </form>
                        <button onclick="event.stopPropagation()" type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $item->id }}">
                            <i class="bi bi-person-x"></i>
                            <span>Blokir</span>
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="confirmationModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel{{ $item->id }}">Konfirmasi Penonaktifan Akun</h5>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menonaktifkan akun ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                <form action="{{ route('BlokirAkunPetani()', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
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
</section>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('.table tbody tr').each(function() {
                var borrowerName = $(this).find('td:eq(1)').text().toLowerCase();
                if (borrowerName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
<script>
    function submitForm(id) {
        document.getElementById('form_' + id).submit();
    }
</script>
@endsection