@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class=" text-center">
                                <h3>Detail Dilevery Order</h3>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            {{-- <th>No.</th> --}}
                                            <th>Tanggal Masuk</th>
                                            <th>Toko</th>
                                            <th>Alamat</th>
                                            <th>Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $delivery->tanggal_kirim }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p>TTD Sopir</p>
                            <br>
                            <br>
                            <br>
                            <p>{{ $delivery->nama_sopir }}</p>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.DeliveryOrder.index') }}" class="btn btn-primary">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            @endsection
