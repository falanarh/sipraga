{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk pelapor --}}
@section('sidebar')
    @include('partials.sidebar-pelapor')
@endsection

{{-- Menambahkan header untuk pelapor --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS</p> --}}
            <div class="title d-flex mb-4 mt-n3">
                <a href="/pelapor/daftar-pengaduan" class="table-title d-flex align-items-center p-0 m-0" style="font-weight: 700; color: #818181;">
                    DAFTAR PENGADUAN SARPRAS KELAS
                </a>
                <img src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="/pelapor/daftar-pengaduan/detail" class="table-title d-flex text-dark d-flex align-items-center" style="font-weight: 700">
                    101
                </a>            
            </div>
            <table class="table table-striped mt-3" style="width: 100%;">
                <tr>
                    <th class="fw-bolder col-3">Nomor</th>
                    <td class="col-9">101</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Tanggal</th>
                    <td class="col-9">23/09/2023</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Kode</th>
                    <td class="col-9">11001</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Ruang</th>
                    <td class="col-9">332</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Prioritas</th>
                    <td class="col-9">Sedang</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Deskripsi</th>
                    <td class="col-9">AC tiba-tiba mati atau menyala</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Status</th>
                    <td class="col-9">Dikerjakan</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Teknisi</th>
                    <td class="col-9">Falana Rofako</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Bukti</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('images/proyektor-mati.png') }}" alt="proyektor-mati" width="300px" height="300px">
                    </td class="col-9">
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Tanggapan</th>
                    <td class="col-9">-</td>
                </tr>
            </table>
        </div>
    </div>
@endsection