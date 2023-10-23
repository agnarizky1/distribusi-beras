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
                    <form action="{{ Route('admin.stockberas.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nama_beras" class="form-label">Beras :</label>
                                    <input type="text" name="nama_beras"
                                        class="form-control @error('beras') is-invalid @enderror"
                                        placeholder="Nama Beras..">
                                    <div class="text-danger">
                                        @error('beras')
                                            Nama beras tidak boleh kosong.
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
                                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis_beras" name="jenis_beras" aria-label="Default select example" required>
                                    @foreach($jenis as $item)
                                        <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                                    @endforeach
                                    </select>
                                    <div class="text-danger">
                                        @error('jenis')
                                            Harga tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="grade_beras" class="form-label">Grade :</label>
                                    <select class="form-select @error('grade') is-invalid @enderror" id="grade_beras" name="grade_beras" aria-label="Default select example" required>
                                        @foreach($grade as $item)
                                            <option value="{{ $item->id }}">{{ $item->grade }}</option>
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
                                <a href="{{ route('admin.stockberas') }}" type="button" class="btn btn-warning"><i
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
