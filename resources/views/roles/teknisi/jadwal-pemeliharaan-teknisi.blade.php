{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk teknisi --}}
@section('sidebar')
    @include('partials.sidebar-teknisi')
@endsection

{{-- Menambahkan header untuk teknisi --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">JADWAL PEMELIHARAAN AC</p> --}}
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">JADWAL PEMELIHARAAN AC</p>
                <div>
                    <a href="{{ route('teknisi.jadwal.generate') }}" id="generate"
                        class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Generate
                    </a>
                </div>
            </div>
            <table id="tabeljadwal" class="table table-striped responsive" style="width: 100%">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th>Aksi</th>
                    </tr>
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

        $(function() {
            $(document).on('click', '#generate', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin ingin melakukan generate jadwal?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, generate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, redirect ke link
                        window.location.href = link;
                    }
                })
            })
        })

        $(function() {
            $(document).on('click', '#ubah', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin ingin melakukan monitoring AC tersebut?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lakukan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, redirect ke link
                        window.location.href = link;
                    }
                })
            })
        })

        $(document).ready(function() {
            $('#tabeljadwal').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('teknisi.jadwal.ac') }}",
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
                        data: 'ruang',
                        name: 'ruang'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'teknisi',
                        name: 'teknisi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });
        });
    </script>
@endsection

@section('additional-css')
    <style>
        .bg-rounded-status-monitoring {
            padding: 2px 10px;
            /* Untuk memberikan ruang di dalam elemen */
            color: #fff;
            /* Untuk mengubah warna teks agar lebih terlihat di latar belakang */
            text-align: center;
            display: inline-block;
        }
    </style>
@endsection

@section('additional-js')
    <script>
        let elements6 = document.querySelectorAll(".bg-rounded-status-monitoring");
        elements6.forEach((element) => {
            if (element.textContent === "Belum Dikerjakan") {
                element.style.backgroundColor = "#FFAE1F";
            } else if (element.textContent === "Sedang Dikerjakan") {
                element.style.backgroundColor = "#539BFF";
            } else if (element.textContent === "Selesai Dikerjakan") {
                element.style.backgroundColor = "#13DEB9";
            }
        });
    </script>
@endsection
