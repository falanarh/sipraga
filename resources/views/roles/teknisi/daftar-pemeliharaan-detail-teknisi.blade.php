{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">LAPORAN PEMELIHARAAN DAN PERBAIKAN AC 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" style="width: 25px;height: 25px;">
                23/09/2023-11003
            </p> --}}
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-pemeliharaan" class="table-title d-flex text-dark">
                    LAPORAN PEMELIHARAAN DAN PERBAIKAN AC 
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pemeliharaan/detail/{{ $pemeliharaanAc->pemeliharaan_ac_id }}" class="table-title d-flex text-dark">
                    {{ $pemeliharaanAc->tanggal_selesai->format('d/m/Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}
                </a>            
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder">Tanggal Selesai</th>
                    <td>{{ $pemeliharaanAc->tanggal_selesai->format('d/m/Y'); }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Kode Barang</th>
                    <td>{{ $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang; }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">NUP</th>
                    <td>{{ $pemeliharaanAc->jadwalPemeliharaanAc->nup; }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Merek</th>
                    <td>{{ $ac->merek; }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Ruang</th>
                    <td>{{ $pemeliharaanAc->jadwalPemeliharaanAc->ruang->nama; }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Teknisi</th>
                    <td>{{ $pemeliharaanAc->jadwalPemeliharaanAc->user->name; }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Pemeliharaan</th>
                    <td>{{ $pemeliharaanAc->judul_pemeliharaan }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Perbaikan</th>
                    <td @if(empty($pemeliharaanAc->judul_perbaikan)) style="display:none;" @endif>
                        {{ $pemeliharaanAc->judul_perbaikan }}
                    </td>
                </tr>
                <tr>
                    <th class="fw-bolder">Keterangan</th>
                    <td>{{ $pemeliharaanAc->keterangan }}</td>
                </tr>
                {{-- <tr>
                    <th class="fw-bolder">Lampiran</th>
                    <td><a target="_blank" href="/{{ $pemeliharaanAc->file_path }}">lampiran-{{ $pemeliharaanAc->tanggal_selesai->format('d-m-Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}</a></td>
                </tr> --}}
                <tr>
                    <th class="fw-bolder">Lampiran</th>
                    <td>
                        @if ($pemeliharaanAc->file_path)
                            <a target="_blank" href="/storage/{{ $pemeliharaanAc->file_path }}">lampiran-{{ $pemeliharaanAc->tanggal_selesai->format('d-m-Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}</a>
                        @else
                            Tidak ada lampiran
                        @endif
                    </td>
                </tr>                
            </table>
            <div class="mt-4 d-flex align-items-center">
                <a href="/teknisi/daftar-pemeliharaan/detail/{{ $pemeliharaanAc->pemeliharaan_ac_id }}/edit" class="btn btn-dark text-white align-items-center me-2">Edit</a>
                <!-- Button trigger modal -->
                <form action="{{ route('teknisi.daftar-pemeliharaan-detail.ekspor', ['pemeliharaan_ac_id' => $pemeliharaanAc->pemeliharaan_ac_id]) }}" method="GET" id="cetakForm">
                    @csrf
                    <button type="submit" class="btn btn-success">Cetak</button>
                </form>
            </div>            
            {{-- <a href="" class="btn btn-success mt-4">Cetak</a> --}}
        </div>
        <!-- Modal -->
        {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <form action="{{ route('teknisi.daftar-pemeliharaan-detail.ekspor', ['pemeliharaan_ac_id' => $pemeliharaan_ac_id]) }}" class="modal-dialog" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">CETAK LAPORAN DETAIL PEMELIHARAAN AC</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        @csrf
                        <div class="mb-4">
                            <label class="mb-1 fw-bold" for="filterTanggalSelesai">Tanggal Selesai:</label>
                            <input type="date" id="filterTanggalSelesai" name="filter_tanggal_selesai" class="form-control" required>
                        </div>
                    </div>
                    <!-- Input hidden untuk menyimpan nilai pemeliharaan_ac_id -->
                    <input type="hidden" name="pemeliharaan_ac_id" value="{{ $pemeliharaanAc->pemeliharaan_ac_id }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ekspor</button>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
@endsection

@section('additional-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap pesan "Ruang berhasil ditambahkan"
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            @endif
        });
    </script>
@endsection