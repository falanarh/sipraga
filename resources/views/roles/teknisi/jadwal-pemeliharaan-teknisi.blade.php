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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">JADWAL PEMELIHARAAN AC</p>
            <table id="example" class="table table-striped responsive" style="width: 100%">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Teknisi</th>
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
                            <div class="bg-rounded-status-monitoring rounded-pill">Belum Dikerjakan</div>
                        </td>
                        <td> - </td>
                        <td>
                            <button type="button" class="btn btn-secondary mx-1">Ubah</button>
                            <button type="button" class="btn btn-outline-success mx-1" disabled>Catat</button>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>20/09/2023</td>
                        <td>11003</td>
                        <td>333</td>
                        <td>
                            <div class="bg-rounded-status-monitoring rounded-pill">Sedang Dikerjakan</div>
                        </td>
                        <td> Falana Rofako  </td>
                        <td>
                            <button type="button" class="btn btn-outline-secondary mx-1" disabled>Ubah</button>
                            <a href="/teknisi/jadwal-pemeliharaan/pemeliharaan" class="btn btn-success mx-1">Catat</a>
                        </td>
                    </tr>
                    <tr>
                        <td>103</td>
                        <td>15/09/2023</td>
                        <td>11004</td>
                        <td>334</td>
                        <td>
                            <div class="bg-rounded-status-monitoring rounded-pill">Selesai Dikerjakan</div>
                        </td>
                        <td> Falana Rofako  </td>
                        <td>
                            <button type="button" class="btn btn-outline-secondary mx-1" disabled>Ubah</button>
                            <button type="button" class="btn btn-outline-success mx-1" disabled>Catat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
