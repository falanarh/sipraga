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
                <a href="/admin/data-ruangan" class="table-title d-flex text-dark">
                    DATA RUANGAN
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/data-ruangan/edit-ruang" class="table-title d-flex text-dark">
                    FORM EDIT RUANG
                </a>            
            </div>
            <form class="row">
                <div class="mb-3 col-6">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" class="form-control" id="kode" value="33001" disabled readonly>
                </div>
                <div class="mb-3 col-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" value="331">
                </div>
                <div class="mb-3 col-6">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" class="form-control" id="kapasitas" value="40">
                </div>
                <div class="mb-3 col-6">
                    <label for="gedung" class="form-label">Gedung</label>
                    <input type="number" class="form-control" id="gedung" value="3">
                </div>
                <div class="mb-3">
                    <label for="lantai" class="form-label">Lantai</label>
                    <input type="number" class="form-control" id="lantai" value="3">
                </div>
                {{-- <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="10"></textarea>
                </div> --}}
                <div>
                    <a href="" type="submit" class="btn btn-dark mt-3">Edit</a>
                </div>
            </form>
        </div>
    </div>
@endsection
