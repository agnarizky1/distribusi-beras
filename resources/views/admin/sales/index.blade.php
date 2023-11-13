@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Data Sales</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.sales.add') }}" type="button" class="btn btn-primary">
                            <i class="fa-solid fa-folder-plus"></i> Tambah Data
                            Sales</a>
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
                                        <th>Nama Sales</th>
                                        <th>Nomor Telpon</th>
                                        <th width="100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $s)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $s->nama_sales }}</td>
                                            <td>{{ $s->no_telpon }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <a href="{{ route('admin.sales.edit', $s->id_sales) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="{{ route('admin.sales.destroy', $s->id_sales) }}"
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
