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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PERBAIKAN SARANA DAN PRASARANA KELAS</p>
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
            </div>
            <table id="example" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal Selesai</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Jenis Barang</th>
                        <th>Ruang</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>        
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

        var tabelPerbaikan

        $(document).ready(function() {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#example')) {
            // Destroy the DataTable if it already exists
            $('#example').DataTable().destroy();
        }

        // Initialize the DataTable
        tabelPerbaikan = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('teknisi.daftar-perbaikan.view') }}",
                    data: function(d) {
                        d.filter_ruang = $('#filterRuang').val(); // Ambil nilai dropdown filter
                    }
                },
            // ajax: "{{ route('teknisi.daftar-perbaikan.view') }}",
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
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
        // Event listener untuk dropdown filter
        $('.filter-dropdown').change(function() {
            tabelPerbaikan.ajax.reload(); // Menggambar ulang tabel untuk menerapkan filter
        });
    });
    </script>
@endsection