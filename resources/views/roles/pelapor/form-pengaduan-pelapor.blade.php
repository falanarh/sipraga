{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk pelapor --}}
@section('sidebar')
    @include('partials.sidebar-pelapor')
@endsection

{{-- Menambahkan header untuk pelapor --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark text-uppercase" style=" font-weight: 600; text-align: center;"> Formulir Pengaduan Sarana dan Prasarana Kelas</p>
            <form>
                <div class="mb-3">
                    <label for="nup" class="form-label custom-label" >Jenis Barang</label>
                    <select id="nup" class="form-select">
                        <option value="">Pilih Jenis Barang</option>
                        <option value="barang1">Barang 1</option>
                        <option value="barang2">Barang 2</option>
                        <option value="barang3">Barang 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label custom-label">Ruang</label>
                    <select id="ruang" class="form-select">
                        <option value="">Pilih Ruang</option>
                        <option value="r1">Ruang 1</option>
                        <option value="r2">Ruang 2</option>
                        <option value="r3">Ruang 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="prioritas" class="form-label custom-label">Prioritas Masalah</label>
                    <select id="prioritas" class="form-select">
                        <option value="">Pilih Prioritas Masalah</option>
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label custom-label">Deskripsi</label>
                    <input type="textarea" class="form-control" id="deskripsi" placeholder="Deskripsi Masalah">
                </div>
                {{-- upload lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label custom-label">Bukti Pengaduan</label>
                    <input type="file" class="form-control" id="lampiran">
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
              </form> 
        </div>
    </div>
@endsection
