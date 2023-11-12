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
                <a href="/admin/data-ruangan/tambah-ruang" class="table-title d-flex text-dark">
                    FORM TAMBAH RUANG
                </a>            
            </div>
            <form class="row" method="POST" action="{{ route('admin.data-ruangan.store') }}">
                @csrf
                <div class="mb-3 col-6">
                    <label for="kode_ruang" class="form-label">Kode Ruang</label>
                    <input type="text" name="kode_ruang" class="form-control" id="kode_ruang" value="{{ old('kode_ruang') }}" required>
                    @error('kode_ruang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="kapasitas" class="form-label">Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" class="form-control" id="kapasitas" value="{{ old('kapasitas') }}" required>
                    @error('kapasitas')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="gedung" class="form-label">Gedung</label>
                    <input type="number" name="gedung" class="form-control" id="gedung" value="{{ old('gedung') }}" required>
                    @error('gedung')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="lantai" class="form-label">Lantai</label>
                    <input type="number" name="lantai" class="form-control" id="lantai" value="{{ old('lantai') }}" required>
                    @error('lantai')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="10"></textarea>
                </div> --}}
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

