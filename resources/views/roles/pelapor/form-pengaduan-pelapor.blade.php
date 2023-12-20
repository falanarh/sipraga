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
            <p class="table-title text-dark text-uppercase" style="font-size:18px; font-weight: 600; text-align: center;"> Formulir Pengaduan Sarana dan Prasarana Kelas</p>
            <form method="POST" action="{{ route('pelapor.data-pengaduan.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label" name="jenis_barang">Jenis Barang</label>
                    <select id="jenis_barang" class="form-select" name="jenis_barang">
                        {{-- Loop through data from the "barangs" table --}}
                        @foreach($jenisBarangOptions as $option)
                            <option value="{{ $option->nama }}">{{ $option->nama }}</option>
                        @endforeach
                        @error('jenis_barang')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kode_ruang" class="form-label" name="kode_ruang">Ruang</label>
                    <select id="kode_ruang" class="form-select" name="kode_ruang">
                        {{-- Loop through data from the "ruangs" table --}}
                        @foreach($ruangOptions as $option)
                            <option value="{{ $option->kode_ruang }}">{{ $option->nama }}</option>
                        @endforeach
                        @error('kode_ruang')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="mb-3">
                    <label for="prioritas" class="form-label" name="prioritas">Prioritas Masalah</label>
                    <select id="prioritas" class="form-select" name="prioritas">
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                    @error('prioritas')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label" name="deskripsi">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Masalah">
                    @error('deksirpsi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- upload lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label" name="lampiran">Bukti Pengaduan</label>
                    <input type="file" class="form-control" name="lampiran" id="lampiran">
                    @error('lampiran')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
              </form> 
        </div>
    </div>
@endsection
