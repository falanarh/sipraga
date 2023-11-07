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
            {{-- impor data --}}
            <div class="mb-4">
                <p class="table-title text-dark mb-4">IMPOR DATA</p>
                <input type="file" class="col-6 form-control mb-4" id="lampiran">
                <button type="submit" class="btn btn-dark">Impor</button>
            </div>
            <hr class="my-4">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DATA SARANA DAN PRASARANA KELAS</p>
                <div>
                    <a href="/admin/data-master/tambah-sarpras" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>NUP</th>
                        <th>Jenis Sarpras</th>
                        <th>Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>11002</td>
                        <td>1</td>
                        <td>
                            <div class="bg-rounded-jenis rounded-pill">Kursi</div>
                        </td>
                        <td>
                            341
                        </td>
                        <td>
                            <a href="/admin/data-master/edit-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/hapus-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/detail" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>20/09/2023</td>
                        <td>11003</td>
                        <td>1</td>
                        <td>
                            <div class="bg-rounded-jenis rounded-pill">Papan Tulis</div>
                        </td>
                        <td>
                            341
                        </td>
                        <td>
                            <a href="/admin/data-master/edit-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/hapus-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/detail" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>15/09/2023</td>
                        <td>11004</td>
                        <td>1</td>
                        <td>
                            <div class="bg-rounded-jenis rounded-pill">Meja Dosen</div>
                        </td>
                        <td>
                            341
                        </td>
                        <td>
                            <a href="/admin/data-master/edit-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/edit.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/hapus-sarpras" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/trash.svg') }}" alt="">
                            </a>
                            <a href="/admin/data-master/detail" class="btn-act text-dark me-1">
                                <img src="{{ asset('images/icons/eye.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>NUP</th>
                        <th>Jenis Sarpras</th>
                        <th>Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
