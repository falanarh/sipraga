@extends('layouts.dashboard')

@section('additional-css')
    <style>
        .profile-table tr:nth-child(odd) td {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .profile-table tr:nth-child(odd) th {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .profile-table> :not(caption)>*>* {
            border-bottom-width: 0px;
        }

        .profile-table th {
            width: 40%;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload {
            width: 100%;
        }
    </style>
@endsection

@section('sidebar')
    @if ($role == 'pelapor')
        @include('partials.sidebar-pelapor')
    @elseif ($role == 'admin')
        @include('partials.sidebar-admin')
    @elseif ($role == 'pemakaibhp')
        @include('partials.sidebar-pemakaibhp')
    @elseif ($role == 'teknisi')
        @include('partials.sidebar-teknisi')
    @elseif ($role == 'koordinator')
        @include('partials.sidebar-koordinator')
    @endif
@endsection

<div id="topOfPage"></div>

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#profil">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#edit-profil">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                            <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                        </svg>
                        Edit Profil
                    </a>
                </li>
            </ul>

            @php
                $profile = $user->picture_link ?? 'images/icons/default-profile.png';
            @endphp

            @if ($posisi == 'Mahasiswa')
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="profil" class="container tab-pane active">
                        <div class="row justify-content-center">
                            <div class="foto-profil card mt-5 col-md-4 col-lg-3">
                                <div class="card-body" style="height: 250px; width: 250px; overflow: hidden;">
                                    <img src="{{ asset($profile) }}" style="width: 100%; height: 100%; border-radius: 50%; border: 5px solid #e5e5e8;" alt="Profile Image">
                                </div>
                            </div>
                            <div class="deskripsi-profil col-md-8 col-lg-9">
                                <table class="table table-striped profile-table mt-5">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Posisi</th>
                                        <td>{{ $posisi }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIM</th>
                                        <td>
                                            @isset($mahasiswa->nim)
                                                {{ $mahasiswa->nim }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>
                                            @isset($mahasiswa->kelas)
                                                {{ $mahasiswa->kelas }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>
                                            @isset($mahasiswa->tempat_lahir)
                                                {{ $mahasiswa->tempat_lahir }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>
                                            @isset($mahasiswa->tgl_lahir)
                                                {{ $mahasiswa->tgl_lahir->format('d/m/Y') }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td>
                                            @isset($mahasiswa->no_telp)
                                                {{ $mahasiswa->no_telp }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            @isset($mahasiswa->alamat)
                                                {{ $mahasiswa->alamat }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="edit-profil" class="container tab-pane fade show"><br>
                        <form class="row" method="POST"
                            action="{{ route('edit-profil-mahasiswa', ['user_id' => $user->user_id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3 col-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $user->name }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control" id="nim"
                                    value="{{ $mahasiswa->nim }}" disabled readonly>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select name="kelas" id="kelas" class="form-select">
                                    <option value="">Pilih Kelas</option>
                                    @foreach (['3SI1', '3SI2', '3SI3', '3SD1', '3SD2', '3SD3', '3SE1', '3SE2', '3SE3', '3SK1', '3SK2', '3SK3'] as $option)
                                        <option value="{{ $option }}"
                                            {{ $mahasiswa->kelas == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                    value="{{ $mahasiswa->tempat_lahir }}">
                                @error('tempat_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir"
                                    value="{{ optional($mahasiswa->tgl_lahir)->format('Y-m-d') }}">
                                @error('tgl_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" class="form-control" id="no_telp"
                                    value="{{ $mahasiswa->no_telp }}">
                                @error('no_telp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="5">{{ $mahasiswa->alamat ?? '' }}</textarea>
                                @error('alamat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Upload Foto Profil</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse<input type="file" name="profile_picture" id="imgInp">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload' />
                                </div>
                                @error('profile_picture')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Tambahkan elemen input tersembunyi untuk menyimpan nilai dari variabel JavaScript -->
                            <input type="hidden" id="roleValue" name="role" value="">
                            {{-- <input type="hidden" name="posisi" value="{{ $posisi }}"> --}}

                            <div>
                                <button type="submit" class="btn btn-dark mt-3">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if ($posisi == 'Dosen')
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="profil" class="container tab-pane active"><br>
                        <div class="wrap d-flex flex-wrap">
                            <div class="foto-profil card mt-5" style="height: fit-content;">
                                <div class="card-body">
                                    <img src="{{ asset($profile) }}" width="250px" height="250px" alt=""
                                        style="border-radius: 100%; border: 5px solid #e5e5e8;">
                                </div>
                            </div>
                            <div class="deskripsi-profil col-8 d-flex">
                                <table class="table table-striped profile-table m-5">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Posisi</th>
                                        <td>{{ $posisi }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIP</th>
                                        <td>
                                            @isset($dosen->nip)
                                                {{ $dosen->nip }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Program Studi</th>
                                        <td>
                                            @isset($dosen->program_studi)
                                                {{ $dosen->program_studi }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>
                                            @isset($dosen->tempat_lahir)
                                                {{ $dosen->tempat_lahir }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>
                                            @isset($dosen->tgl_lahir)
                                                {{ $dosen->tgl_lahir->format('d/m/Y') }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td>
                                            @isset($dosen->no_telp)
                                                {{ $dosen->no_telp }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            @isset($dosen->alamat)
                                                {{ $dosen->alamat }}
                                            @else
                                                -
                                            @endisset
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div id="edit-profil" class="container tab-pane fade show"><br>
                        <form class="row" method="POST"
                            action="{{ route('edit-profil-dosen', ['user_id' => $user->user_id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3 col-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $user->name }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" id="nip"
                                    value="{{ optional($dosen)->nip }}">
                                @error('nip')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label for="program_studi" class="form-label">Program Studi</label>
                                <select name="program_studi" id="program_studi" class="form-select">
                                    <option value="">Pilih Program Studi</option>
                                    <option value="Komputasi Statistik"
                                        {{ optional($dosen)->program_studi == 'Komputasi Statistik' ? 'selected' : '' }}>
                                        Komputasi Statistik</option>
                                    <option value="Statistika"
                                        {{ optional($dosen)->program_studi == 'Statistika' ? 'selected' : '' }}>Statistika
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3 col-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                    value="{{ optional($dosen)->tempat_lahir }}">
                                @error('tempat_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir"
                                    value="{{ optional(optional($dosen)->tgl_lahir)->format('Y-m-d') }}">
                                @error('tgl_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}" disabled readonly>
                            </div>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" class="form-control" id="no_telp"
                                    value="{{ optional($dosen)->no_telp }}">
                                @error('no_telp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="5">{{ optional($dosen)->alamat }}</textarea>
                                @error('alamat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Upload Foto Profil</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse<input type="file" name="profile_picture" id="imgInp">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload' />
                                </div>
                                @error('profile_picture')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tambahkan elemen input tersembunyi untuk menyimpan nilai dari variabel JavaScript -->
                            <input type="hidden" id="roleValue" name="role" value="">
                            {{-- <input type="hidden" name="posisi" value="{{ $posisi }}"> --}}

                            <div>
                                <button type="submit" class="btn btn-dark mt-3">Edit</button>
                            </div>
                        </form>

                    </div>
                </div>
            @endif

            @if ($posisi == 'Staff')
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="profil" class="container tab-pane active"><br>
                        <div class="wrap d-flex flex-wrap">
                            <div class="foto-profil card mt-5" style="height: fit-content;">
                                <div class="card-body">
                                    <img src="{{ asset($profile) }}" width="250px" height="250px" alt=""
                                        style="border-radius: 100%; border: 5px solid #e5e5e8;">
                                </div>
                            </div>
                            <div class="deskripsi-profil col-8 d-flex">
                                <table class="table table-striped profile-table m-5">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Posisi</th>
                                        <td>{{ $posisi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIP</th>
                                        <td>{{ $staff->nip ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bagian</th>
                                        <td>{{ $staff->bagian ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $staff->tempat_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ $staff->tgl_lahir ? $staff->tgl_lahir->format('d/m/Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td>{{ $staff->no_telp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $staff->alamat ?? '-' }}</td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>

                    <div id="edit-profil" class="container tab-pane fade show"><br>
                        <form class="row" method="POST"
                            action="{{ route('edit-profil-staff', ['user_id' => $user->user_id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3 col-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $user->name }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" id="nip"
                                    value="{{ optional($staff)->nip }}">
                                @error('nip')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="bagian" class="form-label">Bagian</label>
                                <select name="bagian" id="bagian" class="form-select">
                                    <option value="">Pilih Bagian Unit Kerja</option>
                                    <option value="Keuangan"
                                        {{ optional($staff)->bagian == 'Keuangan' ? 'selected' : '' }}>
                                        Keuangan</option>
                                    <option value="Kepegawaian"
                                        {{ optional($staff)->bagian == 'Kepegawaian' ? 'selected' : '' }}>Kepegawaian
                                    </option>
                                    <option value="TURT"
                                        {{ optional($staff)->bagian == 'TURT' ? 'selected' : '' }}>TURT
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                    value="{{ optional($staff)->tempat_lahir }}">
                                @error('tempat_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir"
                                    value="{{ optional(optional($staff)->tgl_lahir)->format('Y-m-d') }}">
                                @error('tgl_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" class="form-control" id="no_telp"
                                    value="{{ optional($staff)->no_telp }}">
                                @error('no_telp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="5">{{ optional($staff)->alamat }}</textarea>
                                @error('alamat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Upload Foto Profil</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse<input type="file" name="profile_picture" id="imgInp">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload' />
                                </div>
                                @error('profile_picture')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Tambahkan elemen input tersembunyi untuk menyimpan nilai dari variabel JavaScript -->
                            <input type="hidden" id="roleValue" name="role" value="">

                            <div>
                                <button type="submit" class="btn btn-dark mt-3">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            var role = window.location.pathname.split('/')[1];

            // Setel nilai elemen input tersembunyi
            document.getElementById('roleValue').value = role;

            // Cek apakah terdapat pesan kesalahan, jika iya, tampilkan tab edit-profil
            @if ($errors->any())
                $('a[href="#edit-profil"]').tab('show');
            @endif

            // Menggeser fokus ke elemen dengan ID "topOfPage"
            document.getElementById('topOfPage').scrollIntoView({
                behavior: 'smooth'
            });
        });


        $(document).ready(function() {
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function() {
                readURL(this);
            });
        });
    </script>
@endsection
