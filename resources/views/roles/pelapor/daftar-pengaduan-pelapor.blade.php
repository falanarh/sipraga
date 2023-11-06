{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk pelapor --}}
@section('sidebar')
    @include('partials.sidebar-pelapor')
@endsection

{{-- Menambahkan header untuk pelapor --}}
@section('header')
    @include('partials.header-pelapor')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGADUAN SARANA DAN PRASARANA
                KELAS</p>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>23/09/2023</td>
                        <td>11002</td>
                        <td>332</td>
                        <td>
                            <div class="bg-rounded-prior rounded-pill">Sedang</div>
                        </td>
                        <td>
                            <div class="bg-rounded-status rounded-pill">Dikerjakan</div>
                        </td>
                        <td>
                            <a href="/pelapor/daftar-pengaduan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>20/09/2023</td>
                        <td>11003</td>
                        <td>333</td>
                        <td>
                            <div class="bg-rounded-prior rounded-pill">Rendah</div>
                        </td>
                        <td>
                            <div class="bg-rounded-status rounded-pill">Selesai</div>
                        </td>
                        <td>
                            <a href="/pelapor/daftar-pengaduan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>103</td>
                        <td>15/09/2023</td>
                        <td>11004</td>
                        <td>334</td>
                        <td>
                            <div class="bg-rounded-prior rounded-pill">Tinggi</div>
                        </td>
                        <td>
                            <div class="bg-rounded-status rounded-pill">Selesai</div>
                        </td>
                        <td>
                            <a href="/pelapor/daftar-pengaduan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Ruang</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection