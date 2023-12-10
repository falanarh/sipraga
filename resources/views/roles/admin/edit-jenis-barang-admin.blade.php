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
                <a href="{{ route('admin.data-master') }}" class="table-title d-flex" style="font-weight: 700; color: #818181">
                    DAFTAR JENIS BARANG
                </a>
                <img class="mx-2" src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="{{ route('admin.tambah-jenis') }}" class="table-title d-flex text-dark" style="font-weight: 700">
                    EDIT
                </a>
            </div>
            <form method="POST" action="{{ route('admin.data-master.jenis.edit', $barang->kode_barang) }}">
                @csrf
                @method('PUT')
            
                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="{{ $barang->kode_barang }}" disabled readonly>
                </div>
            
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $barang->nama) }}">
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <div class="d-flex">
                        <label for="warna">Pilih Warna:</label>
                        <input class="form-control p-2 ms-3" style="width: 10%;" type="color" id="warna" name="warna" value="{{ old('warna', $barang->warna) }}">
                    </div>
                    @error('warna')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                {{-- Tambahkan field lainnya sesuai kebutuhan --}}
            
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
            
        </div>
    </div>
@endsection

{{-- @section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="{{ route('admin.data-master') }}" class="table-title d-flex text-dark">
                    DAFTAR JENIS BARANG
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="{{ route('admin.tambah-jenis') }}" class="table-title d-flex text-dark">
                    TAMBAH
                </a>
            </div>
            <form class="mt-4" action="{{ route('admin.tambah-jenis.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="11001" value="{{ old('kode_barang') }}">
                    @error('kode_barang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Komputer" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button id="btn-jenis" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection --}}
