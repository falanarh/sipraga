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
            <table id="tabelSarpras" class="table table-striped responsive" style="width: 100%;">
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

    <div class="card">
        <div class="card-body">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DAFTAR JENIS BARANG</p>
                <div>
                    <a href="{{ route('admin.tambah-jenis') }}" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="tabelJenis" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th class="col-2">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th class="col-2">Aksi</th>
                    </tr>
                </tfoot>
            </table>
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
        });

        $(document).ready(function() {
            $('#tabelSarpras').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data-master.sarpras') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nup',
                        name: 'nup'
                    },
                    {
                        data: 'jenis_barang',
                        name: 'jenis_barang'
                    },
                    {
                        data: 'nama_ruang',
                        name: 'nama_ruang'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $(document).ready(function() {
            $('#tabelJenis').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data-master.jenis') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'rounded_color_name',
                        name: 'rounded_color_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $(function() {
            $(document).on('click', '#hapus-aset', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin untuk menghapus data aset?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, redirect ke link hapus
                        window.location.href = link;
                    }
                })
            })
        })

        $(function() {
            $(document).on('click', '#hapus-jenis', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin menghapus data jenis barang?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, redirect ke link hapus
                        window.location.href = link;
                    }
                })
            })
        })
    </script>
@endsection
