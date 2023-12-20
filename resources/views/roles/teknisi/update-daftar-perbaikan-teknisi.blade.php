@extends('layouts.dashboard')

@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/teknisi/daftar-perbaikan" class="table-title d-flex text-dark">
                    CATATAN PERBAIKAN SARANA DAN PRASARANA KELAS 
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/teknisi/daftar-perbaikan/detail" class="table-title d-flex text-dark">
                    {{ $perbaikan->tiket }}
                </a>            
            </div>
            <form action="{{ route('teknisi.update-perbaikan', ['tiket' => $perbaikan->tiket]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <table class="table table-striped mt-5" style="width: 100%;">
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <select id="kode_barang" name="kode_barang" class="form-control">
                            @foreach($kodeBarangOptions as $kodeBarang)
                                <option value="{{ $perbaikan->kode_barang }}">{{ $kodeBarang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nup" class="form-label">NUP</label>
                        <select id="nup" name="nup" class="form-control">
                            @foreach($nupOptions as $nup)
                                <option value="{{ $nup }}" {{ $nup == $perbaikan->nup ? 'selected' : '' }}>
                                    {{ $nup }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" value="{{ $perbaikan->tanggal_selesai->format("Y-m-d") }}" placeholder="DD/MM/YYYY" name="tanggal_selesai">
                    </div>
                    <div class="mb-3">
                        <label for="perbaikan" class="form-label">Perbaikan</label>
                        <input type="text" class="form-control" id="perbaikan" value="{{ $perbaikan->perbaikan }}" name="perbaikan">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" value="{{ $perbaikan->keterangan }}" name="keterangan">
                    </div>
                    <div class="mb-3">
                        <label for="lampiran_perbaikan" class="form-label">Lampiran Perbaikan</label>
                        <input type="file" class="form-control" id="lampiran_perbaikan" name="lampiran_perbaikan">
                    </div>
                </table>
                <button type="submit" class="btn btn-dark mt-4">Update</button>
            </form>
        </div>
    </div>
@endsection
