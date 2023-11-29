@extends('layouts.app')

@section('content')
<div class="row mt-3">
<div class=" text-center">
    <h3>Detail Dilevery Order</h3>
</div>
<div class="col-12">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th rowspan="2">Tanggal Masuk</th>
                <th rowspan="2">Toko</th>
                <th rowspan="2">Alamat</th>
                <th rowspan="2">Sales</th>
                @php
                    $merkColumns = [];
                @endphp

                @foreach($merk as $m)
                    @if (!in_array($m->merk_beras, $merkColumns))
                        @php 
                            $merkColumns[] = $m->merk_beras;
                            $colspan = count(array_filter($merk->toArray(), function($item) use ($m) {
                                return $item['merk_beras'] === $m->merk_beras;
                            }));
                        @endphp
                        <th colspan="{{ $colspan }}">{{ $m->merk_beras }}</th>
                    @endif
                @endforeach
                <th rowspan="2">Tonase</th>
            </tr>

            <tr>
                @foreach($merkColumns as $merkColumn)
                    @foreach($merk as $m)
                        @if ($m->merk_beras === $merkColumn)
                            <th>{{ $m->ukuran_beras }}</th>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach( $detailDeliveries as $detail)
            <tr>
                <td>{{ $detail->distribusi->tanggal_distribusi }}</td>
                <td>{{ $detail->distribusi->toko->nama_toko }}</td>
                <td>{{ $detail->distribusi->toko->alamat }}</td>
                <td>{{ $detail->distribusi->toko->sales }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <strong>Tanggal Kirim : {{ $delivery->tanggal_kirim }}</strong>
</div>
</div>
@endsection
