@extends('layouts.app')

@section('content')
<div class="page-heading">
    <h3>Tambah Data Distribusi</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nama_toko">Nama Toko</label>
                            <select class="form-select" id="nama_toko" name="nama_toko" required>
                                <option value="">Pilih Nama Toko</option>
                                @foreach ($tokos as $toko)
                                    <option value="{{ $toko->id_toko }}">{{ $toko->nama_toko }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_distribusi">Tanggal Distribusi</label>
                            <input type="date" class="form-control" id="tanggal_distribusi" value="{{ date('Y-m-d') }}" name="tanggal_distribusi" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nama_sopir">Nama Sopir</label>
                            <input type="text" class="form-control" id="nama_sopir" name="nama_sopir" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plat_no">Plat No.</label>
                            <input type="text" class="form-control" id="plat_no" name="plat_no" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="beras">Nama Beras</label>
                            <select name="beras" id="beras" class="form-control select2">
                                <option value="0">Pilih Beras</option>
                                @foreach ($beras as $item)
                                <option value="{{ $item->id_beras }}" data-grade="{{ $item->grade_beras }}" data-jenis="{{ $item->jenis_beras }}" data-price="{{ $item->harga }}">{{ $item->nama_beras }} {{ $item->berat }} Kg</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="harga">Harga Satuan</label>
                            <input type="text" id="harga" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" id="jumlah" class="form-control">
                        </div>
                        <input type="hidden" id="selected-product-id">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-success btn-sm text-white rounded" id="simpanBtn"><i class="fa fa-save"></i> Tambah Barang</button>
                        </div>
                    </div>

                    <hr>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Beras</th>
                                    <th>Jenis Beras</th>
                                    <th>Grade Beras</th>
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
                                    <td colspan="6" class="text-end"><strong>Total Jumlah Harga :</strong></td>
                                    <td colspan="2"><span id="total-price">0</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-end">
                        <button id="simpanDistribusiBtn" class="btn btn-sm btn-primary rounded"><i class="fa fa-save"></i> Simpan Distribusi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>

    const selectberas = document.getElementById('beras');
    const inputHarga = document.getElementById('harga');

    const transactionRecords = document.getElementById('transaction-records');
    let totalHarga = 0;

    selectberas.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const grade = selectedOption.getAttribute('data-grade');
        const jenis = selectedOption.getAttribute('data-jenis');
        inputHarga.value = price;
    });

    $(document).ready(function() {
        // Event listener untuk tombol "Tambah Barang"
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
                alert('Beras dengan nama yang sama sudah ada dalam daftar Distribusi.');
            } else {
                tambahBerasKeTabel();
            }
        });
    });

    function tambahBerasKeTabel() {
        const berasSelect = $('#beras');
        const selectedOption = berasSelect.find('option:selected');
        const berasId = selectedOption.val();
        const berasNama = selectedOption.text();
        const berasHarga = parseFloat(selectedOption.data('price'));
        const berasJumlah = parseInt($('#jumlah').val());
        const berasGrade = selectedOption.data('grade');
        const berasJenis = selectedOption.data('jenis');

        if (!berasNama || isNaN(berasHarga) || isNaN(berasJumlah)) {
            alert('Silakan lengkapi semua field sebelum menambahkan beras.');
            return;
        }

        const subtotal = berasHarga * berasJumlah;
        const row = `
        <tr data-idberas=${berasId}>
            <td>${berasNama}</td>
            <td class="jenis">${berasJenis}</td>
            <td class="grade">${berasGrade}</td>
            <td class="harga">${berasHarga}</td>
            <td>
                <div class="input-group">
                    <button class="btn btn-primary btn-sm" onclick="tambahBeras(this)">+</button>
                    <input class="kuantitas" value="${berasJumlah}">
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
        $('#harga').val('');
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
        const harga = parseFloat(row.querySelector('.harga').textContent);
        
        let kuantitas = parseFloat(kuantitasInput.value);
        kuantitas++;
        kuantitasInput.value = kuantitas; // Mengubah nilai input
        
        const subtotal = kuantitas * harga;
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
            const harga = parseFloat(row.querySelector('.harga').textContent);
            const subtotal = kuantitas * harga;

            kuantitasInput.value = kuantitas; // Mengubah nilai input
            subtotalElement.textContent = subtotal;

            updateTotalHarga()
        }
    }

    function updateTotalHarga() {
        let totalHarga = 0;

        document.querySelectorAll('#transaction-records tr').forEach(function(row) {
            const harga = parseFloat(row.querySelector('.harga').textContent);
            const kuantitas = parseInt(row.querySelector('.kuantitas').value);
            totalHarga += harga * kuantitas;
        });

        document.getElementById('total-price').textContent = totalHarga;
    }

    document.getElementById('simpanDistribusiBtn').addEventListener('click', function () {
        var Distribusi = [];
        var namaToko = document.getElementById('nama_toko').value;
        var tglDistribusi = document.getElementById('tanggal_distribusi').value;
        var namaSopir = document.getElementById('nama_sopir').value;
        var PlatNo = document.getElementById('plat_no').value;
        var totalHarga = document.getElementById('total-price').textContent;
        var jumlahDistribusi = 0;

        document.querySelectorAll('#transaction-records tr').forEach(function (row) {
            var berasId = row.getAttribute('data-idberas');
            var namaBeras = row.querySelector('td:nth-child(1)').textContent;
            var jenisBeras = row.querySelector('td:nth-child(2)').textContent;
            var gradeBeras = row.querySelector('td:nth-child(3)').textContent;
            var hargaBeras = parseFloat(row.querySelector('td:nth-child(4)').textContent); 
            var subtotal = parseInt(row.querySelector('td:nth-child(6)').textContent, 10);
            var jumlah = subtotal/hargaBeras;
            var beratBeras = parseFloat(namaBeras.match(/\d+/));
            var subTotalBeras = jumlah*beratBeras;
            jumlahDistribusi += subTotalBeras;

            Distribusi.push({
                idBeras: berasId,
                nama: namaBeras,
                jenis: jenisBeras,
                grade: gradeBeras,
                harga: hargaBeras,
                jumlah: jumlah,
            });
        });
        console.table(Distribusi)

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '{{ url("/admin/distribution/store") }}', // Ganti dengan URL yang sesuai di aplikasi Anda
            data: {
                namaToko: namaToko,
                namaSopir: namaSopir,
                PlatNo: PlatNo,
                tglDistri: tglDistribusi,
                totalHarga: totalHarga,
                jumlahDistribusi: jumlahDistribusi,
                Distribusi: Distribusi,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                // Distribusi berhasil disimpan
                alert('Distribusi berhasil disimpan.');
                window.location.href = '{{ route("distribution") }}';
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error:', errorThrown);
                alert('Distribusi gagal. Silakan coba lagi.');
            }
        });
    });


</script>
@endsection