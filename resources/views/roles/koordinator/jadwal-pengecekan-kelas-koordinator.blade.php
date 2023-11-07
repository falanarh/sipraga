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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">JADWAL PENGECEKAN KELAS</p>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>23/09/2023</td>
                        <td>331</td>
                        <td>
                            <div class="bg-rounded-status-pengecekan rounded-pill">Belum dikerjakan</div>
                        </td>
                        <td>
                            <a href="/koordinator/jadwal-pengecekan-kelas/penugasan" class="btn btn-dark tugaskanButton">Tugaskan</a>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>27/09/2023</td>
                        <td>333</td>
                        <td>
                            <div class="bg-rounded-status-pengecekan rounded-pill">Belum dikerjakan</div>
                        </td>
                        <td>
                            <a href="/koordinator/jadwal-pengecekan-kelas/penugasan" class="btn btn-dark tugaskanButton">Tugaskan</a>
                        </td>
                    </tr>
                    <tr>
                        <td>103</td>
                        <td>29/09/2023</td>
                        <td>255</td>
                        <td>
                            <div class="bg-rounded-status-pengecekan rounded-pill">Sudah dikerjakan</div>
                        </td>
                        <td>
                            <a href="" class="btn btn-outline-dark disabled">Tugaskan</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
