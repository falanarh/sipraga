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
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">JADWAL PENGECEKAN KELAS</p>
                <div>
                    <a href="{{ route('koordinator.jadwal-pengecekan-kelas.tambah-form') }}" class="btn btn-dark text-white d-flex align-items-center p-1">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                    </a>
                </div>
            </div>
            <table id="tabelPengecekan" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Admin</th>
                        <th>Status</th>
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
            $('#tabelPengecekan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('koordinator.jadwal-pengecekan-kelas.view') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'nama_ruang',
                        name: 'nama_ruang'
                    },
                    {
                        data: 'admin',
                        name: 'admin'
                    },
                    {
                        data: 'status',
                        name: 'status'
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


    </script>
@endsection