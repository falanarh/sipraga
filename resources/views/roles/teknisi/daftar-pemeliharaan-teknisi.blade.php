{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header-teknisi')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">LAPORAN PEMELIHARAAN DAN PERBAIKAN AC</p>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Teknisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>11001</td>
                        <td>333</td>
                        <td>Falana Rofako</td>
                        <td>AC sudah normal</td>
                        <td>
                            <a href="/teknisi/daftar-pemeliharaan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>20/09/2023</td>
                        <td>11004</td>
                        <td>334</td>
                        <td>Falana Rofako</td>
                        <td>AC sudah normal</td>
                        <td>
                            <a href="/teknisi/daftar-pemeliharaan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
