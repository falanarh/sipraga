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
                <a href="/admin/data-master" class="table-title d-flex text-dark">
                    DATA MASTER
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/data-master/edit-sarpras" class="table-title d-flex text-dark">
                    FORM EDIT SARPRAS
                </a>            
            </div>
            <form>
                <div class="mb-3">
                    <label for="kode-barang" class="form-label">Kode Barang</label>
                    <input type="text" class="form-control" id="pemeliharaan">
                </div>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="jenis-barang" class="form-label">Jenis Barang</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="DD/MM/YYYY">
                </div>
                <div class="mb-3">
                    <label for="lokasi-barang" class="form-label">Lokasi Barang</label>
                    <input type="text" class="form-control" id="pemeliharaan">
                </div>
                <div class="mb-3">
                    <label for="kondisi-barang" class="form-label">Kondisi Barang</label>
                    <input type="text" class="form-control" id="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Terakhir Pemeliharaan</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="DD/MM/YYYY">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Deskripsi Barang (Opsional)</label>
                    <input type="text" class="form-control" id="keterangan">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form> 
        </div>
    </div>
@endsection
