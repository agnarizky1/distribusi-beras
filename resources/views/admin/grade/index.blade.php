@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Data Grade</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.grade.add') }}" type="button" class="btn btn-primary">
                            <i class="fa-solid fa-folder-plus"></i> Tambah Data
                            Grade</a>
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
                            <table id="tabel-user" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th class="text-center">Grade</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grade as $g)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $g->grade }}</td>
                                            @if (Auth::user()->role == 'superadmin')
                                                <td class="text-right">
                                                    <a href="{{ route('admin.grade.edit', $g->id_grade) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="{{ route('admin.grade.destroy', $g->id_grade) }}"
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
