{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk admin --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk admin --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="/admin/pengelolaan-peminjaman" class="table-title text-dark d-block mb-4">DAFTAR PENGELOLAAN PEMINJAMAN RUANGAN</a>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Peminjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>07.20-09.00 WIB</td>
                        <td>331</td>
                        <td>
                            <div class="bg-rounded-status-pengelolaan rounded-pill text-center">Menunggu</div>
                        </td>
                        <td>-</td>
                        <td>Sindu Dinar</td>
                        <td>
                            <a href="/admin/pengelolaan-peminjaman/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>19/10/2023</td>
                        <td>15.00-16.00 WIB</td>
                        <td>Auditorium</td>
                        <td>
                            <div class="bg-rounded-status-pengelolaan rounded-pill text-center">Disetujui</div>
                        </td>
                        <td>Falana Rofako</td>
                        <td>Anggy Distria</td>
                        <td>
                            <a href="" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>15/10/2023</td>
                        <td>10.00-12.00 WIB</td>
                        <td>334</td>
                        <td>
                            <div class="bg-rounded-status-pengelolaan rounded-pill text-center">Ditolak</div>
                        </td>
                        <td>Falana Rofako</td>
                        <td>Ahmad Diaz</td>
                        <td>
                            <a href="" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Peminjam</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
