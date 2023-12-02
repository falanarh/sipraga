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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">LAPORAN PERBAIKAN SARANA DAN PRASARANA
                KELAS</p>
                <table id="example" class="table table-striped responsive" style="width: 100%;">
                    <thead class="text-dark" style="border: 1px solid #000;">
                        <tr>
                            <th>Tiket</th>
                            <th>Tanggal Selesai</th>
                            <th>Kode Barang</th>
                            <th>NUP</th>
                            <th>Jenis Barang</th>
                            <th>Ruang</th>
                            <th>Teknisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>        
                </table>
            </div>
        </div>
    @endsection
    
    @section('additional-js')
        <script>
            $(document).ready(function() {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#example')) {
            // Destroy the DataTable if it already exists
            $('#example').DataTable().destroy();
        }
    
        // Initialize the DataTable
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('koordinator.daftar-perbaikan.view') }}",
            columns: [
                { data: 'tiket', name: 'tiket' },
                {   data: 'tanggal_selesai', 
                    name: 'tanggal_selesai', 
                    render: function(data) {
                        return data ? new Date(data).toLocaleDateString('en-GB') : ''; // Adjust the locale based on your preference
                    }
                },
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nup', name: 'nup' },
                { data: 'jenis_barang', name: 'jenis_barang' },
                { data: 'kode_ruang', name: 'kode_ruang' },
                { data: 'teknisi_name', name: 'teknisi_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });
    
    
            // document.addEventListener('DOMContentLoaded', function() {
            //     let elements = document.querySelectorAll(".bg-rounded-prior");
            //     elements.forEach((element) => {
            //         if (element.textContent === "Sedang") {
            //             element.style.backgroundColor = "#FF9800";
            //         } else if (element.textContent === "Rendah") {
            //             element.style.backgroundColor = "#C3C562";
            //         } else if (element.textContent === "Tinggi") {
            //             element.style.backgroundColor = "#900C3F";
            //         }
            //     });
    
            //     let elements2 = document.querySelectorAll(".bg-rounded-status");
            //     elements2.forEach((element) => {
            //         if (element.textContent === "Menunggu") {
            //             element.style.backgroundColor = "#F8DE22";
            //         } else if (element.textContent === "Dikerjakan") {
            //             element.style.backgroundColor = "#539BFF";
            //         } else if (element.textContent === "Selesai") {
            //             element.style.backgroundColor = "#13DEB9";
            //         } else if (element.textContent === "Ditolak") {
            //             element.style.backgroundColor = "#F6412D";
            //         }
            //     });
            // });
        </script>
    @endsection