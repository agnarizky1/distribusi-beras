@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Detail Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <ul>
                        <li>ID Toko: {{ $toko->id_toko }}</li>
                        <li>Sales: {{ $toko->sales }}</li>
                        <li>Foto Toko: <img src="{{ asset('storage/toko/' . $toko->foto_toko) }}" alt="Foto Toko"></li>
                        <li>Nama Toko: {{ $toko->nama_toko }}</li>
                        <li>Pemilik: {{ $toko->pemilik }}</li>
                        <li>Foto KTP: <img src="{{ asset('storage/ktp/' . $toko->foto_ktp) }}" alt="Foto KTP"></li>
                        <li>Alamat: {{ $toko->alamat }}</li>
                        <li>Nomor Telepon: {{ $toko->nomor_tlp }}</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
@endsection
