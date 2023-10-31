@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Input Stok Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <form action="{{ Route('admin.input_beras.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nama_sopir">Nama Sopir</label>
                                    <input type="text" class="form-control" id="nama_sopir" name="nama_sopir" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="plat_no">Plat No.</label>
                                    <input type="text" class="form-control" id="plat_no" name="plat_no" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tanggal_masuk_beras">Tanggal Masuk Beras</label>
                                    <input type="date" class="form-control" id="tanggal_masuk_beras" value="{{ date('Y-m-d') }}" name="tanggal_masuk_beras" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="merk_beras" class="form-label">Merk Beras :</label>
                                    <select class="form-select @error('beras') is-invalid @enderror" id="merk_beras"
                                        name="merk_beras" aria-label="Default select example" required>
                                        @foreach ($merk as $item)
                                            <option value="{{ $item->merk }}">{{ $item->merk }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('beras')
                                            Merk tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="berat" class="form-label">Berat :</label>
                                    <input type="number" name="berat"
                                        class="form-control @error('berat') is-invalid @enderror"
                                        placeholder="Berat beras..(KG)">
                                    <div class="text-danger">
                                        @error('berat')
                                            Berat tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jenis_beras" class="form-label">Jenis Beras :</label>
                                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis_beras"
                                        name="jenis_beras" aria-label="Default select example" required>
                                        @foreach ($jenis as $item)
                                            <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('jenis')
                                            Jenis tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="grade_beras" class="form-label">Grade :</label>
                                    <select class="form-select @error('grade') is-invalid @enderror" id="grade_beras"
                                        name="grade_beras" aria-label="Default select example" required>
                                        @foreach ($grade as $item)
                                            <option value="{{ $item->grade }}">{{ $item->grade }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('grade')
                                            Jumlah stock tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label">Harga :</label>
                                    <input type="number" name="harga"
                                        class="form-control @error('harga') is-invalid @enderror"
                                        placeholder="Harga beras..">
                                    <div class="text-danger">
                                        @error('harga')
                                            Harga tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock" class="form-label">Jumlah stock :</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Jumlah stock..">
                                    <div class="text-danger">
                                        @error('stock')
                                            Jumlah stock tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('admin.input_beras') }}" type="button" class="btn btn-warning"><i
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