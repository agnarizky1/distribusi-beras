@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Data User</h3>
    </div>
    <div class="page-content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit Data User</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ Route('admin.user.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="name">Nama :</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="Nama">
                                            <div class="text-danger">
                                                @error('name')
                                                    Nama tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="email">Email :</label>
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email">
                                            <div class="text-danger">
                                                @error('email')
                                                    Email Obat tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="password">Password :</label>
                                            <input type="password" name="password" value="{{ old('password') }}"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="password">
                                            <div class="text-danger">
                                                @error('password')
                                                    Password beli tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="role">Role : </label>
                                            <select id="edit_role" name="role" class="form-control">
                                                <option value="{{ $user->role }}" hidden>{{ $user->role }}</option>
                                                <option value="superadmin">SuperAdmin</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                            <span class="error-message-edit text-danger" id="error-edit-jenis"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="{{ route('admin.user') }}" type="button" class="btn btn-warning"><i
                                            class='nav-icon fas fa-arrow-left'></i> &nbsp;
                                        Kembali</a>
                                    <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i>
                                        &nbsp;
                                        Simpan</button>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
@endsection
