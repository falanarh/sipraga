{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header-teknisi')
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
                <a href="/teknisi/daftar-pemeliharaan/detail" class="table-title d-flex text-dark">
                    23/09/2023-11003
                </a>            
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder">Tanggal Selesai</th>
                    <td>23/09/2023</td>
                </tr>
                <tr>
                    <th class="fw-bolder">NUP</th>
                    <td>11003</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Ruang</th>
                    <td>333</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Teknisi</th>
                    <td>Falana Rofako</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Pemeliharaan</th>
                    <td>Pembersihan AC</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Keterangan</th>
                    <td>AC sudah normal</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Lampiran</th>
                    <td>Link: bit.ly/Pemeliharaan-23/09/2023-11003</td>
                </tr>
            </table>
            <a href="" class="btn btn-success mt-4">Cetak</a>
        </div>
    </div>
@endsection
