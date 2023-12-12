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
            <form class="" action="{{ route('koordinator.jadwal-pengecekan-kelas.penugasan', ['pengecekan_kelas_id' => $pengecekanKelas->pengecekan_kelas_id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $pengecekanKelas->tanggal->format('Y-m-d') }}" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" name="kode_ruang" id="ruang" class="form-control" value="{{ $pengecekanKelas->ruang->nama }}" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="admin_id" class="form-label">Admin</label>
                    <select class="form-select" name="admin_id" id="admin_id">
                        <option value="">Pilih salah satu admin</option>
                        @foreach ($adminUsers as $adminUser)
                            <option value="{{ $adminUser->user_id }}">
                                {{ $adminUser->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Tugaskan</button>
              </form>
        </div>
    </div>
@endsection


