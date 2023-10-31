@extends('layouts.app')

@section('content')
<div class="page-heading">
    <h3>Detail Beras</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Kode beras: {{ $beras->id_beras }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.stockberas') }}" class="btn btn-primary">
                                Kembali
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Nama Sopir: {{ $beras->nama_sopir }}</p>
                            <p>Plat No.: {{ $beras->plat_no }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>Tanggal Kirim Beras : {{ $beras->tanggal_masuk_beras }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                        <table id="tabel-user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Beras</th>
                                        <th>Berat</th>
                                        <th class="text-center">Harga</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>{{ $beras->merk_beras }}</td>
                                            <td>{{ $beras->berat }} Kg</td>
                                            <td class="text-center">Rp. {{ number_format($beras->harga, 0, '.', '.') }}</td>
                                            <td>{{ $beras->stock }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection