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
                <a href="/teknisi/daftar-pengaduan/detail/catat" class="table-title d-flex text-dark">
                    FORM CATAT PERBAIKAN
                </a>            
            </div>
            <form>
                <fieldset disabled>
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" id="kode" class="form-control" placeholder="Kode Barang">
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Sarana dan Prasarana</label>
                    <input type="text" id="jenis" class="form-control" placeholder="Jenis Sarana dan Prasarana">
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" id="ruang" class="form-control" placeholder="332">
                </div>
                </fieldset>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="DD/MM/YYYY">
                </div>
                <div class="mb-3">
                    <label for="perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan">
                </div>
                {{-- upload lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <input type="file" class="form-control" id="lampiran">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form> 
        </div>
    </div>
@endsection
