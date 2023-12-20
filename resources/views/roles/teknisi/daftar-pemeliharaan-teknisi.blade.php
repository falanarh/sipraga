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
        <!-- Modal -->
        {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <form action="{{ route('teknisi.daftar-pemeliharaan.ekspor') }}" class="modal-dialog" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">CETAK LAPORAN PEMELIHARAAN AC</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        @csrf
                        <div class="mb-4">
                            <label class="mb-1 fw-bold" for="filterTanggalSelesai">Tanggal Selesai:</label>
                            <input type="date" id="filterTanggalSelesai" name="filter_tanggal_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ekspor</button>
                    </div>
                </div>
            </form>
        </div> --}}
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">LAPORAN PEMELIHARAAN DAN PERBAIKAN AC</p>
                <!-- Button trigger modal -->
                {{-- <button type="button" class="btn btn-dark d-flex align-items-center float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <span class="material-symbols-outlined me-1">
                        print
                    </span>
                    Cetak
                </button> --}}
                {{-- <button type="button" class="btn btn-dark d-flex align-items-center float-end" onclick="cetakLaporan()">
                    <span class="material-symbols-outlined me-1">
                        print
                    </span>
                    Cetak
                </button> --}}
                <form action="{{ route('teknisi.daftar-pemeliharaan.ekspor') }}" method="GET" id="cetakForm">
                    @csrf
                    {{-- <div class="mb-4">
                        <label class="mb-1 fw-bold" for="filterTanggalSelesai">Tanggal Selesai:</label>
                        <input type="date" id="filterTanggalSelesai" name="filter_tanggal_selesai" class="form-control" required>
                    </div> --}}
                    <button type="submit" class="btn btn-dark d-flex align-items-center float-end">
                        <span class="material-symbols-outlined me-1">print</span>
                        Cetak
                    </button>
                </form>
            </div>
            {{-- filter --}}
            <div class="list-filter d-flex gap-2">
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterTanggal">Tanggal Selesai:</label>
                    <select id="filterTanggal" name="filter_tanggal" class="form-select filter-dropdown">
                        <option value="">Pilih Tanggal Selesai:</option>
                        @foreach ($pemeliharaanOptions->unique('tanggal_selesai') as $option)
                            <option value="{{ $option->tanggal_selesai->format('d/m/Y') }}">{{ $option->tanggal_selesai->format('d/m/Y') }}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterKodeBarang">Kode Barang:</label>
                    <select id="filterKodeBarang" name="filter_kode_barang" class="form-select filter-dropdown">
                        <option value="">Pilih Kode Barang:</option>
                        @foreach ($pemeliharaanOptions->unique('jadwalPemeliharaanAc.kode_barang') as $option)
                            <option value="{{ $option->jadwalPemeliharaanAc->kode_barang }}">{{ $option->jadwalPemeliharaanAc->kode_barang }}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterNup">NUP:</label>
                    <select id="filterNup" name="filter_nup" class="form-select filter-dropdown">
                        <option value="">Pilih NUP</option>
                        @foreach ($pemeliharaanOptions->unique('jadwalPemeliharaanAc.nup') as $option)
                            <option value="{{ $option->jadwalPemeliharaanAc->nup }}">{{ $option->jadwalPemeliharaanAc->nup }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterRuang">Ruang:</label>
                    <select id="filterRuang" name="filter_ruang" class="form-select filter-dropdown">
                        <option value="">Pilih Ruang</option>
                        @foreach ($pemeliharaanOptions->unique('jadwalPemeliharaanAc.ruang.nama') as $option)
                            <option value="{{ $option->jadwalPemeliharaanAc->ruang->nama }}">{{ $option->jadwalPemeliharaanAc->ruang->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="tabelpemeliharaan" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    <tr>
                        <td>1</td>
                        <td>23/09/2023</td>
                        <td>11001</td>
                        <td>333</td>
                        <td>Falana Rofako</td>
                        <td>AC sudah normal</td>
                        <td>
                            <a href="/teknisi/daftar-pemeliharaan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>20/09/2023</td>
                        <td>11004</td>
                        <td>334</td>
                        <td>Falana Rofako</td>
                        <td>AC sudah normal</td>
                        <td>
                            <a href="/teknisi/daftar-pemeliharaan/detail" class="btn btn-dark">Detail</a>
                        </td>
                    </tr>
                </tbody> --}}
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('additional-js')
    <script>
        
        var dataPemeliharaan;

        $(document).ready(function() {
            dataPemeliharaan = $('#tabelpemeliharaan').DataTable({
                responsive: {
            
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('teknisi.daftar-pemeliharaan.view') }}",
                    data: function(d) {
                        d.filter_tanggal = $('#filterTanggal').val(); // Ambil nilai dropdown filter
                        d.filter_kode_ruang = $('#filterKodeRuang').val(); // Ambil nilai dropdown filter
                        d.filter_nup = $('#filterNup').val(); // Ambil nilai dropdown filter
                        d.filter_ruang = $('#filterRuang').val(); // Ambil nilai dropdown filter
                    }
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        orderable: true
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: true
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang',
                        orderable: true
                    },
                    {
                        data: 'nup',
                        name: 'nup',
                        orderable: true
                    },
                    {
                        data: 'ruang',
                        name: 'ruang',
                        orderable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

            // Event listener untuk dropdown filter
            $('.filter-dropdown').change(function() {
                dataPemeliharaan.ajax.reload(); // Menggambar ulang tabel untuk menerapkan filter
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cetakForm').addEventListener('submit', function() {
                // Menggunakan window.print() untuk mencetak
                window.print();
            });
        });
    </script> --}}
@endsection