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
            {{-- <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS</p> --}}
            <div class="title d-flex mb-4 mt-n3">
                <a href="/pelapor/daftar-pengaduan" class="table-title d-flex align-items-center p-0 m-0" style="font-weight: 700; color: #818181;">
                    DAFTAR PENGADUAN SARPRAS KELAS
                </a>
                <img src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="/pelapor/daftar-pengaduan/detail" class="table-title d-flex text-dark d-flex align-items-center" style="font-weight: 700">
                    101
                </a>            
            </div>
            <table class="table table-striped mt-3" style="width: 100%;">
                <tr>
                    <th class="fw-bolder col-3">Tiket</th>
                    <td class="col-9">{{ $pengaduan->tiket }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Tanggal</th>
                    <td class="col-9">{{ $pengaduan->tanggal->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Jenis Barang</th>
                    <td class="col-9">{{ $pengaduan->jenis_barang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Kode Barang</th>
                    <td class="col-9" placeholder="-"> 
                    @if($pengaduan->kode_barang)
                        {{ $pengaduan->kode_barang }}
                    @else
                        N/A
                    @endif</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">NUP</th>
                    <td class="col-9" placeholder="-">
                    @if($pengaduan->nup)
                        {{ $pengaduan->nup }}
                    @else
                        N/A
                    @endif</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Ruang</th>
                    <td class="col-9">{{ $pengaduan->nama_ruang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Prioritas</th>
                    <td class="col-9">{{ $pengaduan->prioritas }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Deskripsi</th>
                    <td class="col-9">{{ $pengaduan->deskripsi }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Status</th>
                    <td class="col-9">{{ $pengaduan->status }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Teknisi</th>
                    <td class="col-9" placeholder="-">@if($pengaduan->teknisi_id)
                        {{ \App\Models\User::find($pengaduan->teknisi_id)->name }}
                    @else
                        N/A
                    @endif</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Lampiran</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('storage/' . $pengaduan->lampiran) }}" alt="lampiran" width="300px" height="300px">

                    </td class="col-9">
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Keterangan</th>
                    <td class="col-9" placeholder="-">
                        @if($pengaduan->status === 'Ditolak')
                            {{ $pengaduan->alasan_ditolak }}
                        @elseif($pengaduan->status === 'Selesai')
                            {{ $pengaduan->keterangan }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>                
            </table>
        </div>
    </div>
@endsection