@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col">
                <h3>Detail Dilevery Order</h3>
            </div>
        </div>
        <div class="row">
            <div class="text-end">
                <a href="{{ route('admin.DeliveryOrder.index') }}" class="btn btn-primary">
                    Kembali
                </a>
                <a href="{{ route('admin.DeliveryOrder.showDO', $delivery->id_delivery) }}" class="btn btn-success">
                    print
                </a>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
            @foreach ($detailDeliveries as $detailDeliveries)
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h4 class="mb-3"> Orderan {{ $loop->iteration }}</h4>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko : {{ $detailDeliveries->distribusi->toko->nama_toko }}</p>
                                <p>Alamat : {{ $detailDeliveries->distribusi->toko->alamat }}</p>
                                <p>Sales : {{ $detailDeliveries->distribusi->toko->sales }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Order Beras : {{ $detailDeliveries->distribusi->tanggal_distribusi }}</p>
                                <p>Tonase Orderan : {{ $detailDeliveries->distribusi->jumlah_distribusi }} KG</p>
                                <p>Yang Harus Dibayar : Rp.
                                    {{ number_format($detailDeliveries->distribusi->total_harga, 0, '.', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </section>
    </div>
@endsection
