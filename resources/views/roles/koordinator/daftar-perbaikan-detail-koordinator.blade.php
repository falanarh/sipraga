<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk koordinator --}}
@section('sidebar')
    @include('partials.sidebar-koordinator')
@endsection

{{-- Menambahkan header untuk koordinator --}}
@section('header')
    @include('partials.header-koordinator')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-weight: 600;">
                LAPORAN PERBAIKAN SARANA DAN PRASARANA KELAS 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="arrow-right" width="33px" height="25px">
                29/11/2023-10113
            </p>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder col-3">Tanggal Selesai</th>
                    <td class="col-9">29/11/2023</td>
                </tr>   
                <tr>
                    <th class="fw-bolder col-3">Nomor</th>
                    <td class="col-9">10113</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Ruang</th>
                    <td class="col-9">332</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Teknisi</th>
                    <td class="col-9">Falana</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Jenis Sarpras</th>
                    <td class="col-9">AC</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Perbaikan</th>
                    <td class="col-9">Pengisian Freon</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Keterangan</th>
                    <td class="col-9">AC sudah normal</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Lampiran</th>
                    <td class="col-9">bit.ly/aaaa</td>
                </tr>
            </table>
            <button type="button" class="btn btn-primary mt-4">
                <i class="fas fa-print"></i>  Cetak</button>
        </div>
    </div>
@endsection
