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
            <a href="/admin/ketersediaan-ruangan" class="table-title text-dark d-block mb-4">KETERSEDIAAN RUANGAN</a>
            <div class="cards d-flex flex-wrap gap-4">
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text m-0 text-white">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 331</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="/admin/ketersediaan-ruangan/detail" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 332</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="ketersediaan-ruangan/detail" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 333</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 334</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-success">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Audit</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 1</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer I</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer II</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer III</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
