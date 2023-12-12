@extends('layouts.app')
@section('link')
    <!-- Skrip DataTables -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <!-- Skrip DataTables Responsif -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Stylesheet DataTables Responsif -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
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

        .body {
            box-sizing: border-box;
            /* tambahkan ini */
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
    </style>
    <div class="page-heading">
        <h3>Data Pengembalian</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row g-3">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <a data-bs-toggle="modal" data-bs-target="#returnModal" type="button"
                                        class="btn btn-primary">
                                        <i class="fa-solid fa-folder-plus"></i> Tambah Pengembalian
                                    </a>
                                </div>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif(session('hapus'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('hapus') }}
                                </div>
                            @endif
                            <table id="tabel-distribusi" class="table table-striped table-bordered " style="width:100%">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th>Kode Order</th>
                                        <th>Nama Toko</th>
                                        <th>tgl Orderan</th>
                                        <th>Jumlah Yang Dikembalikan (KG)</th>
                                        <th>Jumlah Uang Yang Dikembalikan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengembalian as $p)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $p->kode_pengembalian }}</td>
                                            <td>{{ $p->distribusi->toko->nama_toko }}</td>
                                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d F Y') }}</td>
                                            <td>{{ $p->jumlah_return }}</td>
                                            <td>Rp. {{ number_format($p->uang_return, 0, '.', '.') }}</td>
                                            </td>
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td class="text-center">
                                                    <a href="{{ route('admin.pengembalian.show', $p->id_distribusi) }}"
                                                        class="btn btn-success btn-sm mb-1">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach ($pengembalian as $p)
                        <div class="modal fade" id="deleteConfirmationModal{{ $p->id_distribusi }}" tabindex="-1"
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
                                        Apakah Anda yakin ingin menghapus oderan ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="{{ route('distribution.destroy', $p->id_distribusi) }}"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal Pengembalian -->
                    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="returnModalLabel">Tambah Pengembalian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="returnForm" action="" method="post">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="selectToko" class="form-label">Pilih Toko</label>
                                                <select class="form-control" id="selectToko" name="id_toko" required
                                                    data-live-search="true">
                                                    <option value="">Pilih Nama Toko</option>
                                                    @foreach ($distri as $distri)
                                                        <option value="{{ $distri->id_distribusi }}"
                                                            data-pemilik="{{ $distri->toko->pemilik }}"
                                                            data-alamat="{{ $distri->toko->alamat }}"
                                                            data-nomor-telp="{{ $distri->toko->nomor_tlp }}">
                                                            {{ $distri->toko->nama_toko }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tglPengembalian" class="form-label">Tanggal Pengembalian</label>
                                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                                    id="tglPengembalian" name="tgl_pengembalian">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="namaSopir" class="form-label">Nama Sopir:</label>
                                                <input type="text" class="form-control" id="namaSopir" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="platNomor" class="form-label">Nomor Plat:</label>
                                                <input type="text" class="form-control" id="platNomor" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="pemilikToko" class="form-label">Pemilik Toko</label>
                                                <input type="text" class="form-control" id="pemilikToko"
                                                    name="pemilik_toko">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="nomorToko" class="form-label">Nomor Tepl. Toko</label>
                                                <input type="text" class="form-control" id="nomorToko"
                                                    name="nomor_toko">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="alamatToko" class="form-label">Alamat Toko</label>
                                            <input type="text" class="form-control" id="alamatToko"
                                                name="alamat_toko">
                                        </div>

                                        <div id="daftarPembelianTerakhir" style="margin-top: 20px; display: none;">
                                            <hr>
                                            <h5 class="text-center">Daftar Orderan Terakhir</h5>
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Nama Beras</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah Order Terakhir</th>
                                                        <th>Barang Rusak</th>
                                                        <th>Barang Baik</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listPembelianTerakhir">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>Total Jumlah
                                                                Harga :</strong></td>
                                                        <td><span id="total-harga">0</span></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div>

                                            </div>
                                        </div>


                                        <div class="col mt-1 text-end">
                                            <button type="button" id="cariBtn" class="btn btn-primary"
                                                onclick="cariData()">Cari Order Terakhir</button>
                                            <button type="submit" id="simpanBtn" class="btn btn-primary"
                                                style="display: none;" onclick="kembalikan()">Kembalikan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $('#returnForm').submit(function(e) {
                            e.preventDefault()
                        })

                        function cariData() {
                            var selectedOption = $('#selectToko').find(':selected');
                            var idDistri = selectedOption.val();

                            // Tampilkan daftar pembelian terakhir
                            $('#daftarPembelianTerakhir').show();
                            $('#cariBtn').hide();
                            $('#simpanBtn').show();
                            $('#total-harga').text(0);

                            // Ambil dan tampilkan detail pembelian terakhir
                            $.ajax({
                                type: 'GET',
                                url: '{{ route('getPembelianTerakhir') }}', // Gantilah dengan rute yang sesuai
                                data: {
                                    idDistri: idDistri
                                },
                                success: function(response) {
                                    var listPembelianTerakhir = $('#listPembelianTerakhir');
                                    listPembelianTerakhir.empty(); // Hapus isi sebelumnya

                                    response.forEach(function(detailDistribusi) {
                                        var tableRow =
                                            `<tr class="text-center" data-id-detail=${detailDistribusi.id_detail_distribusi}>
                                                <td>${detailDistribusi.nama_beras}</td>
                                                <td class="hargapcs">${detailDistribusi.harga}</td>
                                                <td class="jumlahPcs">${detailDistribusi.jumlah_beras - detailDistribusi.jumlah_return}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-primary btn-sm" onclick="tambahBerasRusak(this)">+</button>
                                                        <input class="Rusak kuantitas" value="0" readonly>
                                                        <button type="button" class="btn btn-primary btn-sm" onclick="kurangBerasRusak(this)">-</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-primary btn-sm" onclick="tambahBerasBaik(this)">+</button>
                                                        <input class="Baik kuantitas" value="0" readonly>
                                                        <button type="button" class="btn btn-primary btn-sm" onclick="kurangBerasBaik(this)">-</button>
                                                    </div>
                                                </td>
                                                <td class="subtotal">0</td>
                                            </tr>`;

                                        // Tambahkan baris ke tabel
                                        listPembelianTerakhir.append(tableRow);
                                    });
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.error('Error:', errorThrown);
                                }
                            });
                        }

                        function tambahBerasRusak(button) {
                            const row = $(button).closest('tr');
                            const rusakInput = row.find('.Rusak');
                            const baikInput = row.find('.Baik');
                            const subtotalElement = row.find('.subtotal');
                            const jumlahPcs = parseFloat(row.find('.jumlahPcs').text());
                            const hargapcs = parseFloat(row.find('.hargapcs').text());

                            let baik = parseFloat(baikInput.val());
                            let rusak = parseFloat(rusakInput.val());
                            let kuantitas = rusak + baik;

                            if (kuantitas < jumlahPcs) {
                                rusak++;
                                rusakInput.val(rusak);

                                const subtotal = (rusak + baik) * hargapcs;
                                subtotalElement.text(subtotal);

                                updateTotalHarga();
                            }

                        }

                        function kurangBerasRusak(button) {
                            const row = $(button).closest('tr');
                            const rusakInput = row.find('.Rusak');
                            const baikInput = row.find('.Baik');
                            const subtotalElement = row.find('.subtotal');
                            const hargapcs = parseFloat(row.find('.hargapcs').text());

                            let baik = parseFloat(baikInput.val());
                            let rusak = parseInt(rusakInput.val());
                            if (rusak > 0) {
                                rusak--;
                                const subtotal = (rusak + baik) * hargapcs;

                                rusakInput.val(rusak);
                                subtotalElement.text(subtotal);

                                updateTotalHarga();
                            }
                        }

                        function tambahBerasBaik(button) {
                            const row = $(button).closest('tr');
                            const rusakInput = row.find('.Rusak');
                            const baikInput = row.find('.Baik');
                            const subtotalElement = row.find('.subtotal');
                            const jumlahPcs = parseFloat(row.find('.jumlahPcs').text());
                            const hargapcs = parseFloat(row.find('.hargapcs').text());

                            let rusak = parseFloat(rusakInput.val());
                            let baik = parseFloat(baikInput.val());
                            let kuantitas = rusak + baik;

                            if (kuantitas < jumlahPcs) {
                                baik++;
                                baikInput.val(baik);

                                const subtotal = (rusak + baik) * hargapcs;
                                subtotalElement.text(subtotal);

                                updateTotalHarga();
                            }
                        }

                        function kurangBerasBaik(button) {
                            const row = $(button).closest('tr');
                            const rusakInput = row.find('.Rusak');
                            const baikInput = row.find('.Baik');
                            const subtotalElement = row.find('.subtotal');
                            const hargapcs = parseFloat(row.find('.hargapcs').text());

                            let rusak = parseFloat(rusakInput.val());
                            let baik = parseInt(baikInput.val());
                            if (baik > 0) {
                                baik--;
                                const subtotal = (rusak + baik) * hargapcs;

                                baikInput.val(baik);
                                subtotalElement.text(subtotal);

                                updateTotalHarga();
                            }
                        }

                        function updateTotalHarga() {
                            let totalHarga = 0;

                            $('#listPembelianTerakhir tr').each(function() {
                                const hargapcs = parseFloat($(this).find('.hargapcs').text());
                                const rusak = parseInt($(this).find('.Rusak').val());
                                const baik = parseInt($(this).find('.Baik').val());
                                totalHarga += hargapcs * (rusak + baik);
                            });

                            $('#total-harga').text(totalHarga); // Ganti total-price menjadi total-harga
                        }

                        $(document).ready(function() {
                            $('#returnModal').on('shown.bs.modal', function() {
                                $('#selectToko').select2({
                                    dropdownParent: $('#returnModal')
                                });
                            });

                            const selecttoko = $('#selectToko');
                            const inputPemilik = $('#pemilikToko');
                            const inputAlamat = $('#alamatToko');
                            const intputNomorTelp = $('#nomorToko');

                            selecttoko.on('change', function() {
                                const selectedOption = $(this).find('option:selected');
                                const pemilik = selectedOption.data('pemilik');
                                const alamat = selectedOption.data('alamat');
                                const NomorTelp = selectedOption.data('nomor-telp');

                                inputPemilik.val(pemilik);
                                inputAlamat.val(alamat);
                                intputNomorTelp.val(NomorTelp);
                                $('#cariBtn').show();
                                $('#simpanBtn').hide();
                                $('#daftarPembelianTerakhir').hide();

                            });
                        });

                        function kembalikan() {
                            var pengembalian = [];
                            var selectedOption = $('#selectToko').find(':selected');
                            var idDistri = selectedOption.val();
                            var tglPengembalian = document.getElementById('tglPengembalian').value;
                            var jumlahReturn = 0;
                            var uangReturn = document.getElementById('total-harga').textContent;
                            var namaSopir = document.getElementById('namaSopir').value;
                            var platNomor = document.getElementById('platNomor').value;


                            document.querySelectorAll('#listPembelianTerakhir tr').forEach(function(row) {
                                var detailId = row.getAttribute('data-id-detail');
                                var namaBeras = row.querySelector('td:nth-child(1)').textContent;
                                var hargaBeras = parseFloat(row.querySelector('td:nth-child(2)').textContent);
                                var rusak = parseInt(row.querySelector('td:nth-child(4) input').value);
                                var baik = parseInt(row.querySelector('td:nth-child(5) input').value);
                                var beratBeras = parseFloat(namaBeras.match(/\d+/));
                                var subTotalBeras = parseFloat(row.querySelector('td:nth-child(6)').textContent);
                                var jumlahBerat = (rusak + baik) * beratBeras;
                                jumlahReturn += jumlahBerat;

                                pengembalian.push({
                                    detailId: detailId,
                                    nama: namaBeras,
                                    harga: hargaBeras,
                                    rusak: rusak,
                                    baik: baik,
                                });
                            });
                            // Kirim data ke server menggunakan AJAX
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('pengembalian.store') }}',
                                data: {
                                    idDistri: idDistri,
                                    tglPengembalian: tglPengembalian,
                                    jumlahReturn: jumlahReturn,
                                    uangReturn: uangReturn,
                                    platNomor: platNomor,
                                    namaSopir: namaSopir,
                                    pengembalian: pengembalian,
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    Swal.fire('Success', 'Pengembalian berhasil disimpan', 'success').then((res) => {
                                        location.reload()
                                    });
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.error('Error:', errorThrown);
                                }
                            });
                        }
                    </script>

                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $("#tabel-distribusi").DataTable({
                responsive: true
            });
        });
    </script>
@endsection
