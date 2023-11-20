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
    </style>
    <div class="page-heading">
        <h3>Data Order</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row g-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                                        class="btn btn-primary">
                                        <i class="fa-solid fa-folder-plus"></i> Tambah Order</a>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a data-bs-toggle="modal" data-bs-target="#pengirimanModal" type="button"
                                        class="btn btn-primary">
                                        <i class="fa-solid fa-paper-plane"></i> Kirim Orderan</a>
                                    <a href="{{ route('admin.DeliveryOrder.index') }}" type="button"
                                        class="btn btn-success">
                                        <i class="fa-solid fa-file-lines"></i> Riwayat Orderan</a>
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
                                        <th>Total Berat(Kg)</th>
                                        <th>Total Harga</th>
                                        <th>Status Pengiriman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distri as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_distribusi }}</td>
                                            <td>{{ $d->nama_toko }}</td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d F Y') }}
                                            </td>
                                            <td class="text-center">{{ $d->jumlah_distribusi }} Kg</td>
                                            <td>Rp. {{ number_format($d->total_harga, 0, '.', '.') }}
                                                <!-- <br>
                                                                                                                                @if ($pembayaranTotals[$d->id_distribusi] >= $d->total_harga)
    <span class="text-success">Lunas</span>
@else
    <span class="text-danger">Sisa Bayar: Rp.
                                                                                                                                        {{ number_format($d->total_harga - $pembayaranTotals[$d->id_distribusi], 0, '.', '.') }}</span>
    @endif -->
                                            </td>
                                            @if ($d->status == 'Terkirim')
                                                <td class="text-success text-center">{{ $d->status }}</td>
                                            @endif
                                            @if ($d->status == 'Pending')
                                                <td class="text-danger text-center">{{ $d->status }}</td>
                                            @endif
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td class="text-center">
                                                    <a href="{{ route('distribution.show', $d->id_distribusi) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $d->id_distribusi }}">
                                                        <i class="fa fa-trash-can"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @foreach ($distri as $d)
                        <div class="modal fade" id="deleteConfirmationModal{{ $d->id_distribusi }}" tabindex="-1"
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
                                        <a href="{{ route('distribution.destroy', $d->id_distribusi) }}"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Input order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="page-content">
                                <section class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <label for="nama_toko">Nama Toko</label>
                                                        <br>
                                                        <select class="form-select" id="nama_toko" name="nama_toko"
                                                            required data-live-search="true">
                                                            <option value="">Pilih Nama Toko</option>
                                                            @foreach ($tokos as $toko)
                                                                <option value="{{ $toko->id_toko }}"
                                                                    data-pemilik="{{ $toko->pemilik }}"
                                                                    data-alamat="{{ $toko->alamat }}"
                                                                    data-sales="{{ $toko->sales }}"
                                                                    data-nomor-telp="{{ $toko->nomor_tlp }}">
                                                                    {{ $toko->nama_toko }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal_distribusi">Tanggal Order</label>
                                                        <input type="date" class="form-control"
                                                            id="tanggal_distribusi" value="{{ date('Y-m-d') }}"
                                                            name="tanggal_distribusi" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <label for="pemilik">Pemilik Toko</label>
                                                        <input type="text" class="form-control" id="pemilik"
                                                            name="pemilik" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="alamat">Alamat</label>
                                                        <input type="text" class="form-control" id="alamat"
                                                            name="alamat" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label for="nomor-telp">No.Telp Toko</label>
                                                        <input type="text" class="form-control" id="nomor-telp"
                                                            name="nomor-telp" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="sales">Sales</label>
                                                        <input type="text" class="form-control" id="sales"
                                                            name="sales" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pembayaran">Pembayaran</label>
                                                        <select class="form-select" id="pembayaran" name="pembayaran"
                                                            aria-label="Default select example" required>
                                                            <option value="Cash">Cash</option>
                                                            <option value="Tempo">Tempo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="beras">Beras</label>
                                                        <select name="beras" id="beras" class="form-control">
                                                            <option value="0">Pilih Beras</option>
                                                            @foreach ($beras as $item)
                                                                <option value="{{ $item->id }}"
                                                                    data-price="{{ $item->harga }}" data-satuan="">
                                                                    {{ $item->merk_beras }} {{ $item->ukuran_beras }} Kg
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hargakg">Harga per KG</label>
                                                        <input type="text" id="hargakg" class="form-control"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hargapcs">Harga Satuan</label>
                                                        <input type="text" id="hargapcs" class="form-control"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="jumlah">Jumlah (qty)</label>
                                                        <input type="number" id="jumlah" class="form-control">
                                                    </div>
                                                    <input type="hidden" id="selected-product-id">
                                                    <div class="col-md-12 text-end">
                                                        <button class="btn btn-success btn-sm text-white rounded"
                                                            id="simpanBtn"><i class="fa fa-save"></i> Tambah
                                                            Barang</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Beras</th>
                                                                <th>Harga Per KG</th>
                                                                <th>Harga Satuan</th>
                                                                <th>Jumlah</th>
                                                                <th>Subtotal</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="transaction-records">
                                                            <!-- Data Distribusi akan ditampilkan di sini -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="row">
                                                                        <div class="col-md-4 mt-2">
                                                                            <label for="pilihanDiskon">Pilihan
                                                                                Diskon</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <select class="form-select" id="pilihanDiskon"
                                                                                name="pilihanDiskon"
                                                                                aria-label="Default select example"
                                                                                required>
                                                                                <option value="Pilih">Pilih Diskon
                                                                                </option>
                                                                                <option value="Persen">Persen</option>
                                                                                <option value="Harga Per-Kg">Harga Per-Kg
                                                                                </option>
                                                                                <option value="Nominal">Nominal</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" class="form-control"
                                                                                id="diskon" name="diskon" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-end">
                                                                            <strong>Total Diskon:</strong> <span
                                                                                id="total-diskon">0</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td colspan="2" class="text-end">
                                                                    <strong>Total Jumlah Harga :</strong>
                                                                </td>
                                                                <td colspan="2">
                                                                    <span id="total-price">0</span>
                                                                </td>
                                                            </tr>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-warning rounded"
                                                        data-bs-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i>
                                                        &nbsp;
                                                        Kembali</button>
                                                    <button id="simpanDistribusiBtn" class="btn btn-primary rounded"><i
                                                            class="fa fa-save"></i>
                                                        Simpan Order</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <script>
                                $(document).on('shown.bs.modal', function() {
                                    $('#nama_toko').select2({
                                        dropdownParent: $('#exampleModal')
                                    });
                                });

                                const transactionRecords = document.getElementById('transaction-records');
                                let totalHarga = 0;

                                $('#beras').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var price = selectedOption.data('price');
                                    var berat = parseFloat(selectedOption.text().match(/\d+/)[0]);

                                    $('#hargakg').val(price);
                                    $('#hargapcs').val(price * berat);

                                    selectedOption.data('satuan', price * berat);
                                });

                                const selecttoko = $('#nama_toko');
                                const inputPemilik = $('#pemilik');
                                const inputAlamat = $('#alamat');
                                const intputNomorTelp = $('#nomor-telp');
                                const intputSales = $('#sales');

                                selecttoko.on('change', function() {
                                    const selectedOption = $(this).find('option:selected');
                                    const pemilik = selectedOption.data('pemilik');
                                    const alamat = selectedOption.data('alamat');
                                    const NomorTelp = selectedOption.data('nomor-telp');
                                    const sales = selectedOption.data('sales');

                                    inputPemilik.val(pemilik);
                                    inputAlamat.val(alamat);
                                    intputNomorTelp.val(NomorTelp);
                                    intputSales.val(sales);
                                });

                                const selectDiskon = $('#pilihandiskon');
                                const inputDiskon = $('#diskon');
                                const totalSebelumDiskon = parseFloat($('#total-price').text());

                                selectDiskon.on('change', function() {
                                    const selectedOption = $(this).val();
                                    let totalSetelahDiskon = 0;

                                    switch (selectedOption) {
                                        case 'Persen':
                                            inputDiskon.on('input', function() {
                                                const diskonPersen = parseFloat(inputDiskon.val());
                                                const diskonValuePersen = (diskonPersen / 100) *
                                                    totalSebelumDiskon;
                                                totalSetelahDiskon = totalSebelumDiskon - diskonValuePersen;
                                                $('#total-price').text(totalSetelahDiskon);
                                            });
                                            break;
                                        case 'Harga Per-KG':
                                            // Logika untuk opsi ini
                                            break;

                                        case 'Nominal':
                                            inputDiskon.on('input', function() {
                                                const diskonNominal = parseFloat(inputDiskon.val());
                                                totalSetelahDiskon = totalSebelumDiskon - diskonNominal;
                                                $('#total-price').text(totalSetelahDiskon);
                                            });
                                            break;
                                    }
                                });
                                inputDiskon.off('input');

                                $(document).ready(function() {

                                    $('#simpanBtn').click(function() {
                                        const berasSelect = $('#beras');
                                        const selectedOption = berasSelect.find('option:selected');
                                        const berasNama = selectedOption.text();
                                        let isBerasExists = false;

                                        // Cek apakah beras dengan nama yang sama sudah ada di daftar Distribusi
                                        $('#transaction-records tr').each(function() {
                                            const namaBeras = $(this).find('td:first-child').text();
                                            if (namaBeras === berasNama) {
                                                isBerasExists = true;
                                                return false; // Keluar dari loop jika beras sudah ada
                                            }
                                        });

                                        if (isBerasExists) {
                                            alert(
                                                'Beras dengan nama yang sama sudah ada dalam daftar Distribusi.'
                                            );
                                        } else {
                                            tambahBerasKeTabel();
                                        }
                                    });

                                    $('#diskon').on('input', function() {
                                        const diskonInput = $(this).val();
                                        const diskonValue = !isNaN(parseFloat(diskonInput)) && isFinite(
                                            diskonInput) ? parseFloat(diskonInput) : 0;
                                        $(this).val(diskonValue);
                                        updateTotalHarga();
                                    });
                                });

                                function tambahBerasKeTabel() {
                                    const berasSelect = $('#beras');
                                    const selectedOption = berasSelect.find('option:selected');
                                    const berasId = selectedOption.val();
                                    const berasNama = selectedOption.text();
                                    const berasHargaKg = parseFloat(selectedOption.data('price'));
                                    const berasHargaPcs = parseFloat(selectedOption.data('satuan'));
                                    const berasJumlah = parseInt($('#jumlah').val());

                                    if (!berasNama || isNaN(berasJumlah)) {
                                        alert('Silakan lengkapi semua field sebelum menambahkan beras.');
                                        return;
                                    }

                                    const subtotal = berasHargaPcs * berasJumlah;
                                    const row = `
                                    <tr data-idberas=${berasId}>
                                        <td class="namaBeras">${berasNama}</td>
                                        <td class="hargakg">${berasHargaKg}</td>
                                        <td class="hargapcs">${berasHargaPcs}</td>
                                        <td>
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-sm" onclick="tambahBeras(this)">+</button>
                                                <input class="kuantitas" value="${berasJumlah}" readonly>
                                                <button class="btn btn-primary btn-sm" onclick="kurangBeras(this)">-</button>
                                            </div>
                                        </td>
                                        <td class="subtotal">${subtotal}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="hapusBeras(this)">Hapus</button>

                                        </td>
                                    </tr>
                                    `;

                                    $('#transaction-records').append(row);

                                    let totalHarga = parseFloat($('#total-price').text());
                                    totalHarga += subtotal;
                                    $('#total-price').text(totalHarga);

                                    berasSelect.val('0');
                                    $('#hargakg').val('');
                                    $('#hargapcs').val('');
                                    $('#jumlah').val('');
                                    berasSelect.focus();
                                }

                                function hapusBeras(button) {
                                    const row = button.closest('tr');
                                    row.remove();
                                    updateTotalHarga()
                                }

                                function tambahBeras(button) {
                                    const row = button.closest('tr');
                                    const kuantitasInput = row.querySelector('.kuantitas'); // Mengambil input kuantitas
                                    const subtotalElement = row.querySelector('.subtotal'); // Mengambil elemen subtotal
                                    const hargapcs = parseFloat(row.querySelector('.hargapcs').textContent);

                                    let kuantitas = parseFloat(kuantitasInput.value);
                                    kuantitas++;
                                    kuantitasInput.value = kuantitas; // Mengubah nilai input

                                    const subtotal = kuantitas * hargapcs;
                                    subtotalElement.textContent = subtotal; // Memperbarui subtotal

                                    updateTotalHarga()
                                }

                                function kurangBeras(button) {
                                    const row = button.closest('tr');
                                    const kuantitasInput = row.querySelector('.kuantitas'); // Mengambil input kuantitas
                                    const subtotalElement = row.querySelector('.subtotal'); // Mengambil elemen subtotal

                                    let kuantitas = parseInt(kuantitasInput.value);
                                    if (kuantitas > 1) {
                                        kuantitas--;
                                        const hargapcs = parseFloat(row.querySelector('.hargapcs').textContent);
                                        const subtotal = kuantitas * hargapcs;

                                        kuantitasInput.value = kuantitas; // Mengubah nilai input
                                        subtotalElement.textContent = subtotal;

                                        updateTotalHarga()
                                    }
                                }

                                function updateTotalHarga() {
                                    let totalHarga = 0;
                                    let totalDiskon = 0;
                                    let totalBerat = 0;

                                    document.querySelectorAll('#transaction-records tr').forEach(function(row) {
                                        const namaBeras = row.querySelector('.namaBeras').textContent;
                                        const beratBeras = parseFloat(namaBeras.match(/\d+/));
                                        const hargapcs = parseFloat(row.querySelector('.hargapcs').textContent);
                                        const kuantitas = parseInt(row.querySelector('.kuantitas').value);
                                        totalHarga += hargapcs * kuantitas;
                                        totalBerat += kuantitas * beratBeras;
                                    });

                                    const diskonInput = parseFloat($('#diskon').val());
                                    const selectedDiskonOption = $('#pilihanDiskon').val();

                                    switch (selectedDiskonOption) {
                                        case 'Persen':
                                            totalDiskon = (diskonInput / 100) * totalHarga;
                                            break;
                                        case 'Harga Per-Kg':
                                            totalDiskon = totalBerat * diskonInput;
                                            break;
                                        case 'Nominal':
                                            totalDiskon = diskonInput;
                                            break;
                                    }

                                    $('#total-diskon').text(totalDiskon);

                                    const totalHargaSetelahDiskon = totalHarga - totalDiskon;

                                    $('#total-price').text(totalHargaSetelahDiskon);
                                }

                                document.getElementById('simpanDistribusiBtn').addEventListener('click', function() {
                                    var Distribusi = [];
                                    var namaToko = document.getElementById('nama_toko').value;
                                    var tglDistribusi = document.getElementById('tanggal_distribusi').value;
                                    var sales = document.getElementById('sales').value;
                                    var totalHarga = document.getElementById('total-price').textContent;
                                    var pembayaran = document.getElementById('pembayaran').value;
                                    var jumlahDistribusi = 0;

                                    document.querySelectorAll('#transaction-records tr').forEach(function(row) {
                                        var berasId = row.getAttribute('data-idberas');
                                        var namaBeras = row.querySelector('td:nth-child(1)').textContent;
                                        var hargaBeras = parseFloat(row.querySelector('td:nth-child(3)')
                                            .textContent);
                                        var subtotal = parseInt(row.querySelector('td:nth-child(5)')
                                            .textContent, 10);
                                        var jumlah = subtotal / hargaBeras;
                                        var beratBeras = parseFloat(namaBeras.match(/\d+/));
                                        var subTotalBeras = jumlah * beratBeras;
                                        jumlahDistribusi += subTotalBeras;

                                        Distribusi.push({
                                            idBeras: berasId,
                                            nama: namaBeras,
                                            harga: hargaBeras,
                                            jumlah: jumlah,
                                        });
                                    });
                                    console.table(Distribusi)
                                    console.log(namaToko, tglDistribusi, totalHarga, jumlahDistribusi, pembayaran);

                                    // Kirim data ke server menggunakan AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('admin/distribution/store') }}', // Ganti dengan URL yang sesuai di aplikasi Anda
                                        data: {
                                            namaToko: namaToko,
                                            sales: sales,
                                            tglDistri: tglDistribusi,
                                            totalHarga: totalHarga,
                                            jumlahDistribusi: jumlahDistribusi,
                                            metodeBayar: pembayaran,
                                            Distribusi: Distribusi,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            // Distribusi berhasil disimpan
                                            Swal.fire('Success', 'Orderan berhasil disimpan', 'success')
                                                .then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '{{ route('distribution') }}';
                                                    }
                                                });
                                        },
                                        error: function(xhr, textStatus, errorThrown) {
                                            console.error('Error:', errorThrown);
                                            Swal.fire('Error', 'Distribusi Gagal', 'error');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="pengirimanModal" tabindex="-1" aria-labelledby="pengirimanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengirimanModalLabel">Kirim Orderan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pengirimanForm">
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
                        <div class="mb-3">
                            <h6>Daftar Order Pending:</h6>
                            <div class="table-responsive">
                                <table id="tabel-distribusi" class="table table-striped table-bordered">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                            <th>Checklist</th>
                                            <th>Kode Order</th>
                                            <th>Nama Toko</th>
                                            <th>Tanggal Orderan</th>
                                            <th>Total Berat(Kg)</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($distri as $d)
                                            @if ($d->status == 'Pending')
                                                <tr>
                                                    <td class="text-center">
                                                        <div
                                                            class="form-check d-flex justify-content-center align-items-center h-100">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $d->id_distribusi }}"
                                                                id="order{{ $d->id_distribusi }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ $d->kode_distribusi }}</td>
                                                    <td>{{ $d->nama_toko }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d F Y') }}
                                                    </td>
                                                    <td class="text-center">{{ $d->jumlah_distribusi }} Kg</td>
                                                    <td>Rp. {{ number_format($d->total_harga, 0, '.', '.') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" onclick="kirimOrder()">Kirim</button>
                        </div>
                    </form>
                </div>

                <script>
                    function kirimOrder() {
                        const namaSopir = document.getElementById('namaSopir').value;
                        const platNomor = document.getElementById('platNomor').value;

                        // Mendapatkan daftar order yang dicentang
                        const orders = [];
                        document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                            orders.push(checkbox.value);
                        });

                        console.table(orders);
                        console.log(namaSopir, platNomor, '{{ csrf_token() }}')

                        // Kirim data ke server atau lakukan operasi lain sesuai kebutuhan
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('admin/DeliveryOrder/store') }}',
                            data: {
                                namaSopir: namaSopir,
                                platNomor: platNomor,
                                orders: orders,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Success', 'Orderan Dikirim', 'success')
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '{{ route('distribution') }}';
                                        }
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
    </div>
    <script>
        $(document).ready(function() {
            $("#tabel-distribusi").DataTable({
                responsive: true
            });
        });
    </script>
@endsection
