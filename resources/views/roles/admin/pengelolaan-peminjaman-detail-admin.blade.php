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
            <div class="title d-flex mb-4">
                <a href="/admin/pengelolaan-peminjaman" class="table-title d-flex" style="font-weight: 700; color: #818181;">
                    DAFTAR PENGELOLAAN PEMINJAMAN
                </a>
                <img class="mx-2" src="{{ asset('images/icons/chevron-right.svg') }}" alt="">
                <a href="/admin/pengelolaan-peminjaman/detail" class="table-title d-flex text-dark" style="font-weight: 700">
                    {{ $peminjaman_ruangan->peminjaman_ruangan_id }}
                </a>
            </div>
            {{-- <a href="/admin/pengelolaan-peminjaman" class="table-title text-dark d-block mb-4">DAFTAR PENGELOLAAN PEMINJAMAN
                RUANGAN</a> --}}
            <table class="table table-striped responsive" style="width: 100%;">
                <tr>
                    <th>ID</th>
                    <td>{{ $peminjaman_ruangan->peminjaman_ruangan_id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Peminjaman</th>
                    @if ($peminjaman_ruangan->tgl_mulai == $peminjaman_ruangan->selesai)
                        <td>{{ $peminjaman_ruangan->tgl_mulai->format('d/m/Y') }}</td>
                    @else
                        <td>{{ $peminjaman_ruangan->tgl_mulai->format('d/m/Y') . '-' . $peminjaman_ruangan->tgl_selesai->format('d/m/Y') }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>{{ date('H:i', strtotime($peminjaman_ruangan->waktu_mulai)) . '-' . date('H:i', strtotime($peminjaman_ruangan->waktu_selesai)) }}
                    </td>
                </tr>
                <tr>
                    <th>Ruang</th>
                    <td>{{ $peminjaman_ruangan->ruang->nama }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $peminjaman_ruangan->status }}</td>
                </tr>
                <tr>
                    <th>Peminjam</th>
                    <td>{{ $peminjaman_ruangan->peminjam }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $peminjaman_ruangan->keterangan }}</td>
                </tr>
                <tr>
                    <th>Tanggapan</th>
                    @if ($peminjaman_ruangan->tanggapan == null)
                        <td>N/A</td>
                    @else
                        <td>{{ $peminjaman_ruangan->tanggapan }}</td>
                    @endif
                </tr>
            </table>
            {{-- <a href="#" id="terima-peminjaman" class="btn btn-primary">Edit</a> --}}

            <div class="button-group d-flex">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit">
                    Alihkan
                </button>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#modal-tolak">
                    Tolak
                </button>
            </div>

            <form action="{{ route('admin.pengelolaan-peminjaman.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <!-- Modal -->
                <div class="modal fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="modal-tolakLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bolder text-uppercase" id="modal-editLabel">Edit Peminjaman
                                    Ruangan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="kodeRuangBaru" class="form-label">Ruang</label>
                                    <select id="kodeRuangBaru" name="kodeRuangBaru" class="form-select filter-dropdown">
                                        @foreach ($ruangOptions as $option)
                                            <option value="{{ $option->kode_ruang }}"
                                                @if ($option->kode_ruang == $peminjaman_ruangan->kode_ruang) selected @endif>
                                                {{ $option->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggapan" class="form-label">Alasan</label>
                                    <textarea class="form-control" name="tanggapanBaru" id="tanggapan" rows="5">{{ $peminjaman_ruangan->tanggapan }}</textarea>
                                </div>

                                <!-- Input hidden untuk variabel-variabel -->
                                <input type="hidden" name="peminjaman_ruangan_id" value="{{ $peminjaman_ruangan->peminjaman_ruangan_id }}">
                                <input type="hidden" name="tgl_mulai" value="{{ $peminjaman_ruangan->tgl_mulai->format('Y-m-d') }}">
                                <input type="hidden" name="tgl_selesai" value="{{ $peminjaman_ruangan->tgl_selesai->format('Y-m-d') }}">
                                <input type="hidden" name="waktu_mulai" value="{{ $peminjaman_ruangan->waktu_mulai }}">
                                <input type="hidden" name="waktu_selesai" value="{{ $peminjaman_ruangan->waktu_selesai }}">
                                <input type="hidden" name="keterangan" value="{{ $peminjaman_ruangan->keterangan }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="">
                <!-- Modal -->
                <div class="modal fade" id="modal-tolak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="modal-tolakLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bolder text-uppercase" id="modal-tolakLabel">Tolak Pengaduan
                                    Peminjaman Ruangan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tanggapan" class="form-label">Alasan</label>
                                    <textarea class="form-control" name="tanggapanBaru" id="tanggapan" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    </script>
@endsection
