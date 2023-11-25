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
            {{-- <p class="table-title text-dark d-flex" style="font-size:18px; font-weight: 600;"> JADWAL PEMELIHARAAN AC 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" style="width: 25px;height: 25px;">
                FORM PEMELIHARAAN AC
            </p> --}}
            <div class="title d-flex mb-4">
                <a href="/teknisi/jadwal-pemeliharaan" class="table-title d-flex text-dark">
                    JADWAL PEMELIHARAAN AC 
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/jadwal-pemeliharaan/pemeliharaan" class="table-title d-flex text-dark">
                    FORM PEMELIHARAAN AC
                </a>            
            </div>
            <form method="POST" action="{{ route('teknisi.jadwal.pemeliharaan.store', [$jadwalPemeliharaanAc->jadwal_pemeliharaan_ac_id]) }}" enctype="multipart/form-data">
                @csrf
                {{-- hidden input jadwal_pemeliharaan_ac_id --}}
                <input type="hidden" name="jadwal_pemeliharaan_ac_id" value="{{ $jadwalPemeliharaanAc->jadwal_pemeliharaan_ac_id }}">
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" id="nup" name="nup" class="form-control" placeholder="15"
                        value="{{ $jadwalPemeliharaanAc->nup }}" disabled readonly>
                    <input type="hidden" name="nup" value="{{ $jadwalPemeliharaanAc->nup }}">
                </div>                
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" id="ruang" name="ruang" class="form-control" placeholder="332"
                        value="{{ $jadwalPemeliharaanAc->ruang->nama }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                    @error('tanggal_selesai')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="judul_pemeliharaan" class="form-label">Pemeliharaan</label>
                    <input type="text" class="form-control" id="judul_pemeliharaan" name="judul_pemeliharaan">
                    @error('judul_pemeliharaan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="judul_perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="judul_perbaikan" name="judul_perbaikan">
                    @error('judul_perbaikan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                    @error('keterangan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- upload lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <input type="file" class="form-control" accept=".pdf, .jpg, .jpeg" id="lampiran" name="lampiran">
                    @error('lampiran')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>  
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
@endsection

