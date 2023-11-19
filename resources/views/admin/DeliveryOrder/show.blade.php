@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-md-6">
                <h3>Detail Dilevery Order</h3>
            </div>

        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko :</p>
                                <p>Alamat : </p>
                                <p>Sales : </p>
                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Order Beras : </p>
                                <p>Jumlah Seluruh Orderan : KG</p>
                                <p>Yang Harus Dibayar : </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama Beras</th>
                                            <th>Jumlah (QTY)</th>
                                            <th>Harga (satuan)</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.DeliveryOrder.index') }}" class="btn btn-primary">
                            Kembali
                        </a>
                    </div>
                </div>
            @endsection
