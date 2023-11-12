{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-admin')
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
                <a href="{{ route('admin.data-master') }}" class="table-title d-flex text-dark">
                    DATA MASTER
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="{{ route('admin.data-master.sarpras.detail', ['kode_barang' => $aset->kode_barang, 'nup' => $aset->nup]) }}" class="table-title d-flex text-dark">
                    {{ $aset->kode_barang }}/{{ $aset->nup }}
                </a>            
            </div>
            <table class="table table-striped responsive" style="width: 100%;">
                <tr>
                    <th class="col-3">Kode Barang</th>
                    <td class="col-9">{{ $aset->kode_barang }}</td>
                </tr>
                <tr>
                    <th class="col-3">NUP</th>
                    <td class="col-9">{{ $aset->nup }}</td>
                </tr>
                <tr>
                    <th class="col-3">Jenis Barang</th>
                    <td class="col-9">{{ $aset->barang->nama }}</td>
                </tr>
                <tr>
                    <th class="col-3">Tanggal Masuk</th>
                    <td class="col-9">{{ $aset->tanggal_masuk->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th class="col-3">Ruang</th>
                    <td class="col-9">{{ $aset->ruang->nama }}</td>
                </tr>
                <tr>
                    <th class="col-3">Kondisi</th>
                    <td class="col-9">{{ $aset->kondisi }}</td>
                </tr>
                <tr>
                    <th class="col-3">Tanggal Pemeliharaan Terakhir</th>
                    <td class="col-9">
                        @if ($aset->tanggal_pemeliharaan_terakhir)
                            {{ $aset->tanggal_pemeliharaan_terakhir->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="col-3">Deskripsi Barang</th>
                    <td class="col-9">{{ $aset->deskripsi }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
