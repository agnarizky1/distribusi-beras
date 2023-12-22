<!-- Modal order-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Input Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nama_toko" class="form-label">Nama Toko</label>
                        <select class="form-select" id="nama_toko" name="nama_toko" required data-live-search="true">
                            <option value="">Pilih Nama Toko</option>
                            @foreach ($tokos as $toko)
                                <option value="{{ $toko->id_toko }}" data-pemilik="{{ $toko->pemilik }}"
                                    data-alamat="{{ $toko->alamat }}" data-sales="{{ $toko->sales }}"
                                    data-nomor-telp="{{ $toko->nomor_tlp }}">
                                    {{ $toko->nama_toko }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_distribusi" class="form-label">Tanggal Order</label>
                        <input type="date" class="form-control" id="tanggal_distribusi" value="{{ date('Y-m-d') }}"
                            name="tanggal_distribusi" required>
                    </div>
                </div>
                <div id="dataToko" style="display: none;">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="pemilik">Pemilik Toko</label>
                            <input type="text" class="form-control" id="pemilik" name="pemilik" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="nomor-telp">No.Telp Toko</label>
                            <input type="text" class="form-control" id="nomor-telp" name="nomor-telp" disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="sales">Sales</label>
                            <input type="text" class="form-control" id="sales" name="sales" disabled>
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
                                    <option value="{{ $item->id }}" data-price="{{ $item->harga }}" data-satuan="">
                                        {{ $item->merk_beras }} {{ $item->ukuran_beras }} Kg
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hargakg">Harga per KG</label>
                            <input type="text" id="hargakg" class="form-control" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="hargapcs">Harga Satuan</label>
                            <input type="text" id="hargapcs" class="form-control" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jumlah">Jumlah (qty)</label>
                            <input type="number" id="jumlah" class="form-control">
                        </div>
                        <input type="hidden" id="selected-product-id">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-success btn-sm text-white rounded" id="simpanBtn"><i
                                    class="fa fa-save"></i> Tambah
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
                                    <th>Tonase</th>
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
                                            <div class="col-md-4 mt-2 mb-2">
                                                <label for="pilihanDiskon">PilihanDiskon</label>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <select class="form-select" id="pilihanDiskon" name="pilihanDiskon"
                                                    aria-label="Default select example" required>
                                                    <option value="Pilih">Pilih Diskon
                                                    </option>
                                                    <option value="Persen">Persen</option>
                                                    <option value="Harga Per-Kg">Harga Per-Kg
                                                    </option>
                                                    <option value="Nominal">Nominal</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <input type="text" class="form-control" style="min-width: 50px;"
                                                    id="diskon" name="diskon" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-end">
                                                <strong>Total Diskon:</strong> <span id="total-diskon">0</span>
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
                </div>
            </div>
            <div class="modal-footer">
                <button id="cekToko" class="btn btn-primary text-white rounded" onclick="cariData()">Cari
                    Toko</button>
                <button type="button" class="btn btn-warning rounded" data-bs-dismiss="modal">
                    <i class='nav-icon fas fa-arrow-left'></i>
                    &nbsp; Kembali
                </button>
                <button id="simpanDistribusiBtn" class="btn btn-primary rounded">
                    <i class="fa fa-save"></i> Simpan Order
                </button>
            </div>
        </div>
        <script>
            $(document).on('shown.bs.modal', function() {
                $('#nama_toko').select2({
                    dropdownParent: $('#exampleModal')
                });
            });

            function cariData() {
                var idToko = $('#nama_toko').val();

                // Lakukan panggilan AJAX ke server
                $.ajax({
                    url: '/cekTanggungan/' + idToko,
                    type: 'GET',
                    success: function(response) {
                        if (response.tanggungan) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Toko Tidak Memiliki Tanggungan',
                                timer: 1000,
                                showConfirmButton: false
                            });
                            $('#cekToko').hide();
                            $('#dataToko').show();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Toko Memiliki Tanggungan',
                                showCancelButton: true,
                                cancelButtonText: 'Batal',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#3085d6',
                                customClass: {
                                    cancelButton: 'btn btn-danger mr-2',
                                    confirmButton: 'btn btn-primary ml-2',
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#passwordModal').modal('show');
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Toko Tidak Ditemukan',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                });
            }

            const transactionRecords = document.getElementById('transaction-records');
            let totalHarga = 0;

            $('#beras').change(function() {
                var selectedOption = $(this).find('option:selected');
                var price = selectedOption.data('price');
                var beratOption = selectedOption.text().match(/\d+(\.\d+)?/);
                var berat = beratOption ? parseFloat(beratOption[0]) : 0;

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


                $('#cekToko').show();
                $('#dataToko').hide();
            });

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
                    updateTotalHarga();
                });

                $('#pilihanDiskon').change(function() {
                    $('#diskon').val('');
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

                // Pastikan bahwa atribut berat diambil dengan benar
                const beratBeras = parseFloat(berasNama.match(/\d+/));
                const tonase = berasJumlah * beratBeras;
                console.log(beratBeras, berasJumlah);


                const subtotal = berasHargaPcs * berasJumlah;
                const row = `
                                    <tr data-idberas=${berasId}>
                                        <td class="namaBeras">${berasNama}</td>
                                        <td class="hargakg">${berasHargaKg}</td>
                                        <td class="hargapcs">${berasHargaPcs}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-primary btn-sm me-2" onclick="kurangBeras(this)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input class="kuantitas form-control text-center" style="min-width: 50px;" value="${berasJumlah}" readonly="">
                                                <button class="btn btn-primary btn-sm ms-2" onclick="tambahBeras(this)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="subtotal">${subtotal}</td>
                                        <td class="tonase">${tonase} Kg</td>
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
                const tonaseElement = row.querySelector('.tonase'); // Mengambil elemen subtotal
                const hargapcs = parseFloat(row.querySelector('.hargapcs').textContent);
                const berasNama = row.querySelector('.namaBeras').textContent;
                const berat = parseFloat(berasNama.match(/\d+/));

                let kuantitas = parseFloat(kuantitasInput.value);
                kuantitas++;
                kuantitasInput.value = kuantitas; // Mengubah nilai input


                const subtotal = kuantitas * hargapcs;
                const tonase = kuantitas * berat;
                subtotalElement.textContent = subtotal; // Memperbarui subtotal
                tonaseElement.textContent = tonase + ' KG';

                updateTotalHarga()
            }

            function kurangBeras(button) {
                const row = button.closest('tr');
                const kuantitasInput = row.querySelector('.kuantitas'); // Mengambil input kuantitas
                const subtotalElement = row.querySelector('.subtotal'); // Mengambil elemen subtotal
                const tonaseElement = row.querySelector('.tonase'); // Mengambil elemen subtotal
                const berasNama = row.querySelector('.namaBeras').textContent;
                const berat = parseFloat(berasNama.match(/\d+/));

                let kuantitas = parseInt(kuantitasInput.value);
                if (kuantitas > 0) {
                    kuantitas--;
                    const hargapcs = parseFloat(row.querySelector('.hargapcs').textContent);
                    const subtotal = kuantitas * hargapcs;
                    const tonase = kuantitas * berat;

                    kuantitasInput.value = kuantitas; // Mengubah nilai input
                    subtotalElement.textContent = subtotal;
                    tonaseElement.textContent = tonase + ' KG';

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

                var diskon = $('#diskon').val();

                // Pemeriksaan jika nilai diskon tidak valid
                if (isNaN(parseFloat(diskon))) {
                    diskon = 0;
                }

                const diskonInput = parseFloat(diskon);
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
                        tglDistri: tglDistribusi,
                        totalHarga: totalHarga,
                        jumlahDistribusi: jumlahDistribusi,
                        metodeBayar: pembayaran,
                        Distribusi: Distribusi,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Distribusi berhasil disimpan
                        Swal.fire('Success', 'Orderan berhasil disimpan', 'success').then((res) => {
                            location.reload()
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
