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
                <a href="/teknisi/daftar-perbaikan" class="table-title d-flex text-dark">
                    CATATAN PERBAIKAN SARANA DAN PRASARANA KELAS
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-perbaikan/detail/{{ $perbaikan->tiket }}" class="table-title d-flex text-dark">
                    {{ $perbaikan->tanggal_selesai->format('Y-m-d') }} - {{ $perbaikan->tiket }}
                </a>
            </div>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder col-3">Tiket</th>
                    <td class="col-9">{{ $perbaikan->tiket }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Tanggal Selesai</th>
                    <td class="col-9">{{ $perbaikan->tanggal_selesai->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Jenis Barang</th>
                    <td class="col-9">{{ $perbaikan->jenis_barang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Kode Barang</th>
                    <td class="col-9">{{ $perbaikan->kode_barang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">NUP</th>
                    <td class="col-9">{{ $perbaikan->nup }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Ruang</th>
                    <td class="col-9">{{ $perbaikan->kode_ruang }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Teknisi</th>
                    <td>
                        {{-- Display the teknisi name --}}
                        @if($perbaikan->teknisi_id)
                            {{ \App\Models\User::find($perbaikan->teknisi_id)->name }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Perbaikan</th>
                    <td class="col-9">{{ $perbaikan->perbaikan }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder col-3">Keterangan</th>
                    <td class="col-9">{{ $perbaikan->keterangan }}</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Lampiran Perbaikan</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('storage/' . $perbaikan->lampiran_perbaikan) }}" alt="lampiran" width="300px" height="300px">
                    </td>
                </tr>
            </table>
            <a href="/teknisi/daftar-perbaikan/detail/update/{{$perbaikan->tiket}}" class="btn btn-success">Ubah</a>
        </div>
    </div>
@endsection
