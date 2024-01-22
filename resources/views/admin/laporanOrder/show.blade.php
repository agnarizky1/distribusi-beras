@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="card-body">
                            <div class="row mb-2">
                                <h3>Penjualan Pada Tanggal {{\Carbon\Carbon::parse($order[0]->tanggal_distribusi)->format('d F Y') }}</h3>
                            </div>

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
                                        <th>Sales</th>
                                        <th>Tonase</th>
                                        <th>Jumlah Pembelian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $d)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_distribusi }}</td>
                                            <td>{{ $d->toko->nama_toko }}</td>
                                            <td>{{ $d->toko->sales }}</td>
                                            <td>{{$d->jumlah_distribusi - $d->jumlah_return}}</td>
                                            <td>{{$d->total_harga - $d->uang_return - $d->potongan_harga}}</td>
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