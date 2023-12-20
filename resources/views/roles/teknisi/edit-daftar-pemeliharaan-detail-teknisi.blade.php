div{{-- Mewarisi semua konten dari view dashboard --}}
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
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-pemeliharaan" class="table-title d-flex text-dark">
                    LAPORAN PEMELIHARAAN DAN PERBAIKAN AC
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pemeliharaan/detail/{{ $pemeliharaanAc->pemeliharaan_ac_id }}" class="table-title d-flex text-dark">
                    {{ $pemeliharaanAc->tanggal_selesai->format('d/m/Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pemeliharaan/detail/{{ $pemeliharaanAc->pemeliharaan_ac_id }}/edit" class="table-title d-flex text-dark">
                    EDIT
                </a>            
            </div>
            <form class="row" method="POST" action="{{ route('teknisi.daftar-pemeliharaan-detail.edit', $pemeliharaanAc->pemeliharaan_ac_id) }}" enctype="multipart/form-data"> 
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai" value="{{ $pemeliharaanAc->tanggal_selesai->format('Y-m-d') }}">
                </div>
                <div class="mb-3">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="{{ $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang }}" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="nup" class="form-label">NUP</label>
                    <input type="text" name="nup" class="form-control" id="nup" value="{{ $pemeliharaanAc->jadwalPemeliharaanAc->nup }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" name="ruang" class="form-control" id="ruang" value="{{ $pemeliharaanAc->jadwalPemeliharaanAc->ruang->nama }}" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="teknisi" class="form-label">Teknisi</label>
                    <input type="text" name="teknisi" class="form-control" id="teknisi" value="{{ $pemeliharaanAc->jadwalPemeliharaanAc->user->name }}" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="judul_pemeliharaan" class="form-label">Pemeliharaan</label>
                    <input type="text" name="judul_pemeliharaan" class="form-control" id="judul_pemeliharaan" value="{{ $pemeliharaanAc->judul_pemeliharaan }}">
                </div>
                <div class="mb-3">
                    <label for="judul_perbaikan" class="form-label">Perbaikan</label>
                    <input type="text" name="judul_perbaikan" class="form-control" id="judul_perbaikan" value="{{ $pemeliharaanAc->judul_perbaikan }}">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" id="keterangan" value="{{ $pemeliharaanAc->keterangan }}">
                </div>
                <div class="mb-3">
                    <label for="lampiran-view" class="form-label">Lampiran</label>
                    @if ($pemeliharaanAc->file_path)
                        <div class="input-group">
                            <input type="text" name="lampiran-view" class="form-control" id="lampiran-view" value="lampiran-{{ $pemeliharaanAc->tanggal_selesai->format('d-m-Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}" readonly>
                            <a href="/storage/{{ $pemeliharaanAc->file_path }}" target="_blank" class="btn btn-outline-secondary">Buka</a>
                        </div>
                    @else
                        <p>Belum ada lampiran</p>
                        @endif
                </div>
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Unggah Lampiran Baru</label>
                    <input type="file" name="lampiran" class="form-control" id="lampiran">
                </div>
                <div>
                    <button type="submit" class="btn btn-dark mt-3">Simpan</button>
                </div>
            </form>
                {{-- <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran</label>
                    <div class="input-group">
                        <input type="text" name="lampiran" class="form-control" id="lampiran" value="lampiran-{{ $pemeliharaanAc->tanggal_selesai->format('d-m-Y') . '-' . $pemeliharaanAc->jadwalPemeliharaanAc->nup }}" readonly>
                        <a href="/{{ $pemeliharaanAc->file_path }}" target="_blank" class="btn btn-outline-secondary">Buka</a>
                    </div>
                </div> --}}
                {{-- <div class="mb-3">
                    <label for="lampiran" class="form-label">Unggah Lampiran Baru</label>
                    @if($pemeliharaanAc->file_path)
                        <p>File Lampiran: {{ $pemeliharaanAc->file_path }}</p>
                    @endif
                    <input type="file" name="lampiran-baru" class="form-control" id="lampiran">
                </div> --}}
                
                {{-- @if(request()->hasFile('lampiran'))
                    @php
                        $uploadedFile = request()->file('lampiran');
                        $uploadedFilePath = $uploadedFile->store('your/storage/directory');
                    @endphp
                    <input type="hidden" name="lampiran" value="{{ $uploadedFilePath }}">
                @else --}}
                    {{-- Tambahkan kondisi ini untuk mempertahankan nilai file_path --}}
                    {{-- @if(!$pemeliharaanAc->file_path)
                        <input type="hidden" name="lampiran" value="{{ $pemeliharaanAc->file_path }}">
                    @endif
                @endif --}}
                {{-- <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="10"></textarea>
                </div> --}}
        </div>
    </div>
@endsection

@section('additional-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('lampiran');
        var fileLabel = document.getElementById('lampiran-label');

        fileInput.addEventListener('change', function() {
            var fileName = this.value.split('\\').pop();
            fileLabel.innerText = fileName || 'Upload Lampiran';
        });
    });
</script>
@endsection