@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Input Data Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <form action="{{ Route('admin.toko.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="nama_toko">Nama toko :</label>
                                    <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                        class="form-control @error('nama_toko') is-invalid @enderror"
                                        placeholder="Nama toko..">
                                    <div class="text-danger">
                                        @error('nama_toko')
                                            Nama toko tidak boleh kosong.
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
                            <!-- /.card-body -->
                            <div class="card-footer">
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
