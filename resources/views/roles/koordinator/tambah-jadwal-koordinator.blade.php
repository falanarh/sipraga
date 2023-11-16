{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk koordinator --}}
@section('sidebar')
    @include('partials.sidebar-koordinator')
@endsection

{{-- Menambahkan header untuk koordinator --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/koordinator/jadwal-pengecekan-kelas" class="table-title d-flex text-dark">
                    JADWAL PENGECEKAN KELAS
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/koordinator/jadwal-pengecekan-kelas/tambah-jadwal" class="table-title d-flex text-dark">
                    TAMBAH JADWAL PENGECEKAN KELAS AWAL
                </a>            
            </div>
            <form class="mt-4" method="POST" action="{{ route('koordinator.jadwal-pengecekan-kelas.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="YYYY/MM/DD">
                    @error('tanggal')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kode_ruang" class="form-label">Kode Ruang</label>
                    <select class="form-control" name="kode_ruang" id="kode_ruang">
                        <option value="">Pilih salah satu ruang</option>
                        @foreach ($ruangOptions as $option)
                            <option value="{{ $option->kode_ruang }}">{{ $option->kode_ruang }} - {{ $option->nama }}</option>
                        @endforeach
                    </select>
                    @error('kode_ruang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Buat</button>
              </form> 
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/koordinator/jadwal-pengecekan-kelas" class="table-title d-flex text-dark">
                    JADWAL PENGECEKAN KELAS
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/koordinator/jadwal-pengecekan-kelas/tambah-jadwal" class="table-title d-flex text-dark">
                    TAMBAH JADWAL PENGECEKAN KELAS BARU
                </a>            
            </div>
            <form class="mt-4" method="POST" action="{{ route('koordinator.jadwal-pengecekan-kelas.generate') }}">
                @csrf
                <div class="mb-3">
                    <label for="kode_ruang" class="form-label">Kode Ruang</label>
                    <select class="form-control" name="kode_ruang" id="kode_ruang">
                        <option value="">Pilih salah satu ruang</option>
                        @foreach ($ruangOptions2 as $option)
                            <option value="{{ $option->kode_ruang }}" @if (old('kode_ruang') == $option->kode_ruang) selected @endif>{{ $option->kode_ruang }} - {{ $option->nama }}</option>
                        @endforeach
                    </select>
                    @error('kode_ruang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
              </form> 
        </div>
    </div>
@endsection
