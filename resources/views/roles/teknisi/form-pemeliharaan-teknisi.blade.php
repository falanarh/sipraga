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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;"> JADWAL PEMELIHARAAN AC 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="" style="width: 25px;height: 25px;">
                FORM PEMELIHARAAN AC
            </p>
            <form method="POST" action="{{ route('teknisi.jadwal.update', [$jadwalPemeliharaanAc->nup, $jadwalPemeliharaanAc->ruang->nama]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" id="nup" name="nup" class="form-control" placeholder="15"
                        value="{{ $jadwalPemeliharaanAc->nup }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" id="ruang" name="ruang" class="form-control" placeholder="332"
                        value="{{ $jadwalPemeliharaanAc->ruang->nama }}" disabled>
                </div>
                {{-- <fieldset disabled>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" id="nup" class="form-control" placeholder="NUP Barang">
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" id="ruang" class="form-control" placeholder="332">
                </div>
                </fieldset> --}}
                {{-- <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="DD/MM/YYYY">
                </div> --}}
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                </div>
                <div class="mb-3">
                    <label for="pemeliharaan" class="form-label">Pemeliharaan</label>
                    <input type="text" class="form-control" id="pemeliharaan" name="pemeliharaan">
                </div>
                <div class="mb-3">
                    <label for="perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" class="form-control" id="perbaikan" name="perbaikan">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan">
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
