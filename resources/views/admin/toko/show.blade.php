@extends('layouts.app')
@section('link')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection
@section('content')

<div class="page-heading">
    <h3>Detail Toko</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                            <div class="col-md-6">
                                <h1 class="fs-5">Detail Toko</h1>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.toko') }}" class="btn btn-primary">
                                    Kembali
                                </a>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nama_toko" class="form-label">Nama toko:</label>
                            <input type="text" class="form-control" value="{{ $toko->nama_toko }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="pemilik" class="form-label">Nama pemilik:</label>
                            <input type="text" class="form-control" value="{{ $toko->pemilik }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat toko:</label>
                        <input type="text" class="form-control" value="{{ $toko->alamat }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_tlp" class="form-label">Nomor Telepon:</label>
                        <input type="text" class="form-control" value="{{ $toko->nomor_tlp }}" readonly>
                    </div>
                    <table class="table table-bordered">
                            <thead>
                                <tr  class="text-center">
                                    <th>Foto KTP</th>
                                    <th>Foto Toko</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td class="text-center">
                                <img src="{{ asset('uploads/ktp/' . $toko->foto_ktp) }}" style="height: auto; max-width: 400px;" alt="Foto KTP" class="img-fluid">

                                </td>
                                <td class="text-center">
                                <img src="{{ asset('uploads/toko/' . $toko->foto_toko) }}" style="height: auto; max-width: 400px;" alt="Foto Toko" class="img-fluid">

                                </td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="mb-3">
                        <label for="sales" class="form-label">Sales:</label>
                        <input type="text" class="form-control" value="{{ $toko->sales }}" readonly>
                    </div>    
                    <div class="mb-3">
                        <label for="koordinat" class="form-label">Koordinat:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $toko->koordinat }}" readonly>
                            <div class="input-group-append">
                                <a href="https://www.google.com/maps?q={{ $toko->koordinat }}" target="_blank" class="btn btn-primary">
                                    Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="map" style="height: 400px;"></div>
                    <!-- Tambahkan script untuk menampilkan peta dengan marker pada koordinat toko -->

                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                    <script>
                        var map = L.map('map').setView([{{ $toko->koordinat }}], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        // Add a marker
                        var marker = L.marker([{{ $toko->koordinat }}]).addTo(map);
                    </script>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection



