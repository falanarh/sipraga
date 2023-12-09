{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

@section('additional-css')
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 300,
                'GRAD' 0,
                'opsz' 24
        }
    </style>
@endsection

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
                <p class="table-title text-dark mb-4">IMPOR DATA</p>
                <form action="{{ route('admin.impor-sarpras') }}" method="POST" enctype="multipart/form-data">
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
                <p class="table-title text-dark mb-4">DATA SARANA DAN PRASARANA KELAS</p>
                <div>
                    <a href="/admin/data-master/tambah-sarpras" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <div class="list-filter d-flex gap-2">
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterJenis">Jenis Barang:</label>
                    <select id="filterJenis" name="filter_barang" class="form-select filter-dropdown">
                        <option value="">Pilih Jenis Barang</option>
                        @foreach ($jenisBarangOptions as $option)
                            <option value="{{ $option->kode_barang }}">{{ $option->nama }}</option>
                        @endforeach
                    </select>
                </div>
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
                    <label class="mb-1 fw-bold" for="filterTahun">Tahun:</label>
                    <select id="filterTahun" name="filter_tahun" class="form-select filter-dropdown">
                        <option value="">Pilih Tahun</option>
                        <!-- JavaScript will populate options here -->
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterBulan">Bulan:</label>
                    <select id="filterBulan" name="filter_bulan" class="form-select filter-dropdown">
                        <option value="">Pilih Bulan</option>
                        <!-- JavaScript will populate options here -->
                    </select>
                </div>
                
                <!-- Button trigger modal -->
                <div class="ms-auto my-auto">
                    <button type="button" class="btn btn-dark d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        <span class="material-symbols-outlined me-1">
                            print
                        </span>
                        Cetak DBR
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <form action="{{ route('admin.data-master.dbr') }}" class="modal-dialog" method="GET">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">CETAK DAFTAR BARANG DAN RUANGAN</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-0">
                                @csrf
                                <div class="mb-4 ">
                                    <label class="mb-1 fw-bold" for="filterRuang">Ruang:</label>
                                    <select id="filterRuang" name="filter_ruang" class="form-select filter-dropdown">
                                        <option value="">Pilih Ruang</option>
                                        @foreach ($ruangOptions as $option)
                                            <option value="{{ $option->kode_ruang }}">{{ $option->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ekspor</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <table id="tabelSarpras" class="table table-striped responsive" style="width: 100%;">
            <thead class="text-dark" style="border: 1px solid #000;">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>NUP</th>
                    <th>Jenis Sarpras</th>
                    <th>Ruang</th>
                    <th style="width: 12%;">Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>NUP</th>
                    <th>Jenis Sarpras</th>
                    <th>Ruang</th>
                    <th style="width: 12%;">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DAFTAR JENIS BARANG</p>
                <div>
                    <a href="{{ route('admin.tambah-jenis') }}"
                        class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah
                    </a>
                </div>
            </div>
            <table id="tabelJenis" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th class="col-2">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th class="col-2">Aksi</th>
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

        // $(document).ready(function() {
        //     $('#tabelSarpras').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('admin.data-master.sarpras') }}",
        //         columns: [{
        //                 data: 'nomor',
        //                 name: 'nomor'
        //             },
        //             {
        //                 data: 'tanggal_masuk',
        //                 name: 'tanggal_masuk'
        //             },
        //             {
        //                 data: 'kode_barang',
        //                 name: 'kode_barang'
        //             },
        //             {
        //                 data: 'nup',
        //                 name: 'nup'
        //             },
        //             {
        //                 data: 'jenis_barang',
        //                 name: 'jenis_barang'
        //             },
        //             {
        //                 data: 'nama_ruang',
        //                 name: 'nama_ruang'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ]
        //     });
        // });

        var dataTableSarpras;

        $(document).ready(function() {
            dataTableSarpras = $('#tabelSarpras').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.data-master.sarpras') }}",
                    data: function(d) {
                        d.filter_barang = $('#filterJenis').val(); // Ambil nilai dropdown filter
                        d.filter_ruang = $('#filterRuang').val(); // Ambil nilai dropdown filter
                        d.filter_tahun = $('#filterTahun').val(); // Ambil nilai dropdown filter
                        d.filter_bulan = $('#filterBulan').val(); // Ambil nilai dropdown filter
                    }
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
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
                        data: 'jenis_barang',
                        name: 'jenis_barang'
                    },
                    {
                        data: 'nama_ruang',
                        name: 'nama_ruang'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Event listener untuk dropdown filter
            $('.filter-dropdown').change(function() {
                dataTableSarpras.ajax.reload(); // Menggambar ulang tabel untuk menerapkan filter
            });

        });

        $(document).ready(function() {
            $('#tabelJenis').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data-master.jenis') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'rounded_color_name',
                        name: 'rounded_color_name'
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

        $(function() {
            $(document).on('click', '#hapus-aset', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin untuk menghapus data aset?',
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

        // Mendapatkan elemen dropdown tahun
        var filterTahunDropdown = document.getElementById('filterTahun');

        // Mendapatkan tahun saat ini
        var currentYear = new Date().getFullYear();

        // Menambahkan opsi 10 tahun ke depan dan ke belakang
        for (var i = currentYear - 20; i <= currentYear; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            filterTahunDropdown.add(option);
        }

        // Mendapatkan elemen dropdown bulan
        var filterBulanDropdown = document.getElementById('filterBulan');

        // Daftar nama bulan dalam bahasa Indonesia
        var namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Menambahkan opsi bulan
        for (var i = 0; i < namaBulan.length; i++) {
            var option = document.createElement('option');
            option.value = i + 1; // Menggunakan indeks bulan (mulai dari 1)
            option.text = namaBulan[i];
            filterBulanDropdown.add(option);
        }

        $(function() {
            $(document).on('click', '#hapus-jenis', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin menghapus data jenis barang?',
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
    </script>
@endsection
