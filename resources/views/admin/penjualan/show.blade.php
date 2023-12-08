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
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko : {{ $toko->nama_toko }}</p>
                                <p>Alamat : {{ $toko->alamat }}</p>
                                <p>Sales : {{ $toko->sales }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Order Beras : {{ $distribusi->tanggal_distribusi }}</p>
                                <p>Tonase Orderan : {{ $distribusi->jumlah_distribusi }} KG</p>
                                <p>Yang Harus Dibayar : Rp.
                                    {{ number_format($distribusi->total_harga-$distribusi->uang_return, 0, '.', '.') }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered ">
                                    <thead class="text-center">
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
                                                <td class="text-center">{{ $detail->nama_beras }}</td>
                                                <td class="text-center">{{ $detail->jumlah_beras }}</td>
                                                <td class="text-center">Rp. {{ number_format($detail->harga, 0, '.', '.') }}
                                                </td>
                                                <td>Rp. {{ number_format($detail->sub_total, 0, '.', '.') }}</td>
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
                                        @if($distribusi->uang_return != 0)
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total Uang Return :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($distribusi->uang_return, 0, '.', '.') }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total Harga :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($distribusi->total_harga-$distribusi->uang_return, 0, '.', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($distribusi->uang_return != 0)
                                    <p class="text-danger">Beras Yang Direturn</p>
                                    <small>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Nama</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p>Jumlah</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p>Subtotal</p>
                                        </div>
                                    </div>
                                    @foreach ($detailDistribusi as $detail)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>{{$detail->nama_beras}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p>: {{$detail->jumlah_return }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p>: {{ number_format($detail->jumlah_return * $detail->harga, 0, '.', '.')}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p>Total Harga Yang Direturn</p>
                                        </div>
                                        <div class="col-md-2">
                                        : {{number_format( $distribusi->uang_return	, 0, '.', '.')}}
                                        </div>
                                    </div>
                                    </small>
                                @endif
                            </div>
                            <div class=" text-end">
                                <a href="{{ route('penjualan') }}" class="btn btn-warning">
                                    <i class='nav-icon fas fa-arrow-left'></i>
                                    &nbsp;
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
