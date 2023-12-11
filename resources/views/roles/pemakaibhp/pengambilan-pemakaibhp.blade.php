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
            <a href="/pemakaibhp/pengambilan" class="table-title text-dark" style="font-size:18px; font-weight: 600;">
                FORM PENGAMBILAN BARANG BHP </a>
            <form class="mt-4" action ="{{ route('pemakaibhp.pengambilan.ambil') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Barang yang diambil</label>
                    <select type="text" name="jenis_barang" class="form-select" id="jenis_barang">

                        <option value="" selected disabled>Pilih Jenis Barang</option>
                        @foreach ($bhps as $jenis_barangs)
                            <option value="{{ $jenis_barangs->jenis_barang }}">{{ $jenis_barangs->jenis_barang }}</option>
                        @endforeach

                    </select>
                    @error('jenis_barang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jumlah_ambilBHP" class="form-label">Jumlah Barang</label>
                    <input type="number" name="jumlah_ambilBHP" id="jumlah_ambilBHP" class="form-control"
                        placeholder="Isi jumlah barang yang ingin diambil">
                    @error('jumlah_ambilBHP')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nama_ruang" class="form-label">Ruang</label>
                    <select type="string" name="nama_ruang" class="form-select" id="nama_ruang">

                        <option value="" selected disabled>Pilih Ruangan</option>
                        @foreach ($ruangOptions as $option)
                            <option value="{{ $option->nama }}">{{ $option->nama }}</option>
                        @endforeach

                    </select>
                    @error('nama_ruang')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="string" name="keterangan" class="form-control" id="keterangan"
                        placeholder="Tuliskan keterangan bila diperlukan">
                    @error('keterangan')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4"onclick="handleButtonClick()">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Terjadi kesalahan",
                    text: '{{ session('error') }}',
                });
            @endif
            function handleButtonClick() {
                // Lakukan apa yang perlu Anda lakukan sebelum mengarahkan pengguna

                // Arahkan pengguna ke rute pertama
                window.location.href = "{{ route('admin.bhp.tambah-form') }}";

                // Lakukan tindakan lain jika diperlukan

                // Arahkan pengguna ke rute kedua
            }
        });
    </script>
@endsection
