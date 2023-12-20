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
            <p class="table-title text-dark" style="font-size:18px; font-weight: 600;">
                DAFTAR PENGADUAN SARANA DAN PRASARANA KELAS
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="arrow-right" width="33px" height="25px">
                {{ $pengaduans->tiket }}
            </p>
            <form action="{{ route('koordinator.update-pengaduan', ['tiket' => $pengaduans->tiket]) }}" method="POST">
                @method('PUT')
                @csrf            
                <table class="table table-striped mt-5" style="width: 100%;">
                    <tr>
                        <th class="fw-bolder">Tiket</th>
                        <td>{{ $pengaduans->tiket }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Tanggal</th>
                        <td>{{ $pengaduans->tanggal->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Jenis Barang</th>
                        <td>{{ $pengaduans->jenis_barang }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Ruang</th>
                        <td>{{ $pengaduans->nama_ruang }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Prioritas</th>
                        <td>{{ $pengaduans->prioritas }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Deskripsi</th>
                        <td>{{ $pengaduans->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Teknisi</th>
                        <td>
                            <select name="teknisi_id" class="form-select border-0 px-0" required>
                                <option value="">Pilih Nama Teknisi</option>
                                @foreach ($teknisis as $teknisi)
                                    <option value="{{ $teknisi->user_id }}" @if ($pengaduans->teknisi_id == $teknisi->user_id) selected @endif>{{ $teknisi->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="fw-bolder">Lampiran</th>
                        <td>
                            <img class="img-fluid" src="{{ asset('storage/' . $pengaduans->lampiran) }}" alt="lampiran" width="300px" height="300px">
                        </td>
                    </tr>
                </table>

                {{-- Flex container for buttons --}}
                <div class="d-flex mt-4">
                    <button type="submit" class="btn btn-primary">
                        Terima
                    </button>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#modal-tolak">
                        Tolak
                    </button>
                </div>
            </form>

            {{-- <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#modal-tolak">
                Tolak
            </button> --}}

            {{-- Modal for Terima --}}
            {{-- <div class="modal fade" id="modal-terima" tabindex="-1" aria-labelledby="modal-terimaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-terimaLabel">Konfirmasi Terima Pengaduan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda ingin menyetujui pengaduan ini?</p> --}}
                            {{-- Hidden field to capture the selected technician's ID --}}
                            {{-- <input type="hidden" id="selectedTechnicianId" name="teknisi_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="submitUpdateForm()">Yes</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <form action="{{ route('koordinator.tolak-pengaduan', ['tiket' => $pengaduans->tiket]) }}" method="post">
                @csrf
                @method('POST')
                <!-- Modal -->
                <div class="modal fade" id="modal-tolak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="modal-tolakLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bolder text-uppercase" id="modal-tolakLabel">Tolak Pengaduan Sarpras</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tanggapan" class="form-label">Alasan</label>
                                    <textarea class="form-control" name="alasan_ditolak" id="tanggapan" rows="5"></textarea>
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

{{-- @section('additional.js')
    <script>
        // JavaScript to update the hidden field value when the dropdown changes
        document.addEventListener('DOMContentLoaded', function () {
            var selectTechnician = document.querySelector('select[name="teknisi_id"]');
            var hiddenTechnicianId = document.getElementById('selectedTechnicianId');

            // Event listener for dropdown change
            selectTechnician.addEventListener('change', function () {
                hiddenTechnicianId.value = this.value; // Update the hidden field value
            });
        });

        // JavaScript function to submit the form when "Yes" is clicked
        function submitUpdateForm() {
            document.querySelector('form#updateForm').submit();
        }
    </script>
@endsection --}}