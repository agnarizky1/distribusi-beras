@extends('layouts.app')
@section('link')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection
@section('content')
<style>
    .select2-container {
        border: 1px solid #dce7f1;
        padding: 0.275rem 0.75rem;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #fff;
    }

</style>

<div class="page-heading">
    <h3>Data Toko</h3>
</div>
<div class="page-content">
    <section class="row">

        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">
                        <i class="fa-solid fa-folder-plus"></i> Tambah Data
                        Toko</a>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif(session('hapus'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('hapus') }}
                        </div>
                        @endif
                        <table id="tabel-user" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Toko</th>
                                    <th>Pemilik</th>
                                    <th>Alamat</th>
                                    <th>No. Telpon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($toko as $t)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $t->nama_toko }}</td>
                                    <td>{{ $t->pemilik }}</td>
                                    <td>{{ $t->alamat }}</td>
                                    <td>{{ $t->nomor_tlp }}</td>
                                    @if (Auth::user()->role == 'admin')
                                    <td>
                                        <a href="{{ route('admin.toko.show', $t->id_toko) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.toko.edit', $t->id_toko) }}"
                                            class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('admin.toko.destroy', $t->id_toko) }}"
                                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Input Data Toko</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <form action="{{ Route('admin.toko.create') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="sales">Nama sales :</label>
                                                <br>
                                                <select class="form-select" id="sales" name="sales" required
                                                    data-live-search="true">
                                                    <option value="">Pilih Nama Sales</option>
                                                    @foreach ($sales as $s)
                                                    <option value="{{ $s->id_sales }}">
                                                        {{ $s->nama_sales }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('sales')
                                                    Nama sales tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="nama_toko" class="form-label">Nama toko :</label>
                                                <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                                    class="form-control @error('nama_toko') is-invalid @enderror"
                                                    placeholder="Nama toko..">
                                                <div class="text-danger">
                                                    @error('nama_toko')
                                                    Nama toko tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pemilik">Nama pemilik :</label>
                                                <input type="text" name="pemilik"
                                                    class="form-control @error('pemilik') is-invalid @enderror"
                                                    placeholder="Nama pemilik..">
                                                <div class="text-danger">
                                                    @error('pemilik')
                                                    Nama pemilik tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="alamat">Alamat toko:</label>
                                                <input type="text" name="alamat"
                                                    class="form-control @error('alamat') is-invalid @enderror"
                                                    placeholder="Nama alamat..">
                                                <div class="text-danger">
                                                    @error('alamat')
                                                    Alamat tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="nomor_tlp">Nomor Telepon:</label>
                                                <input type="text" name="nomor_tlp"
                                                    class="form-control @error('nomor_tlp') is-invalid @enderror"
                                                    placeholder="Nomor telepon..">
                                                <div class="text-danger">
                                                    @error('nomor_tlp')
                                                    Nomor telepon tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="foto_ktp">Foto KTP:</label>
                                                <input type="file" name="foto_ktp" accept="image/*"
                                                    class="form-control @error('foto_ktp') is-invalid @enderror">
                                                <div class="text-danger">
                                                    @error('foto_ktp')
                                                    Foto KTP tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="foto_toko">Foto Toko:</label>
                                                <input type="file" name="foto_toko" accept="image/*"
                                                    class="form-control @error('foto_toko') is-invalid @enderror">
                                                <div class="text-danger">
                                                    @error('foto_toko')
                                                    Foto toko tidak boleh kosong.
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="latitude" id="latitude" />
                                        <input type="hidden" name="longitude" id="longitude" />
                                        <div class="row mb-3">
                                            <label for="koordinat">Koordinat:</label>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <input type="text" name="koordinat" id="koordinat"
                                                        class="form-control @error('koordinat') is-invalid @enderror"
                                                        placeholder="Koordinat.." readonly>
                                                    <div class="text-danger">
                                                        @error('koordinat')
                                                        Koordinat tidak boleh kosong.
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-end">
                                                    <button type="button" id="chooseLocationBtn"
                                                        class="btn btn-primary">
                                                        Pilih Lokasi Toko
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="map">
                                            <!-- maps -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <a href="{{ route('admin.toko') }}" type="button" class="btn btn-warning"><i
                                                    class='nav-icon fas fa-arrow-left'></i>
                                                &nbsp;
                                                Kembali</a>
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="nav-icon fas fa-save"></i>
                                                &nbsp;
                                                Simpan</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).on('shown.bs.modal', function () {
        $('#sales').select2({
            dropdownParent: $('#exampleModal')
        });
    });

    const selecttoko = $('#sales');
    selecttoko.on('change', function () {
        const selectedOption = $(this).find('option:selected');
    });

</script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    $(document).ready(function () {
        // Inisialisasi variabel untuk melacak status tampilan peta
        var isMapVisible = false;

        // Handle choose location button click
        $('#chooseLocationBtn').click(function () {
            if (!isMapVisible) {
                // Show the map container and set its height and width
                $('#map').css({
                    'display': 'block',
                    'height': '400px',
                    'width': '100%'
                });

                // Set status tampilan peta menjadi true
                isMapVisible = true;

                var map = L.map('map').setView([-8.170249257125231, 113.70318531990053], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add a marker
                var marker = L.marker([-8.170249257125231, 113.70318531990053], {
                    draggable: true
                }).addTo(map);

                // Update coordinates when marker is dragged
                marker.on('dragend', function (event) {
                    var latlng = marker.getLatLng();
                    $('#latitude').val(latlng.lat);
                    $('#longitude').val(latlng.lng);
                    $('#koordinat').val(latlng.lat + ', ' + latlng.lng); // Update koordinat field
                });

                // Handle map click event
                map.on('click', function (event) {
                    // Update marker position and coordinates
                    marker.setLatLng(event.latlng);
                    $('#latitude').val(event.latlng.lat);
                    $('#longitude').val(event.latlng.lng);
                    $('#koordinat').val(event.latlng.lat + ', ' + event.latlng
                        .lng); // Update koordinat field
                });
            } else {
                // Hide the map container
                $('#map').css('display', 'none');

                // Set status tampilan peta menjadi false
                isMapVisible = false;
            }
        });
    });
</script>


@endsection
