@extends('layouts.app')
@section('link')
    <!-- Skrip DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
@endsection
@section('content')
    <div class="page-heading">
        <h3>Riwayat Delivery Order</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
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
                                        <th>No</th>
                                        <th>Kode Delivery Order</th>
                                        <th>Nama Sopir</th>
                                        <th>Plat No.</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Total Berat(Kg)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivery as $d)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_delivery_orders }}</td>
                                            <td>{{ $d->nama_sopir }}</td>
                                            <td>{{ $d->plat_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal_kirim)->format('d F Y') }}
                                            </td>
                                            <td class="text-center">{{ $d->jumlah_deliveryOrder }} Kg</td>
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td class="text-center">
                                                    <a href="{{ route('admin.DeliveryOrder.show', $d->id_delivery) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $d->id_delivery }}">
                                                        <i class="fa fa-trash-can"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md mb-3 text-end">
                            <a href="{{ route('distribution') }}" class="btn btn-warning"> <i
                                    class='nav-icon fas fa-arrow-left'></i>
                                &nbsp;
                                Kembali
                            </a>
                        </div>
                    </div>
                    @foreach ($delivery as $d)
                        <div class="modal fade" id="deleteConfirmationModal{{ $d->id_delivery }}" tabindex="-1"
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
                                        <a href="{{ route('admin.DeliveryOrder.destroy', $d->id_delivery) }}"
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
@endsection
