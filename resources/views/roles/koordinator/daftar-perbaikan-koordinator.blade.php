{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk koordinator --}}
@section('sidebar')
    @include('partials.sidebar-koordinator')
@endsection

{{-- Menambahkan header untuk koordinator --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">LAPORAN PERBAIKAN SARANA DAN PRASARANA
                KELAS</p>
            <table id="example" class="table table-striped">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Jenis Sarpras</th>
                        <th>Ruang</th>
                        <th>Teknisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>23/09/2023</td>
                        <td>11002</td>
                        <td>AC</td>
                        <td>333</td>
                        <td>Falana Rofako</td>
                        <td>AC sudah normal</td>
                        <td>
                            <a href="/koordinator/daftar-perbaikan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>23/09/2023</td>
                        <td>11232</td>
                        <td>Proyektor</td>
                        <td>334</td>
                        <td>Sindu Dinar</td>
                        <td>Proyektor sudah normal</td>
                        <td>
                            <a href="/koordinator/daftar-perbaikan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Jenis Sarpras</th>
                        <th>Ruang</th>
                        <th>Teknisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection