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
            <p class="table-title text-dark">
                DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="arrow-right" width="33px" height="25px">
                101
            </p>
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
            <button type="button" class="btn btn-success">Catat Perbaikan</button>
        </div>
    </div>
@endsection
