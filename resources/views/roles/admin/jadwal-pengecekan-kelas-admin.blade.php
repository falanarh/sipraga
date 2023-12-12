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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">JADWAL PENGECEKAN KELAS</p>
            <table id="tabelPengecekanAdmin" class="table table-striped responsive" style="width: 100%">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tanggal</th>
                        <th>Ruang</th>
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
            $('#tabelPengecekanAdmin').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.jadwal-pengecekan-kelas.view') }}",
                columns: [
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'nama_ruang',
                        name: 'nama_ruang'
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
