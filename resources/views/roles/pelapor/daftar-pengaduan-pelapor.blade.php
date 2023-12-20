This is the original text
{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk pelapor --}}
@section('sidebar')
    @include('partials.sidebar-pelapor')
@endsection

{{-- Menambahkan header untuk pelapor --}}
@section('header')
    @include('partials.header')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGADUAN SARANA DAN PRASARANA
                KELAS</p>
            {{-- filter --}}
            <div class="list-filter d-flex gap-2">
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterRuang">Ruang:</label>
                    <select id="filterRuang" name="filter_ruang" class="form-select filter-dropdown">
                        <option value="">Pilih Ruang</option>
                            @foreach ($ruangOption as $option)
                                <option value="{{ $option->kode_ruang }}">{{ $option->nama }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterStatus">Status:</label>
                    <select id="filterStatus" name="filter_status" class="form-select filter-dropdown">
                        <option value="">Pilih Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Dikerjakan">Dikerjakan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterPrioritas">Prioritas:</label>
                    <select id="filterPrioritas" name="filter_prioritas" class="form-select filter-dropdown">
                        <option value="">Pilih Prioritas</option>
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Tinggi">Tinggi</option>
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
                        <th>Aksi</th>
                    </tr>
                </thead>        
            </table>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
        var tabelPengaduan
        $(document).ready(function() {
            // Check if DataTable is already initialized
            if ($.fn.DataTable.isDataTable('#example')) {
                // Destroy the DataTable if it already exists
                $('#example').DataTable().destroy();
            }
            // Initialize the DataTable
            tabelPengaduan = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: "{{ route('pelapor.daftar-pengaduan.view') }}",
                        data: function(d) {
                            d.filter_ruang = $('#filterRuang').val(); // Ambil nilai dropdown filter
                            d.filter_status = $('#filterStatus').val(); // Ambil nilai dropdown filter
                            d.filter_prioritas = $('#filterPrioritas').val(); // Ambil nilai dropdown filter
                        }
                    },
                // ajax: "{{ route('pelapor.daftar-pengaduan.view') }}",
                columns: [
                    { data: 'tiket', name: 'tiket' },
                    {   data: 'tanggal', 
                        name: 'tanggal', 
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('en-GB') : ''; // Adjust the locale based on your preference
                        }
                    },
                    { data: 'jenis_barang', name: 'jenis_barang' },
                    { data: 'nama_ruang', name: 'nama_ruang' },
                    { data: 'prioritas', name: 'prioritas' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
            // Event listener untuk dropdown filter
            $('.filter-dropdown').change(function() {
                tabelPengaduan.ajax.reload(); // Menggambar ulang tabel untuk menerapkan filter
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