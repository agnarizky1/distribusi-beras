@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-md-6">
                <h3>Detail Order</h3>
            </div>

        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="col-md-6">
                            <a href="{{ route('distribution') }}" class="btn btn-primary">
                                Kembali
                            </a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko : {{ $toko->nama_toko }}</p>
                                <p>Alamat : {{ $toko->alamat }}</p>
                                <p>Sales : {{ $toko->sales }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Order Beras : {{ $distribusi->tanggal_distribusi }}</p>
                                <p>Jumlah Seluruh Orderan : {{ $distribusi->jumlah_distribusi }} KG</p>
                                <p>Yang Harus Dibayar : {{ $distribusi->total_harga }}</p>
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
                                        @php
                                            $totalHarga = 0;
                                        @endphp
                                        @foreach ($detailDistribusi as $detail)
                                            <tr>
                                                <td>{{ $detail->nama_beras }}</td>
                                                <td>{{ $detail->jumlah_beras }}</td>
                                                <td>{{ $detail->harga }}</td>
                                                <td>{{ $detail->sub_total }}</td>
                                            </tr>
                                            @php
                                                $totalHarga += $detail->sub_total;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total :</strong>
                                            </td>
                                            <td>Rp. {{ number_format($totalHarga, 0, '.', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Diskon :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($totalHarga - $distribusi->total_harga, 0, '.', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total Harga :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($distribusi->total_harga, 0, '.', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="text-end">
                                <a href="{{ route('distribution.cetak', $distribusi->id_distribusi) }}"
                                    class="btn btn-warning btn-sm">Print</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
