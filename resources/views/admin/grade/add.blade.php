@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Input Data Grade</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <form action="{{ Route('admin.grade.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="grade">Grade :</label>
                                    <input type="text" name="grade"
                                        class="form-control @error('grade') is-invalid @enderror" placeholder="Grade..">
                                    <div class="text-danger">
                                        @error('grade')
                                            Grade tidak boleh kosong.
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('admin.grade') }}" type="button" class="btn btn-warning"><i
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
