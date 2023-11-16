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
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-perbaikan" class="table-title d-flex text-dark">
                    CATATAN PERBAIKAN SARANA DAN PRASARANA KELAS 
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-perbaikan/detail" class="table-title d-flex text-dark">
                    23/09/2023-11003
                </a>            
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder col-3">Tanggal Selesai</th>
                    <td class="col-9">23/09/2023</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">NUP</th>
                    <td class="col-9">11003</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Ruang</th>
                    <td class="col-9">333</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Teknisi</th>
                    <td class="col-9">Falana Rofako</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Perbaikan</th>
                    <td class="col-9">Pengisian Freon 20 Psi</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Keterangan</th>
                    <td class="col-9">AC sudah normal</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Lampiran</th>
                    <td class="col-9"><a href="" style="color: var(--bs-table-color);">bit.ly/Pemeliharaan-23/09/2023-11003</a></td>
                </tr>
            </table>
            <a href="" class="btn btn-dark mt-4">Ubah</a>
        </div>
    </div>
@endsection
