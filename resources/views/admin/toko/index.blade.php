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
                        <a href="{{ route('admin.toko.add') }}" type="button" class="btn btn-primary">
                            <i class="fa-solid fa-folder-plus"></i> Tambah Data
                            User</a>
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
                                        <th width="5%">No</th>
                                        <th>Id Toko</th>
                                        <th>Nama Toko</th>
                                        <th>Pemilik</th>
                                        <th>Alamat</th>
                                        <th>No. Telpon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($toko as $t)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $t->id }}</td>
                                            <td>{{ $t->nama_toko }}</td>
                                            <td>{{ $t->pemilik }}</td>
                                            <td>{{ $t->alamat }}</td>
                                            <td>{{ $t->nomor_tlp }}</td>
                                            @if (Auth::user()->role == 'superadmin')
                                                <td>
                                                    <a href="{{ route('admin.toko.edit', $t->id) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="{{ route('admin.toko.destroy', $t->id) }}"
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
        </section>
    </div>
@endsection
