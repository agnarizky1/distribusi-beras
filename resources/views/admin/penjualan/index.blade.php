@extends('layouts.app')
@section('link')
    <!-- Skrip DataTables -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <!-- Skrip DataTables Responsif -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Stylesheet DataTables Responsif -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endsection
@section('content')
    <div class="page-heading">
        <h3>Data Penjualan</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row g-3">
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
                            <table id="tabel-distribusi" class="table table-striped table-bordered " style="width:100%">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th>Kode Order</th>
                                        <th>Nama Toko</th>
                                        <th>tgl Orderan</th>
                                        <th>Sales</th>
                                        <th>Status Pengiriman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distri as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_distribusi }}</td>
                                            <td>{{ $d->nama_toko }}</td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d F Y') }}
                                            </td>
                                            <td>{{ $d->sales }}</td>
                                            
                                            </td>
                                            @if ($d->status == 'Diterima')
                                                <td class="text-success text-center">{{ $d->status }}</td>
                                            @endif
                                            @if ($d->status == 'Ditolak')
                                                <td class="text-danger text-center">{{ $d->status }}</td>
                                            @endif
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td class="text-center">
                                                    <a href="{{ route('penjualan.show', $d->id_distribusi) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $d->id_distribusi }}">
                                                        <i class="fa fa-trash-can"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach ($distri as $d)
                        <div class="modal fade" id="deleteConfirmationModal{{ $d->id_distribusi }}" tabindex="-1"
                            role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus oderan ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('distribution.destroy', $d->id_distribusi) }}"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $("#tabel-distribusi").DataTable({
                responsive: true
            });
        });
    </script>
@endsection
