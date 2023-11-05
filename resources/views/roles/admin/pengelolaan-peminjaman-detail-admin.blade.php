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
            <div class="title d-flex mb-4">
                <a href="/admin/pengelolaan-peminjaman" class="table-title d-flex text-dark">
                    DAFTAR PENGELOLAAN PEMINJAMAN
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/pengelolaan-peminjaman/detail" class="table-title d-flex text-dark">
                    1
                </a>            
            </div>
            {{-- <a href="/admin/pengelolaan-peminjaman" class="table-title text-dark d-block mb-4">DAFTAR PENGELOLAAN PEMINJAMAN
                RUANGAN</a> --}}
            <table class="table table-striped responsive" style="width: 100%;">
                <tr>
                    <th>Nomor</th>
                    <td>1</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>23/09/2023</td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>07.20-09.00 WIB</td>
                </tr>
                <tr>
                    <th>Ruang</th>
                    <td>331</td>
                </tr>
                <tr>
                    <th>Keperluan</th>
                    <td>Kegiatan reorganisasi UKM Komnet</td>
                </tr>
                <tr>
                    <th>Peminjam</th>
                    <td>Sindu Dinar</td>
                </tr>
                <tr>
                    <th>Tanggapan Admin</th>
                    <td>-</td>
                </tr>
            </table>
            <a href="#" id="terima" class="btn btn-primary">Terima</a>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#modal-tolak">
                Tolak
            </button>

            <form action="">
                <!-- Modal -->
                <div class="modal fade" id="modal-tolak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="modal-tolakLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bolder text-uppercase" id="modal-tolakLabel">Tolak Pengajuan Peminjaman Ruangan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tanggapan" class="form-label">Alasan</label>
                                    <textarea class="form-control" id="tanggapan" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
