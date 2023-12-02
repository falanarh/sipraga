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
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-pengaduan" class="table-title d-flex text-dark">
                    DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS 
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-pengaduan/detail" class="table-title d-flex text-dark">
                    {{ $pengaduans->tiket }}
                </a>            
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder">Tiket</th>
                    <td>{{ $pengaduans->tiket }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Tanggal Pengaduan</th>
                    <td>{{ $pengaduans->tanggal->format('Y-m-d') }}</td>
                </tr>
                {{-- <tr>
                    <th class="fw-bolder">Tanggal Selesai</th>
                    <td>
                        @if ($pengaduans->tanggal_selesai)
                            {{ $pengaduans->tanggal_selesai->format('Y-m-d') }}
                        @else
                            {{ $pengaduans->tanggal_selesai }}
                    </td>
                </tr>                 --}}
                {{-- <tr>
                    <th class="fw-bolder">Kode Barang</th>
                    <td>{{ $pengaduans->kode_barang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">NUP</th>
                    <td>{{ $pengaduans->nup }}</td>
                </tr> --}}
                <tr>
                    <th class="fw-bolder">Jenis Barang</th>
                    <td>{{ $pengaduans->jenis_barang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Ruang</th>
                    <td>{{ $pengaduans->kode_ruang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Prioritas</th>
                    <td>{{ $pengaduans->prioritas }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Status</th>
                    <td>{{ $pengaduans->status }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Deskripsi</th>
                    <td>{{ $pengaduans->deskripsi }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Teknisi</th>
                    <td>
                        {{-- Display the teknisi name --}}
                        @if($pengaduans->teknisi_id)
                            {{ \App\Models\User::find($pengaduans->teknisi_id)->name }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="fw-bolder">Lampiran</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('storage/' . $pengaduans->lampiran) }}" alt="lampiran" width="300px" height="300px">
                    </td>
                </tr>
            </table>
            <a href="/teknisi/daftar-pengaduan/detail/catat/{{$pengaduans->tiket}}" class="btn btn-success">Catat Perbaikan</a>
        </div>
    </div>
@endsection
