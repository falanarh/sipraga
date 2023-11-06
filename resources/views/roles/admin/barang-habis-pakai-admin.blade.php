{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk admin --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk admin --}}
@section('header')
    @include('partials.header-admin')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DAFTAR KETERSEDIAAN BARANG HABIS PAKAI</p>
                <div>
                    <a href="/admin/barang-habis-pakai/tambah-bhp" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>Spidol</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>23/09/2023</td>
                        <td>Penghapus</td>
                        <td>70</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>23/09/2023</td>
                        <td>Lampu</td>
                        <td>100</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGAMBILAN BARANG HABIS PAKAI</p>
            <table id="example2" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Ruang</th>
                        <th>Jumlah</th>
                        <th>Nama Pengambil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>Spidol</td>
                        <td>255</td>
                        <td>2</td>
                        <td>Anggy</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>23/09/2023</td>
                        <td>Penghapus</td>
                        <td>324</td>
                        <td>1</td>
                        <td>Sindu</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>23/09/2023</td>
                        <td>Penghapus</td>
                        <td>331</td>
                        <td>1</td>
                        <td>Gita</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Ruang</th>
                        <th>Jumlah</th>
                        <th>Nama Pengambil</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
