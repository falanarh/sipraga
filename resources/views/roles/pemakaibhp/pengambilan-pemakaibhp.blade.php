{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk pemakaibhp --}}
@section('sidebar')
    @include('partials.sidebar-pemakaibhp')
@endsection

{{-- Menambahkan header untuk pemakaibhp --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark text-center" style=""> FORM PENGAMBILAN BARANG BHP </p>
            <form class="mt-4">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Barang yang diambil</label>
                    <input type="text" id="jenis" class="form-control" placeholder="Spidol">
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                    <input type="text" id="jumlah" class="form-control" placeholder="2">
                </div>
                <div class="mb-3">
                    <label for="ruang" class="form-label">Ruang</label>
                    <input type="text" class="form-control" id="ruang" placeholder="255">
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
              </form> 
        </div>
    </div>
@endsection
