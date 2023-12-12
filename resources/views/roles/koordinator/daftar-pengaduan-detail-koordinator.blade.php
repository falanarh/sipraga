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
                            <option value="">Pilih Nama Teknisi</option>
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
                        <img class="img-fluid" src="{{ asset('images/proyektor-mati.png') }}" alt="proyektor-mati"
                            width="300px" height="300px">
                    </td>
                </tr>
            </table>
            {{-- <a href="" class="btn btn-primary mt-4">Terima</a>
            <a href="" class="btn btn-danger mt-4 mx-2">Tolak</a> --}}
            <a href="#" id="terima-pengaduan" class="btn btn-primary">Terima</a>

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
                                <h1 class="modal-title fs-5 fw-bolder text-uppercase" id="modal-tolakLabel">Tolak Pengaduan Sarpras</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
