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
                <a href="/admin/barang-habis-pakai/tambah-jenis-bhp" class="table-title d-flex text-dark">
                    FORM PENAMBAHAN JENIS BARANG HABIS PAKAI
                </a>
            </div>
            <form class="mt-4" action ="{{route('admin.bhp.tambah-jenis-bhp')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang</label>
                        <input type="text" name="jenis_barang" class="form-control" id="jenis_barang"
                        placeholder="Isi nama jenis barang">
                    @error('jenis_barang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="bhp_id" class="form-label">BHP ID Jenis Barang</label>
                        <input type="text" name="bhp_id" class="form-control" id="bhp_id"
                        placeholder="Isi bhp id">
                    @error('bhp_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan Barang</label>
                    <select id="satuan" name="satuan" class="form-select filter-dropdown">
                        <option value="">Pilih Satuan</option>
                        <option value="Buah">Buah</option>
                        <option value="Buku">Buku</option>
                        <option value="Botol">Botol</option>
                        <option value="Unit">Unit</option>
                        <option value="Set">Set</option>
                        <option value="Lembar">Lembar</option>
                        <option value="Rim">Rim</option>
                        <option value="Kotak">Kotak</option>
                        <option value="Dus">Dus</option>
                        <option value="Pak">Pak</option>
                        <option value="Pasang">Pasang</option>
                        <option value="Keping">Keping</option>
                        <option value="Klip">Klip</option>
                        <option value="Gram">Gram</option>
                        <option value="Liter">Liter</option>
                    </select>
                    @error('satuan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah"
                        placeholder="Tentukan jumlah barang awal">
                    @error('jumlah')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
            document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Terjadi kesalahan",
                    text: '{{ session('error') }}',
                });
            @endif
        });
    </script>
@endsection