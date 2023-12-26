@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Form Edit Data Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <form action="{{ Route('admin.jumlahstock.update', $total->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nama_beras" class="form-label">Beras :</label>
                                    <input type="text" name="nama_beras" value="{{ $total->merk_beras }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="berat" class="form-label">Berat
                                        :</label>
                                    <input type="number" name="berat" value="{{ $total->ukuran_beras }}"
                                        class="form-control " readonly>

                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label">Harga :</label>
                                    <input type="number" name="harga" id="harga" value="{{ $total->harga }}"
                                        class="form-control @error('harga') is-invalid @enderror"
                                        placeholder="Harga beras..">
                                    <div class="text-danger">
                                        @error('harga')
                                            Harga tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock" class="form-label">JumlahTotal stock
                                        :</label>
                                    <input type="text" name="jumlah_stock" value="{{ $total->jumlah_stock }}"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Jumlah stock.."disabled>
                                    <div class="text-danger">
                                        @error('stock')
                                            Jumlah stock tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-end">
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
