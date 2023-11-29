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
                                                        class="btn btn-warning btn-sm mb-1">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.toko.edit', $t->id_toko) }}"
                                                        class="btn btn-primary btn-sm mb-1"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm mb-1" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $t->id_toko }}">
                                                        <i class="fa fa-trash-can"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($toko as $t)
                                <div class="modal fade" id="deleteConfirmationModal{{ $t->id_toko }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi
                                                    Penghapusan
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus distribusi ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <a href="{{ route('admin.toko.destroy', $t->id_toko) }}"
                                                    class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                                                            <option value="{{ $s->nama_sales }}">
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
                                            <div>

                                                <input type="text" name="latitude" id="latitude" hidden>
                                            </div>

                                            <div>

                                                <input type="text" name="longitude" id="longitude" hidden>
                                            </div>

                                            <label for="koordinat">Koordinat:</label>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <input type="text" name="koordinat" id="koordinat"
                                                        class="form-control" placeholder="Koordinat..">
                                                    <div class="text-danger">
                                                        <!-- Add a div for displaying coordinate validation error -->
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-end">
                                                    <button class="btn btn-primary" type="button"
                                                        id="chooseLocationBtn">Choose Location</button>
                                                </div>
                                            </div>
                                            {{-- <input type="hidden" id="latitude" />
                                            <input type="hidden" id="longitude" />
                                            <div class="row mb-3">
                                                <label for="koordinat">Koordinat:</label>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="text" name="koordinat" id="koordinat"
                                                            class="form-control @error('koordinat') is-invalid @enderror"
                                                            placeholder="Koordinat.." required>
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
                                                </div> --}}
                                        </div>
                                        <div id="map">
                                            <!-- maps -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="modal-footer">
                                            <a href="{{ route('admin.toko') }}" type="button"
                                                class="btn btn-warning"><i class='nav-icon fas fa-arrow-left'></i>
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
        $(document).on('shown.bs.modal', function() {
            $('#sales').select2({
                dropdownParent: $('#exampleModal')
            });
        });

        const selecttoko = $('#sales');
        selecttoko.on('change', function() {
            const selectedOption = $(this).find('option:selected');
        });
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            var isMapVisible = false;
            var map, marker;

            $('#chooseLocationBtn').click(function() {
                if (!isMapVisible) {
                    $('#map').css({
                        'display': 'block',
                        'height': '400px',
                        'width': '100%'
                    });

                    isMapVisible = true;

                    map = L.map('map').setView([0, 0], 2);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([0, 0], {
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', function(event) {
                        updateCoordinates(event.latlng.lat, event.latlng.lng);
                    });

                    map.on('click', function(event) {
                        updateCoordinates(event.latlng.lat, event.latlng.lng);
                    });
                } else {
                    $('#map').css('display', 'none');
                    isMapVisible = false;
                }
            });

            function updateCoordinates(lat, lng) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], map.getZoom()); // Pindahkan peta ke koordinat baru

                $('#latitude').val(lat);
                $('#longitude').val(lng);
                $('#koordinat').val(lat + ', ' + lng);
            }

            $('#koordinat').on('input', function() {
                var koordinatInput = $('#koordinat').val();
                var koordinatArray = koordinatInput.split(',');

                if (koordinatArray.length === 2) {
                    var lat = parseFloat(koordinatArray[0].trim());
                    var lng = parseFloat(koordinatArray[1].trim());

                    if (!isNaN(lat) && !isNaN(lng)) {
                        updateCoordinates(lat, lng);
                    }
                }
            });
        });
    </script>
@endsection
