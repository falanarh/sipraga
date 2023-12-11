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
                <a href="/admin/barang-habis-pakai" class="table-title d-flex" style="font-weight: 700; color:#818181">
                    BARANG HABIS PAKAI
                </a>
                <img class="mx-2" src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="/admin/barang-habis-pakai/tambah-bhp" class="table-title d-flex text-dark" style="font-weight: 700">
                    FORM PENAMBAHAN STOK
                </a>
            </div>
            <form class="mt-4" action ="{{ route('admin.bhp.tambah') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>

                    <select type="text" name="jenis_barang" class="form-select" id="jenis_barang">\

                        <option value="" selected disabled>Pilih Jenis Barang</option>
                        @foreach ($bhps as $jenis_barangs)
                                <option value="{{ $jenis_barangs->jenis_barang }}">{{ $jenis_barangs->jenis_barang }}</option>
                        @endforeach
                    </select>
                    @error('jenis_barang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah"
                        placeholder="Isi jumlah barang yang ingin ditambah">
                    @error('jumlah')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
