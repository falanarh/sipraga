{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk admin --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk admin --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/admin/barang-habis-pakai" class="table-title d-flex text-dark">
                    BARANG HABIS PAKAI
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/barang-habis-pakai/tambah-bhp" class="table-title d-flex text-dark">
                    FORM PENAMBAHAN STOK
                </a>            
            </div>
            <form class="mt-4">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Barang</label>
                    <input type="text" class="form-control" id="jenis" placeholder="Spidol">
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="text" class="form-control" id="jumlah" placeholder="50">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form> 
        </div>
    </div>
@endsection
