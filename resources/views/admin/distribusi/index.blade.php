@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Data Distribusi</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('distribution.add') }}" type="button" class="btn btn-primary">
                            <i class="fa-solid fa-folder-plus"></i> Tambah Data
                            Distribusi</a>
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
                                        <th>Kode Distribusi</th>
                                        <th>Nama Toko</th>
                                        <th>Nama Sopir</th>
                                        <th>Plat No.</th>
                                        <th>tgl Distribusi</th>
                                        <th>jumlah Distribusi</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distri as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_distribusi }}</td>
                                            <td>{{ $d->nama_toko }}</td>
                                            <td>{{ $d->nama_sopir }}</td>
                                            <td>{{ $d->plat_no }}</td>
                                            <td>{{ $d->tanggal_distribusi }}</td>
                                            <td class="text-center">{{ $d->jumlah_distribusi }} KG</td>
                                            <td>
                                                {{ $d->total_harga }}
                                                <br>
                                                @if ($pembayaranTotals[$d->id_distribusi] >= $d->total_harga)
                                                    <span class="text-success">Lunas</span>
                                                @else
                                                    <span class="text-danger">Sisa Bayar: {{ $d->total_harga - $pembayaranTotals[$d->id_distribusi] }}</span>
                                                @endif
                                            </td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <a href="{{ route('distribution.show', $d->id_distribusi) }}"
                                                        class="btn btn-warning btn-sm">
                                                            <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('distribution.destroy', $d->id_distribusi) }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash-can"></i>
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