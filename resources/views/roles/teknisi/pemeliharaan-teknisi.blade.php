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
            <form>
                <fieldset disabled>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" id="nup" class="form-control" placeholder="NUP Barang">
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
                    <label for="pemeliharaan" class="form-label">Pemeliharaan</label>
                    <input type="text" class="form-control" id="pemeliharaan">
                </div>
                <div class="mb-3">
                    <label for="perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="10"></textarea>
                </div>
                {{-- upload lampiran --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <input type="file" class="form-control" id="lampiran">
                </div>
                <button type="submit" class="btn btn-primary mt-4" >Submit</button>
              </form> 
        </div>
    </div>
@endsection