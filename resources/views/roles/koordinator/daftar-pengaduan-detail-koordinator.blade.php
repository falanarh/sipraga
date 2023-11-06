{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk koordinator --}}
@section('sidebar')
    @include('partials.sidebar-koordinator')
@endsection

{{-- Menambahkan header untuk koordinator --}}
@section('header')
    @include('partials.header-koordinator')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">
                DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS 
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="arrow-right" width="33px" height="25px">
                101
            </p>
            <table class="table table-striped mt-5" style="width: 100%;">
                <tr>
                    <th class="fw-bolder">Nomor</th>
                    <td>101</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Tanggal</th>
                    <td>23/09/2023</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Kode</th>
                    <td>11001</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Ruang</th>
                    <td>332</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Prioritas</th>
                    <td>Sedang</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Status</th>
                    <td>Dikerjakan</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Teknisi</th>
                    <td>
                        <select id="prioritas" class="form-select border-0 px-0">
                            <option value="">Pilih Nama Admin</option>
                            <option value="Falana">Falana</option>
                            <option value="Sindu">Sindu</option>
                            <option value="Sari">Sari</option>
                        </select>   
                    </td>
                </tr>
                <tr>
                    <th class="fw-bolder">Deskripsi</th>
                    <td>Proyektor tidak menyala</td>
                </tr>
                <tr>
                    <th class="fw-bolder">Bukti</th>
                    <td>
                        <img class="img-fluid" src="{{ asset('images/proyektor-mati.png') }}" alt="proyektor-mati" width="300px" height="300px">
                    </td>
                </tr>
            </table>
            <a href="" class="btn btn-primary mt-4">Terima</a>
            <a href="" class="btn btn-danger mt-4 mx-2">Tolak</a>
        </div>
    </div>
@endsection
