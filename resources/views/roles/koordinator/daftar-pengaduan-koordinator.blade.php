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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS</p>
            {{-- filter --}}
            <div class="list-filter d-flex gap-2">
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterRuang">Ruang:</label>
                    <select id="filterRuang" name="filter_ruang" class="form-select filter-dropdown">
                        <option value="">Pilih Ruang</option>
                        @foreach ($ruangOptions as $option)
                            <option value="{{ $option->kode_ruang }}">{{ $option->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterStatus">Status:</label>
                    <select id="filterStatus" name="filter_status" class="form-select filter-dropdown">
                        <option value="">Pilih Status</option>
                        @foreach ($statusOptions as $option)
                            <option value="{{ $option->status }}">{{ $option->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterTeknisi">Teknisi:</label>
                    <select id="filterTeknisi" name="filter_teknisi" class="form-select filter-dropdown">
                        <option value="">Pilih Prioritas</option>
                        @foreach ($prioritasOptions as $option)
                            <option value="{{ $option->prioritas }}">{{ $option->prioritas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Tiket</th>
                        <th>Tanggal</th>
                        <th>Jenis Barang</th>
                        <th>Ruang</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

{{-- ... Your existing Blade content ... --}}

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
                ajax: "{{ route('koordinator.daftar-pengaduan.view') }}",
                columns: [
                    { data: 'tiket', name: 'tiket' },
                    {   data: 'tanggal',
                        name: 'tanggal',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('en-GB') : ''; // Adjust the locale based on your preference
                        }
                    },
                    { data: 'jenis_barang', name: 'jenis_barang' },
                    { data: 'kode_ruang', name: 'kode_ruang' },
                    { data: 'prioritas', name: 'prioritas' },
                    { data: 'status', name: 'status' },
                    { data: 'teknisi_name', name: 'teknisi_name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            
        });
    </script>
@endsection

@section('additional-css')
    <style>
        .bg-rounded-prior, .bg-rounded-status {
            padding: 2px 10px;
            color: #fff;
            text-align: center;
            display: inline-block;
        }
    </style>
@endsection

@section('additional-js')
<script>
    // Set background color based on content for Prioritas
    let elements = document.querySelectorAll(".bg-rounded-prior");
            elements.forEach((element) => {
                if (element.textContent === "Sedang") {
                    element.style.backgroundColor = "#FF9800";
                } else if (element.textContent === "Rendah") {
                    element.style.backgroundColor = "#C3C562";
                } else if (element.textContent === "Tinggi") {
                    element.style.backgroundColor = "#900C3F";
                }
            });

            // Set background color based on content for Status
            let elements2 = document.querySelectorAll(".bg-rounded-status");
            elements2.forEach((element) => {
                if (element.textContent === "Menunggu") {
                    element.style.backgroundColor = "#F8DE22";
                } else if (element.textContent === "Dikerjakan") {
                    element.style.backgroundColor = "#539BFF";
                } else if (element.textContent === "Selesai") {
                    element.style.backgroundColor = "#13DEB9";
                } else if (element.textContent === "Ditolak") {
                    element.style.backgroundColor = "#F6412D";
                }
            });
    </script>
@endsection
{{-- ... Your existing Blade content ... --}}

