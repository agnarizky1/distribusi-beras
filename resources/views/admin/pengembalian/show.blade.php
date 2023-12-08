@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Detail Pengembalian</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h4>Informasi Pengembalian</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Kode Pengembalian:</strong> {{ $pengembalian->kode_pengembalian }}
                </div>
                <div class="mb-3">
                    <strong>Tanggal Pengembalian:</strong> {{ $pengembalian->tanggal_pengembalian }}
                </div>
                <!-- Add more details as needed -->

                <hr>

                <h4>Detail Distribusi</h4>
                <div class="mb-3">
                    <strong>Kode Distribusi:</strong> {{ $distribusi->kode_distribusi }}
                </div>
                <!-- Add more details about the distribution as needed -->

                <hr>

                <h4>Detail Pembelian</h4>
                @if(count($detailDistribusi) > 0)
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>Nama Barang</th>
                                <th>Jumlah Total Return</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $total = 0;
                            @endphp
                            @foreach($detailDistribusi as $detail)
                                <tr class="text-center">
                                    <td>{{ $detail->nama_beras }}</td>
                                    <td>{{$detail->jumlah_return}}</td>
                                    <td>{{ $detail->harga }}</td>
                                    <td>{{ $detail->harga *  $detail->jumlah_return }}</td>
                                    @php 
                                    $total += $detail->harga *  $detail->jumlah_return;
                                    @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="3" class="text-end"> Total Uang Return:</th>
                                <td class="text-center">{{$total}}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p>No details available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
