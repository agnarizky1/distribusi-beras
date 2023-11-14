@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Form Edit Data Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <form action="{{ Route('admin.toko.update', $toko->id_toko) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales:</label>
                                <input type="text" name="sales" value="{{ $toko->sales }}"
                                    class="form-control @error('sales') is-invalid @enderror" placeholder="Nama sales..">
                                <div class="text-danger">
                                    @error('sales')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="foto_toko" class="form-label">Foto Toko:</label>
                                    <input type="file" name="foto_toko"
                                        class="form-control @error('foto_toko') is-invalid @enderror">
                                    <div class="text-danger">
                                        @error('foto_toko')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                    @if ($toko->foto_toko)
                                        <img src="{{ asset('storage/toko/' . $toko->foto_toko) }}" alt="Foto Toko"
                                            class="img-fluid mt-2">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="foto_ktp" class="form-label">Foto KTP:</label>
                                    <input type="file" name="foto_ktp"
                                        class="form-control @error('foto_ktp') is-invalid @enderror">
                                    <div class="text-danger">
                                        @error('foto_ktp')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                    @if ($toko->foto_ktp)
                                        <img src="{{ asset('storage/ktp/' . $toko->foto_ktp) }}" alt="Foto KTP"
                                            class="img-fluid mt-2">
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nama_toko" class="form-label">Nama toko :</label>
                                    <input type="text" name="nama_toko" value="{{ $toko->nama_toko }}"
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
                                    <select class="form-select @error('grade_toko') is-invalid @enderror" id="grade_toko"
                                        name="grade_toko">
                                        @foreach ($grade as $item)
                                            <option value="{{ $item->grade_toko }}"
                                                @if ($toko->grade_toko == $item->grade_toko) selected @endif>
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
                                    <input type="text" name="pemilik" value="{{ $toko->pemilik }}"
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
                                    <input type="text" name="alamat" value="{{ $toko->alamat }}"
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
                                    <input type="text" name="nomor_tlp" value="{{ $toko->nomor_tlp }}"
                                        class="form-control @error('nomor_tlp') is-invalid @enderror"
                                        placeholder="Nomor telepon..">
                                    <div class="text-danger">
                                        @error('nomor_tlp')
                                            Nomor telepon tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.toko') }}" type="button" class="btn btn-warning"><i
                                        class='nav-icon fas fa-arrow-left'></i> &nbsp;
                                    Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i>
                                    &nbsp;
                                    Simpan</button>
                            </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
