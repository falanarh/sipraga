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
                <a href="{{ route('admin.bhp') }}" class="table-title d-flex text-dark">
                    DAFTAR JENIS BARANG
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="{{ route('admin.bhp.tambah') }}" class="table-title d-flex text-dark">
                    EDIT
                </a>
            </div>
            {{-- <form method="POST" action="{{ route('admin.bhp.edit.transaksiBHP', $barang->id) }}"> --}}
            <form method="POST" action="{{ route('admin.bhp.edit', $bhp->id) }}">
                @csrf
                @method('PATCH')
            
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                    {{-- <input type="text" name="jenis_barang" class="form-control" id="jenis_barang" value="{{ old('jenis_barang',$barang->jenis_barang) }}"> --}}
                    <select type="string" name="jenis_barang" class="form-select" id="jenis">
                        <option value="" disabled {{ $bhp->jenis_barang ? '' : 'selected' }}>Pilih Jenis Barang</option>
                        <option value="Spidol" {{ $bhp->jenis_barang == 'Spidol' ? 'selected' : '' }}>Spidol</option>
                        <option value="Kertas" {{ $bhp->jenis_barang == 'Kertas' ? 'selected' : '' }}>Kertas</option>
                        <option value="Penghapus" {{ $bhp->jenis_barang == 'Penghapus' ? 'selected' : '' }}>Penghapus</option>
                        <option value="Tinta" {{ $bhp->jenis_barang == 'Tinta' ? 'selected' : '' }}>Tinta</option>
                        <option value="Pensil" {{ $bhp->jenis_barang == 'Pensil' ? 'selected' : '' }}>Pensil</option>
                        <option value="Pulpen" {{ $bhp->jenis_barang == 'Pulpen' ? 'selected' : '' }}>Pulpen</option>
                        <option value="Staples" {{ $bhp->jenis_barang == 'Staples' ? 'selected' : '' }}>Staples</option>
                        <option value="Klip Kertas" {{ $bhp->jenis_barang == 'Klip Kertas' ? 'selected' : '' }}>Klip Kertas</option>
                        <option value="Buku Kuarto" {{ $bhp->jenis_barang == 'Buku Kuarto' ? 'selected' : '' }}>Buku Kuarto</option>
                        <option value="Buku Folio" {{ $bhp->jenis_barang == 'Buku Folio' ? 'selected' : '' }}>Buku Folio</option>
                        <option value="Buku Ekspedisi" {{ $bhp->jenis_barang == 'Buku Ekspedisi' ? 'selected' : '' }}>Buku Ekspedisi</option>
                        
                    </select>                    
                </div>
            
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ old('jumlah', $bhp->jumlah) }}">
                    @error('jumlah')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                {{-- <div class="mb-3">
                    <div class="d-flex">
                        <label for="warna">Pilih Warna:</label>
                        <input class="form-control p-2 ms-3" style="width: 10%;" type="color" id="warna" name="warna" value="{{ old('warna', $barang->warna) }}">
                    </div>
                    @error('warna')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div> --}}
            
                {{-- Tambahkan field lainnya sesuai kebutuhan --}}
            
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
            
        </div>
    </div>
@endsection


