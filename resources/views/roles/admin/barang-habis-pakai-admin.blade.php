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

@section('additional-css')
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 300,
                'GRAD' 0,
                'opsz' 24
        }

        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row-card d-flex justify-content-between">
                <p class="table-title text-dark mb-4">DAFTAR KETERSEDIAAN BARANG HABIS PAKAI</p>
                <div>
                    <a href="{{ route('admin.bhp.tambah-jenis-form') }}"
                        class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah Barang
                    </a>
                </div>
                <div>
                    <a href="{{ route('admin.bhp.tambah-form') }}" class="btn btn-dark text-white d-flex align-items-center">
                        <img src="{{ asset('images/icons/plus.svg') }}" alt="" class="mr-2 add-icon img-fluid">
                        Tambah Stok
                    </a>
                </div>
            </div>

            <table id="tableBarangHabisPakai" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis Barang</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis Barang</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="row-card d-flex justify-content-between">
            <div class="card-body">
                <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR PENGAMBILAN BARANG HABIS
                    PAKAI</p>
                <div class="list-filter d-flex gap-2">

                    {{-- barang --}}

                    <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterTahunAmbil"></label>
                    <select data-column="1" id="filterTahunAmbil" name="filterTahunAmbil" class="form-select filter-select">
                        <option value="">Semua Tahun</option>
                    </select>
                </div>

                    <div class="mb-4">
                        <label class="mb-1 fw-bold" for="filter_Ambilbarang"></label>
                        <select data-column="2" id="filter_Ambilbarang" name="filter_Ambilbarang"
                            class="form-select filter-select">
                            <option value="">Pilih Jenis Barang</option>
                            @foreach ($ambil_bhps as $jenis_barang_ambils)
                                <option value="{{ $jenis_barang_ambils->jenis_barang }}">{{ $jenis_barang_ambils->jenis_barang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- user --}}

                    <div class="mb-4">
                        <label class="mb-1 fw-bold" for="filter_pengambil"></label>
                        {{-- <input type="text" name="filter_pengambil" class="form-control filter-input" placeholder="Cari nama ..." data-column="5"> --}}
                        <select data-column="5" id="filter_pengambil" name="filter_pengambil"
                            class="form-select filter-select">
                            <option value="">Pilih Pengambil</option>
                            <!-- JavaScript will populate options here -->
                            @foreach ($users as $user)
                                <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ruang --}}

                    <div class="mb-4">
                        <label class="mb-1 fw-bold" for="filter_ruang_pengambil"></label>
                        <select data-column="3" id="filter_ruang_pengambil" name="filter_ruang_pengambil"
                            class="form-select filter-select">
                            <option value="">Pilih Ruang</option>
                            @foreach ($ruangOptions as $option)
                                <option value="{{ $option->nama }}">{{ $option->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button trigger modal -->
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn btn-dark d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <span class="material-symbols-outlined me-1">
                                print
                            </span>
                            Cetak
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <form action="{{ route('admin.bhp.print-pengambilan-bhp') }}" class="modal-dialog" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">CETAK PENGAMBILAN BHP</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-0">
                                    @csrf
                                    <div class="mb-4 ">
                                        <label class="mb-1 fw-bold" for="pengambil">Pengambil</label>
                                        <select id="pengambil" name="pengambil" class="form-select filter-dropdown">
                                            <option value="">Pilih Pengambil</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                        @error('pengambil')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4 ">
                                        <label class="mb-1 fw-bold" for="tanggal">Tanggal:</label>
                                        <input type="date" class="form-control" name="tanggal">
                                        @error('tanggal')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Ekspor</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <table id="tableAmbilBHP" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis Barang</th>
                        <th>Ruang</th>
                        <th>Jumlah</th>
                        <th>Nama Pengambil</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>

                    </tr>
                <tfoot>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Jenis Barang</th>
                        <th>Ruang</th>
                        <th>Jumlah</th>
                        <th>Nama Pengambil</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">DAFTAR TRANSAKSI BARANG HABIS PAKAI
            </p>

            <div class="list-filter d-flex gap-2">
                 <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterTahun"></label>
                    <select data-column="1" id="filterTahun" name="filterTahun" class="form-select filter-select">
                        <option value="">Semua Tahun</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterJenisTransaksi"></label>
                    <select data-column="2" id="filterJenisTransaksi"  name="filterJenisTransaksi" class="form-select filter-select">
                        <option value="">Pilih Jenis Transaksi</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                        <!-- JavaScript will populate options here -->
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filter_barang_transaksi"></label>
                    <select data-column="3" id="filter_barang_transaksi" name="filter_barang_transaksi"
                        class="form-select filter-select">
                        <option value="">Pilih Jenis Barang</option>
                        @foreach ($bhps as $jenis_barangs)
                            <option value="{{ $jenis_barangs->jenis_barang }}">{{ $jenis_barangs->jenis_barang }}
                            </option>
                        @endforeach

                    </select>
                </div>
               
                {{-- <div class="mb-4">
                    <label class="mb-1 fw-bold" for="filterBulan"></label>
                    <select data-column="1" id="filterBulan" name="filterBulan" class="form-select filter-select">
                        <option value="">Semua Bulan</option>
                    </select>
                </div> --}}

            </div>

            <table id="tableTransaksiBHP" class="table table-striped responsive" style="width: 100%;">
                <thead class="text-dark" style="border: 1px solid #000;">

                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th>Jenis Barang</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>

                    </tr>
                <tfoot>

                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th>Jenis Barang</th>
                        <th>Jumlah</th>
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
            $('#tableBarangHabisPakai').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bhp.view.dataBHP') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'jenis_barang',
                        name: 'jenis_barang'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'

                    },
                    {
                        data: 'satuan',
                        name: 'satuan',
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

        var dataTableAmbilBHP;


        $(document).ready(function() {
            dataTableAmbilBHP = $('#tableAmbilBHP').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.bhp.view.dataAmbilBHP') }}"
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: false,
                        searchable: 'true'
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
                        data: 'jumlah_ambilBHP',
                        name: 'jumlah_ambilBHP'
                    },
                    {
                        data: 'nama_pengambil',
                        name: 'nama_pengambil'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#filterTahunAmbil').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableAmbilBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });


            $('#filter_Ambilbarang').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableAmbilBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });

            $('#filter_pengambil').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableAmbilBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });

            $('#filter_ruang_pengambil').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableAmbilBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });


        });

         // Mendapatkan elemen dropdown tahun
        var filterTahunDropdownAmbil = document.getElementById('filterTahunAmbil');

        // Mendapatkan tahun saat ini
        var currentYear = new Date().getFullYear();

        // Menambahkan opsi 10 tahun ke depan dan ke belakang
        for (var i = currentYear - 20; i <= currentYear; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = i;
            filterTahunDropdownAmbil.add(option);
        }

        // // Mendapatkan elemen dropdown bulan
        // var filterBulanDropdown = document.getElementById('filterBulanAmbil');

        // // Daftar nama bulan dalam bahasa Indonesia
        // var namaBulan = [
        //     'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        //     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        // ];

        // // Menambahkan opsi bulan
        // for (var i = 0; i < namaBulan.length; i++) {
        //     var option = document.createElement('option');
        //     option.value = i + 1; // Menggunakan indeks bulan (mulai dari 1)
        //     option.text = namaBulan[i];
        //     filterBulanDropdown.add(option);
        // }

       

        $(document).ready(function() {

            var dataTableTransaksiBHP;
            // Inisialisasi DataTable
            dataTableTransaksiBHP = $('#tableTransaksiBHP').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.bhp.view.dataTransaksiBHP') }}",
                columns: [{
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: false,
                    },
                    {
                        data: 'jenis_transaksi',
                        name: 'jenis_transaksi'
                    },
                    {
                        data: 'jenis_barang',
                        name: 'jenis_barang'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            
            $('#filter_barang_transaksi').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableTransaksiBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });
            
            $('#filterJenisTransaksi').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableTransaksiBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });
            
            $('#filterTahun').change(function() {
                var columnIdx = $(this).data('column');
                var selectedValue = $(this).val();

                dataTableTransaksiBHP.column(columnIdx)
                    .search(selectedValue)
                    .draw();
            });




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



        $(function() {
            $(document).on('click', '#hapus-pengambilan-bhp', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin menghapus data pengambilan barang habis pakai ini?',
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

        $(function() {
            $(document).on('click', '#hapus-transaksi-bhp', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin menghapus data transaksi barang habis pakai ini?',
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
