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
            {{-- impor data --}}
            <div class="mb-4">
                <p class="table-title text-dark mb-4">IMPOR DATA RUANGAN</p>
                <form action="{{ route('admin.data-ruangan.impor') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls" class="col-6 form-control" id="file">
                    @error('file')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-dark mt-4">Impor</button>
                </form>
            </div>
            <hr class="my-4">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title mb-4">DATA RUANGAN</p>
                <div>
                    <a href="/admin/data-ruangan/tambah-ruang" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="tabelruang" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Gedung</th>
                        <th>Lantai</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Gedung</th>
                        <th>Lantai</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap pesan "Ruang berhasil ditambahkan"
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            @endif
        });

        $(document).ready(function() {
            $('#tabelruang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data-ruangan.view') }}", // Sesuaikan dengan route yang benar
                columns: [
                    {
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'kode_ruang',
                        name: 'kode_ruang'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'gedung',
                        name: 'gedung'
                    },
                    {
                        data: 'lantai',
                        name: 'lantai'
                    },
                    {
                        data: 'kapasitas',
                        name: 'kapasitas'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });

        $(function() {
            $(document).on('click', '#hapus-ruang', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin untuk menghapus data ruang?',
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

        // Optional: Tambahkan SweetAlert2 ketika form berhasil disubmit
        // var submitBtn = document.getElementById('btn-ruang');
        // if (submitBtn) {
        //     submitBtn.addEventListener('click', function() {
        //         Swal.fire({
        //             icon: 'success',
        //             title: 'Success!',
        //             text: 'Barang berhasil ditambahkan',
        //         });
        //     });
        // }
    </script>
@endsection
