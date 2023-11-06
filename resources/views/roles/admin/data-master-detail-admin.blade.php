{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header-admin')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/admin/data-master" class="table-title d-flex text-dark">
                    DATA MASTER
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/data-master/detail" class="table-title d-flex text-dark">
                    11002
                </a>            
            </div>
            <table class="table table-striped responsive" style="width: 100%;">
                <tr>
                    <th class="col-3">Kode Barang</th>
                    <td class="col-9">11002</td>
                </tr>
                <tr>
                    <th class="col-3">NUP</th>
                    <td class="col-9">1</td>
                </tr>
                <tr>
                    <th class="col-3">Jenis Barang</th>
                    <td class="col-9">Kursi</td>
                </tr>
                <tr>
                    <th class="col-3">Tanggal Masuk</th>
                    <td class="col-9">23/09/2023</td>
                </tr>
                <tr>
                    <th class="col-3">Lokasi Barang</th>
                    <td class="col-9">341</td>
                </tr>
                <tr>
                    <th class="col-3">Kondisi Barang</th>
                    <td class="col-9">Baik</td>
                </tr>
                <tr>
                    <th class="col-3">Tanggal Terakhir Pemeliharaan</th>
                    <td class="col-9">-</td>
                </tr>
                <tr>
                    <th class="col-3">Deskripsi Barang</th>
                    <td class="col-9">Kursi berbahan kayu dan metal</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
