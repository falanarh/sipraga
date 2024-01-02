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
            <a href="/admin/pengelolaan-peminjaman" class="table-title text-dark d-block mb-4">DAFTAR PENGELOLAAN PEMINJAMAN
                RUANGAN</a>
            <table id="tabelPeminjaman" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Peminjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Peminjam</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
        $(document).ready(function() {
            $('#tabelPeminjaman').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.pengelolaan-peminjaman.view') }}",
                columns: [{
                        data: 'tanggal_peminjaman',
                        name: 'tanggal_peminjaman'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'nama_ruang',
                        name: 'nama_ruang',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'peminjam',
                        name: 'peminjam'
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
