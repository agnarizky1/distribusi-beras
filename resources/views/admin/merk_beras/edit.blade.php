@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Form Edit Data Merk</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <form action="{{ Route('admin.merk.update', $merk->id_merk) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="merk">Merk :</label>
                                    <input type="text" name="merk" value="{{ $merk->merk }}"
                                        class="form-control @error('merk') is-invalid @enderror" placeholder="Merk..">
                                    <div class="text-danger">
                                        @error('merk')
                                            Merk tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.merk') }}" type="button" class="btn btn-warning"><i
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
