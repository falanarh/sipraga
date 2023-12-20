{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <p class="table-title text-dark" style="font-size:18px; font-weight: 600;"> DAFTAR PENGADUAN 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" style="width: 25px;height: 25px;">
                FORM PENGISIAN CATATAN PERBAIKAN 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" style="width: 25px;height: 25px;">
                102
            </p> --}}
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-pengaduan" class="table-title d-flex text-dark">
                    DAFTAR PENGADUAN
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pengaduan/detail/catat/{{$pengaduan->tiket}}" class="table-title d-flex text-dark">
                    FORM CATAT PERBAIKAN
                </a>            
            </div>
            <form method="POST" action="{{ route('teknisi.perbaikan.store', ['tiket' => $pengaduan->tiket]) }}" enctype="multipart/form-data">
                @csrf
                <fieldset disabled>
                    <div class="mb-3">
                        <label for="tiket" class="form-label">Tiket</label>
                        <input type="text" id="tiket" name="tiket" class="form-control" placeholder="Tiket" value="{{ $pengaduan->tiket }}">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_barang" class="form-label">Jenis Sarana dan Prasarana</label>
                        <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" placeholder="Jenis Sarana dan Prasarana" value="{{ $pengaduan->jenis_barang }}">
                    </div>
                    <div class="mb-3">
                        <label for="kode_ruang" class="form-label">Ruang</label>
                        <input type="text" id="kode_ruang" class="form-control" placeholder="332" name="kode_ruang" value="{{ $pengaduan->kode_ruang }}">
                    </div>
                </fieldset>
                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <select id="kode_barang" name="kode_barang" class="form-control">
                        @foreach($kodeBarangOptions as $kodeBarang)
                            <option value="{{ $kodeBarang }}">{{ $kodeBarang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <select id="nup" name="nup" class="form-control">
                        @foreach($nupOptions as $nup)
                            <option value="{{ $nup }}">{{ $nup }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" placeholder="DD/MM/YYYY" name="tanggal_selesai">
                </div>
                <div class="mb-3">
                    <label for="perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="perbaikan" name="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                </div>
                <div class="mb-3">
                    <label for="lampiran_perbaikan" class="form-label">Lampiran Perbaikan</label>
                    <input type="file" class="form-control" id="lampiran_perbaikan" name="lampiran_perbaikan">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form> 
        </div>
    </div>
@endsection
