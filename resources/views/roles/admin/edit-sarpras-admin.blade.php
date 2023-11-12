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
            <form method="POST" action="{{ route('admin.data-master.sarpras.edit', [$aset->kode_barang, $aset->nup]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <select class="form-control" id="kode_barang" name="kode_barang" disabled>
                        <option value="">Pilih salah satu kode barang</option>
                        @foreach ($jenisBarangOptions as $option)
                            <option value="{{ $option->kode_barang }}" @if ($aset->kode_barang == $option->kode_barang) selected @endif>
                                {{ $option->kode_barang }} - {{ $option->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" id="nup" name="nup" class="form-control" placeholder="15"
                        value="{{ $aset->nup }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                        value="{{ old('tanggal_masuk', $aset->tanggal_masuk->format('Y-m-d')) }}">
                    @error('tanggal_masuk')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kode_ruang" class="form-label">Kode Ruang</label>
                    <select class="form-control" name="kode_ruang" id="kode_ruang">
                        <option value="">Pilih salah satu ruang</option>
                        @foreach ($ruangOptions as $option)
                            <option value="{{ $option->kode_ruang }}" @if (old('kode_ruang', $aset->kode_ruang) == $option->kode_ruang) selected @endif>
                                {{ $option->kode_ruang }} - {{ $option->nama }}</option>
                        @endforeach
                    </select>
                    @error('kode_ruang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select class="form-control" name="kondisi" id="kondisi">
                        <option value="">Pilih salah satu kondisi</option>
                        <option value="Baik" @if (old('kondisi', $aset->kondisi) == 'Baik') selected @endif>Baik</option>
                        <option value="Rusak" @if (old('kondisi', $aset->kondisi) == 'Rusak') selected @endif>Rusak</option>
                    </select>
                    @error('kondisi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tanggal_pemeliharaan_terakhir" class="form-label">Tanggal Pemeliharaan Terakhir</label>
                    <input type="date" class="form-control" id="tanggal_pemeliharaan_terakhir" name="tanggal_pemeliharaan_terakhir"
                        placeholder="YYYY/MM/DD"
                        value="{{ old('tanggal_pemeliharaan_terakhir', $aset->tanggal_pemeliharaan_terakhir ? $aset->tanggal_pemeliharaan_terakhir->format('Y-m-d') : '') }}">

                    @error('tanggal_pemeliharaan_terakhir')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Barang (Opsional)</label>
                    <input type="text" class="form-control" name="deskripsi" id="deskripsi"
                        value="{{ old('deskripsi', $aset->deskripsi) }}">
                    @error('deskripsi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
