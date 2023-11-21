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
        <th>Tanggal Masuk</th>
        <th>Toko</th>
        <th>Alamat</th>
        <th>Sales</th>

        @php
            $merkColumns = [];
            $ukuranCount = [];
        @endphp

        @foreach($merk as $m)
            @if (!in_array($m->merk_beras, $merkColumns))
                @php 
                    $merkColumns[] = $m->merk_beras;
                    $ukuranCount[$m->merk_beras] = 0;
                @endphp
                <th colspan="{{ $ukuranCount[$m->merk_beras] * 3 + 3 }}">{{ $m->merk_beras }}</th>
            @endif
        @endforeach
    </tr>

    <tr>
        <th colspan="4"></th>
        @foreach($merkColumns as $merkColumn)
            @foreach($merk as $m)
                @if ($m->merk_beras === $merkColumn)
                    <th>{{ $m->ukuran_beras }}</th>
                    @php $ukuranCount[$m->merk_beras] += 1; @endphp
                @endif
            @endforeach
        @endforeach
    </tr>
</thead>

                                    <tbody>
                                        <tr>
                                            @foreach( $detailDeliveries as $detail)
                                            <td>{{ $detail->distribusi->tanggal_distribusi }}</td>
                                            <td>{{ $detail->distribusi->toko->nama_toko }}</td>
                                            <td>{{ $detail->distribusi->toko->alamat }}</td>
                                            <td>{{ $detail->distribusi->toko->sales }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <strong>Tanggal Kirim : {{ $delivery->tanggal_kirim }}</strong>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.DeliveryOrder.index') }}" class="btn btn-primary">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            @endsection
