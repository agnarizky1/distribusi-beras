@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Data Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">
                            <i class="fa-solid fa-folder-plus"></i> Tambah Data
                            Toko</a>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif(session('hapus'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('hapus') }}
                                </div>
                            @endif
                            <table id="tabel-user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id Toko</th>
                                        <th class="text-center">Foto</th>
                                        <th>Nama Toko</th>
                                        <th>Rating</th>
                                        <th>Pemilik</th>
                                        <th>Alamat</th>
                                        <th>No. Telpon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($toko as $t)
                                        <tr>
                                            <td>{{ $t->id_toko }}</td>
                                            <td><img src="{{ asset('/storage/toko/' . $t->foto_toko) }}" class="rounded"
                                                    style="width: 150px"></td>
                                            <td>{{ $t->nama_toko }}</td>
                                            <td>{{ $t->grade_toko }}</td>
                                            <td>{{ $t->pemilik }}</td>
                                            <td>{{ $t->alamat }}</td>
                                            <td>{{ $t->nomor_tlp }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <a href="{{ route('admin.toko.edit', $t->id_toko) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="{{ route('admin.toko.destroy', $t->id_toko) }}"
                                                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-dialog modal-xl">...</div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Input Data Toko</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <section class="row">
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    <form action="{{ Route('admin.toko.create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">


                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="nama_toko" class="form-label">Nama toko :</label>
                                                    <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                                        class="form-control @error('nama_toko') is-invalid @enderror"
                                                        placeholder="Nama toko..">
                                                    <div class="text-danger">
                                                        @error('nama_toko')
                                                            Nama toko tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="grade_toko" class="form-label">Rating toko :</label>
                                                    <select class="form-select @error('grade_toko') is-invalid @enderror"
                                                        id="grade_toko" name="grade_toko"
                                                        aria-label="Default select example" required>
                                                        @foreach ($grade as $item)
                                                            <option value="{{ $item->grade_toko }}">
                                                                {{ $item->grade_toko }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger">
                                                        @error('grade_toko')
                                                            Rating toko tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="pemilik">Nama pemilik :</label>
                                                    <input type="text" name="pemilik"
                                                        class="form-control @error('pemilik') is-invalid @enderror"
                                                        placeholder="Nama pemilik..">
                                                    <div class="text-danger">
                                                        @error('pemilik')
                                                            Nama pemilik tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat toko:</label>
                                                    <input type="text" name="alamat"
                                                        class="form-control @error('alamat') is-invalid @enderror"
                                                        placeholder="Nama alamat..">
                                                    <div class="text-danger">
                                                        @error('alamat')
                                                            Alamat tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="nomor_tlp">Nomor Telepon:</label>
                                                    <input type="text" name="nomor_tlp"
                                                        class="form-control @error('nomor_tlp') is-invalid @enderror"
                                                        placeholder="Nomor telepon..">
                                                    <div class="text-danger">
                                                        @error('nomor_tlp')
                                                            Nomor telepon tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="sales">Nama sales :</label>
                                                    <input type="text" name="sales"
                                                        class="form-control @error('sales') is-invalid @enderror"
                                                        placeholder="Nama sales..">
                                                    <div class="text-danger">
                                                        @error('sales')
                                                            Nama sales tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="foto_ktp">Foto KTP:</label>
                                                    <input type="file" name="foto_ktp" accept="image/*"
                                                        class="form-control @error('foto_ktp') is-invalid @enderror">
                                                    <div class="text-danger">
                                                        @error('foto_ktp')
                                                            Foto KTP tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="foto_toko">Foto Toko:</label>
                                                    <input type="file" name="foto_toko" accept="image/*"
                                                        class="form-control @error('foto_toko') is-invalid @enderror">
                                                    <div class="text-danger">
                                                        @error('foto_toko')
                                                            Foto toko tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="modal-footer">
                                                <a href="{{ route('admin.toko') }}" type="button"
                                                    class="btn btn-warning"><i class='nav-icon fas fa-arrow-left'></i>
                                                    &nbsp;
                                                    Kembali</a>
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="nav-icon fas fa-save"></i>
                                                    &nbsp;
                                                    Simpan</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </section>


                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
