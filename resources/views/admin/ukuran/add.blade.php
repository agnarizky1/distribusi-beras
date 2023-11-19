@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Input Data Ukuran Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <form action="{{ Route('admin.ukuran.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="berat">Ukuran beras (berat) :</label>
                                    <input type="text" name="berat"
                                        class="form-control @error('berat') is-invalid @enderror"
                                        placeholder="Ukuran beras..">
                                    <div class="text-danger">
                                        @error('berat')
                                            Ukuran beras tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.ukuran') }}" type="button" class="btn btn-warning"><i
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
