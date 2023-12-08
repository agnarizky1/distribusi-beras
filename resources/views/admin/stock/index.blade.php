@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Stok Beras</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <!-- data beras masuk -->
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
                                            @if($b->keterangan == "Beras Return")
                                            <td class="text-danger">{{$b->keterangan}} {{ $b->merk_beras }}&nbsp;{{ $b->berat }} Kg</td>
                                            @endif
                                            @if($b->keterangan == "Dari Pabrik")
                                            <td>{{ $b->merk_beras }}&nbsp;{{ $b->berat }} Kg</td>
                                            @endif
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

                    @foreach ($beras as $b)
                        <div class="modal fade" id="deleteConfirmationModal{{ $b->id_beras }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
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
                </div>

                <!-- total seluruh stok -->
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
                                        @if ($stock->jumlah_stock != 0 || $stock->jumlah_stock != null)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $stock->merk_beras }}</td>
                                                <td>{{ $stock->ukuran_beras }} Kg</td>
                                                <td class="text-center">{{ $stock->jumlah_stock }}</td>
                                                <td>
                                                    <a href="{{ route('admin.jumlahstock.edit', ['id' => $stock->id]) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Data beras Rusak -->
                <div class="card">
                    <div class="card-header">
                        <h4>Data Beras Rusak</h4>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Merk Beras</th>
                                        <th>Ukuran Berat</th>
                                        <th>Jumlah PCS</th>
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
                                        @if ($stock->jumlah_stock != 0 || $stock->jumlah_stock != null)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $stock->merk_beras }}</td>
                                                <td>{{ $stock->ukuran_beras }} Kg</td>
                                                <td class="text-center">{{ $stock->jumlah_stock }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
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
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="nama_sopir">Nama Sopir</label>
                                        <input type="text" class="form-control" id="nama_sopir" name="nama_sopir"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="plat_no">Plat No.</label>
                                        <input type="text" class="form-control" id="plat_no" name="plat_no" required>
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
                                        <select class="form-select merk_beras" name="merk_beras[]">
                                            @foreach ($merk as $item)
                                                <option value="{{ $item->merk }}">{{ $item->merk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="berat" class="form-label">Berat :</label>
                                        <select class="form-select berat" name="berat[]">
                                            @foreach ($ukuran as $ukuran)
                                                <option value="{{ $ukuran->berat }}">{{ $ukuran->berat }} KG</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="harga" class="form-label">Harga per KG :</label>
                                        <input type="number" name="harga[]" class="form-control harga "
                                            placeholder="Harga beras..">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hargapcs" class="form-label">Harga satuan :</label>
                                        <input type="number" name="hargapcs[]" class="form-control hargapcs"
                                            placeholder="Harga beras.." readonly>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="stock" class="form-label">Jumlah stock :</label>
                                        <input type="number" name="stock[]" class="form-control stock "
                                            placeholder="Jumlah stock..">
                                    </div>
                                </div>

                                <div class="text-end mb-3">
                                    <button type="button" id="tambahBtn"
                                        class="btn btn-success btn-sm text-white rounded"><i class="fa fa-save"></i>
                                        Tambah Barang</button>
                                </div>
                                <!-- Tabel untuk menampilkan data beras yang telah ditambahkan -->
                                <table class="table table-bordered" id="berasTable">
                                    <thead>
                                        <tr>
                                            <th>Merk Beras</th>
                                            <th>Berat (KG)</th>
                                            <th>Harga per KG</th>
                                            <th>Harga satuan</th>
                                            <th>Jumlah Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transaction-records">
                                        <!-- Data beras yang telah ditambahkan akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="tutupbtn" class="btn btn-secondary"
                                    data-dismiss="modal">Tutup</button>
                                <button id="simpanberas" type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#bayarButton").click(function() {
                $("#tambahBerasModal").modal("show");
            });

            $("#tutupbtn").click(function() {
                $("#tambahBerasModal").modal("hide");
            });

            $("#harga").on('input', function() {
                updateHargapcs();
            });

            $("#berat").on('input', function() {
                updateHargapcs();
            });

            function updateHargapcs() {
                var hargapcs = $("#hargapcs");
                var harga = $("#harga").val();
                var berat = $("#berat").val();

                hargapcs.val(harga * berat);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk menambahkan data beras ke dalam tabel
            function addBerasToTable(merk_beras, berat, harga, hargapcs, stock) {
                var newRow = '<tr>' +
                    '<td>' + merk_beras + '</td>' +
                    '<td>' + berat + ' KG</td>' +
                    '<td>' + harga + '</td>' +
                    '<td>' + hargapcs + '</td>' +
                    '<td>' + stock + '</td>' +
                    '<td><button type="button" class="btn btn-danger btn-sm  hapus-btn">Hapus</button></td>' +
                    '</tr>';
                $('#berasTable tbody').append(newRow);

                // Menambahkan event listener setelah menambahkan baris baru
                $('.hapus-btn').off('click').on('click', function() {
                    hapusBaris(this);
                });
            }

            function hapusBaris(button) {
                var row = $(button).closest('tr');
                row.remove();
            }



            // Fungsi untuk mereset nilai input setelah data beras ditambahkan
            function resetInputValues() {
                $('.merk_beras, .berat, .harga, .hargapcs, .stock').val('');
            }

            // Fungsi untuk menghitung harga satuan saat mengisi harga per KG
            $(document).on('input', '.harga', function() {
                var hargaPerKG = parseFloat($(this).val()) || 0;
                var berat = parseFloat($('.berat').val()) || 1;
                $('.hargapcs').val(hargaPerKG * berat);
            });

            // Event listener untuk tombol "Tambah Barang"
            $('#tambahBtn').click(function() {
                // Validasi input sebelum menambahkan ke dalam tabel
                var merk_beras = $('.merk_beras').val();
                var berat = $('.berat').val();
                var harga = $('.harga').val();
                var hargapcs = $('.hargapcs').val();
                var stock = $('.stock').val();

                // Validasi elemen select
                if (merk_beras && berat && harga && hargapcs && stock) {
                    // Tambahkan data beras ke dalam tabel
                    addBerasToTable(merk_beras, berat, harga, hargapcs, stock);



                    // Reset nilai input
                    resetInputValues();
                } else {
                    alert('Semua kolom harus diisi, termasuk pemilihan Merk Beras dan Berat.');
                }
            });

            document.getElementById('simpanberas').addEventListener('click', function() {
                var beras = [];
                var namaSopir = document.getElementById('nama_sopir').value;
                var platNo = document.getElementById('plat_no').value;
                var tanggal_masuk = document.getElementById('tanggal_masuk_beras').value;

                document.querySelectorAll('#transaction-records tr').forEach(function(row) {
                    var merkBeras = row.querySelector('td:nth-child(1)').textContent;
                    var beratBeras = row.querySelector('td:nth-child(2)').textContent;
                    var hargaBeras = parseFloat(row.querySelector('td:nth-child(3)')
                        .textContent);
                    var jumlahStock = parseInt(row.querySelector('td:nth-child(5)')
                        .textContent);
                    var ukuranBeras = parseFloat(beratBeras);

                    beras.push({
                        merk: merkBeras,
                        berat: ukuranBeras,
                        harga: hargaBeras,
                        jumlah: jumlahStock,
                    });
                });
                console.table(beras)
                console.log(namaSopir, platNo, tanggal_masuk);

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '{{ url('/admin/stockberas/create') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        namaSopir: namaSopir,
                        platNo: platNo,
                        tanggal_masuk: tanggal_masuk,
                        beras: beras
                    },
                    success: function(response) {
                        Swal.fire('Success', 'beras berhasil disimpan', 'success');
                        window.location.href ='{{ route('admin.stockberas') }}';
                    },
                    error: function(xhr, status, error) {
                        // Penanganan kesalahan (jika diperlukan)
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
