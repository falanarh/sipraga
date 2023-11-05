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
            {{-- impor data --}}
            <div class="mb-4">
                <p class="table-title text-dark mb-4">IMPOR DATA RUANGAN</p>
                <input type="file" class="col-6 form-control mb-4" id="lampiran">
                <button type="submit" class="btn btn-dark">Impor</button>
            </div>
            <hr class="my-4">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DATA RUANGAN</p>
                <div>
                    <a href="/admin/data-ruangan/tambah-ruang" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Gedung</th>
                        <th>Lantai</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>33001</td>
                        <td>Ruang Kelas 331</td>
                        <td>3</td>
                        <td>3</td>
                        <td>40</td>
                        <td>
                            <a href="/admin/data-ruangan/edit-ruang" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>33002</td>
                        <td>Ruang Kelas 332</td>
                        <td>3</td>
                        <td>3</td>
                        <td>40</td>
                        <td>
                            <a href="" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>33003</td>
                        <td>Ruang Kelas 333</td>
                        <td>3</td>
                        <td>3</td>
                        <td>40</td>
                        <td>
                            <a href="" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Gedung</th>
                        <th>Lantai</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
