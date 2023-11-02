@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Stok Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Beras Masuk</h4>
                        <a id="bayarButton" class="btn btn-primary" data-toggle="modal" data-target="#tambahBerasModal"><i
                                class="fa-solid fa-folder-plus"></i>&nbsp;Tambah
                            Beras</a>
                    </div>
                    <div class="card-body" style="margin-top: -20px">
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
                                        <th width="5%">No</th>
                                        <th>Merk Beras</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Sopir</th>
                                        <th>Plat No.</th>
                                        <th class="text-center">Stock Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beras as $b)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $b->merk_beras }}&nbsp;{{ $b->berat }} Kg</td>
                                            <td>{{ $b->tanggal_masuk_beras }}</td>
                                            <td>{{ $b->nama_sopir }}</td>
                                            <td>{{ $b->plat_no }}</td>
                                            <td class="text-center">{{ $b->stock }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <a href="{{ route('admin.stockberas.edit', $b->id_beras) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $b->id_beras }}">
                                                        <i class="fa fa-trash-can"></i></a>
                                                    <a href="{{ route('admin.stockberas.show', $b->id_beras) }}"
                                                        class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i>
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
                @foreach ($beras as $b)
                        <div class="modal fade" id="deleteConfirmationModal{{ $b->id_beras }}" tabindex="-1"
                            role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('admin.stockberas.destroy', $b->id_beras) }}"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                <div class="card">
                    <div class="card-header">
                        <h4>Total keseluruhan Stock berdasarkan Merk</h4>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Merk Beras</th>
                                        <th>Ukuran Berat</th>
                                        <th>Harga</th>
                                        <th>Total Stock</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $stockMap = [];
                                    @endphp

                                    @foreach ($total as $t)
                                        @php
                                        $key = $t->merk_beras . $t->ukuran_beras;
                                        if (array_key_exists($key, $stockMap)) {
                                            $stockMap[$key]->jumlah_stock += $t->jumlah_stock;
                                        } else {
                                            $stockMap[$key] = $t;
                                        }
                                        @endphp
                                    @endforeach

                                    @foreach ($stockMap as $stock)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $stock->merk_beras }}</td>
                                            <td>{{ $stock->ukuran_beras }} Kg</td>
                                            <td>Rp. {{ number_format($stock->harga, 0, '.', '.') }}</td>
                                            <td class="text-center">{{ $stock->jumlah_stock }}</td>
                                            <td>
                                                <a href="{{ route('admin.jumlahstock.edit', ['id' => $stock->id, 'nilai' => $stock->jumlah_stock]) }}" class="btn btn-warning btn-sm">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- <tr>
                                                <td colspan="4">Jumlah Total:</td>
                                                <td class="text-center" colspan="2">10000</td>
                                            </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- modal yang nanti akan muncul -->
                <div class="modal fade modal-lg" id="tambahBerasModal" tabindex="-1" role="dialog"
                    aria-labelledby="tambahBerasModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahBerasModalLabel">Tambah Beras</h5>
                            </div>
                            <form action="{{ route('admin.stockberas.create') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="nama_sopir">Nama Sopir</label>
                                            <input type="text" class="form-control" id="nama_sopir" name="nama_sopir"
                                                required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="plat_no">Plat No.</label>
                                            <input type="text" class="form-control" id="plat_no" name="plat_no"
                                                required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tanggal_masuk_beras">Tanggal Masuk</label>
                                            <input type="date" class="form-control" id="tanggal_masuk_beras"
                                                value="{{ date('Y-m-d') }}" name="tanggal_masuk_beras" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="merk_beras" class="form-label">Merk Beras :</label>
                                            <select class="form-select @error('beras') is-invalid @enderror" id="merk_beras"
                                                name="merk_beras" aria-label="Default select example" required>
                                                @foreach ($merk as $item)
                                                    <option value="{{ $item->merk }}">{{ $item->merk }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger">
                                                @error('beras')
                                                    Merk tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="berat" class="form-label">Berat :</label>
                                            <select class="form-select @error('berat') is-invalid @enderror" id="berat"
                                                name="berat" aria-label="Default select example" required>
                                                <option value="3">3 KG</option>
                                                <option value="5">5 KG</option>
                                                <option value="10">10 KG</option>
                                                <option value="25">25 KG</option>
                                                <option value="50">50 KG</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="jenis_beras" class="form-label">Jenis Beras :</label>
                                            <select class="form-select @error('jenis') is-invalid @enderror"
                                                id="jenis_beras" name="jenis_beras" aria-label="Default select example"
                                                required>
                                                @foreach ($jenis as $item)
                                                    <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger">
                                                @error('jenis')
                                                    Jenis tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="grade_beras" class="form-label">Grade :</label>
                                            <select class="form-select @error('grade') is-invalid @enderror"
                                                id="grade_beras" name="grade_beras" aria-label="Default select example"
                                                required>
                                                @foreach ($grade as $item)
                                                    <option value="{{ $item->grade }}">{{ $item->grade }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger">
                                                @error('grade')
                                                    Jumlah stock tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="harga" class="form-label">Harga :</label>
                                            <input type="number" name="harga"
                                                class="form-control @error('harga') is-invalid @enderror"
                                                placeholder="Harga beras..">
                                            <div class="text-danger">
                                                @error('harga')
                                                    Harga tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="stock" class="form-label">Jumlah stock :</label>
                                            <input type="number" name="stock"
                                                class="form-control @error('stock') is-invalid @enderror"
                                                placeholder="Jumlah stock..">
                                            <div class="text-danger">
                                                @error('stock')
                                                    Jumlah stock tidak boleh kosong.
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" id="tutupbtn" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#bayarButton").click(function() {
                $("#tambahBerasModal").modal("show");
            });

            $("#tutupbtn").click(function() {
                $("#tambahBerasModal").modal("hide");
            });
        });
    </script>
@endsection
