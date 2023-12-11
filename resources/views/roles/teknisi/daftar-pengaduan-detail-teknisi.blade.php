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
                <a href="/teknisi/daftar-pengaduan" class="table-title d-flex" style="font-weight: 700; color: #818181">
                    DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS 
                </a>
                <img class="mx-2" src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pengaduan/detail" class="table-title d-flex text-dark" style="font-weight: 700">
                    101
                </a>            
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder">Nomor</th>
                    <td>101</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Tanggal</th>
                    <td>23/09/2023</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Kode</th>
                    <td>11001</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Ruang</th>
                    <td>332</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Prioritas</th>
                    <td>Sedang</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Status</th>
                    <td>Dikerjakan</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Teknisi</th>
                    <td>Falana Rofako</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Bukti</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('images/proyektor-mati.png') }}" alt="proyektor-mati" width="300px" height="300px">
                    </td>
                </tr>
            </table>
            <a href="/teknisi/daftar-pengaduan/detail/catat" class="btn btn-success">Catat Perbaikan</a>
        </div>
    </div>
@endsection
