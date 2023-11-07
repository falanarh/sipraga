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
            <div class="title d-flex mb-4">
                <a href="/koordinator/jadwal-pengecekan-kelas" class="table-title d-flex text-dark">
                    JADWAL PENGECEKAN KELAS
                </a>
                <img class="mx-2" src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/koordinator/jadwal-pengecekan-kelas/penugasan" class="table-title d-flex text-dark">
                    FORM PENUGASAN ADMIN
                </a>            
            </div>
            <form class="">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" placeholder="23/09/2023" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" id="ruang" class="form-control" placeholder="255" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="prioritas" class="form-label">Admin</label>
                    <select id="prioritas" class="form-select">
                        <option value="">Pilih Nama Admin</option>
                        <option value="Falana">Falana</option>
                        <option value="Sindu">Sindu</option>
                        <option value="Sari">Sari</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Tugaskan</button>
              </form>
        </div>
    </div>
@endsection


