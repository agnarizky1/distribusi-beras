@extends('layouts.app')
@section('link')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0/dist/css/bootstrap-select.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="page-heading">
        <h3>Data Distribusi</h3>
    </div>
    <div class="page-content">
        <section class="row">

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row g-3">
                        <div class="col-md-4">
                            <a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">
                                <i class="fa-solid fa-folder-plus"></i> Tambah Data
                                Distribusi</a>
                        </div>
                        {{-- <div class="col-md-3">
                            <form action="/post">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="search" placeholder="search.."
                                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                </form>
            </div> --}}
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
                            <table id="tabel-distribusi" class="table table-striped table-bordered " style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Kode Distribusi</th>
                                        <th>Nama Toko</th>
                                        <th>Nama Sopir</th>
                                        <th>Plat No.</th>
                                        <th>tgl Distribusi</th>
                                        <th>Total Berat(Kg)</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distri as $d)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_distribusi }}</td>
                                            <td>{{ $d->nama_toko }}</td>
                                            <td>{{ $d->nama_sopir }}</td>
                                            <td>{{ $d->plat_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d F Y') }}
                                            </td>
                                            <td class="text-center">{{ $d->jumlah_distribusi }} Kg</td>
                                            <td>Rp. {{ number_format($d->total_harga, 0, '.', '.') }}
                                                <br>
                                                @if ($pembayaranTotals[$d->id_distribusi] >= $d->total_harga)
                                                    <span class="text-success">Lunas</span>
                                                @else
                                                    <span class="text-danger">Sisa Bayar:
                                                        {{ $d->total_harga - $pembayaranTotals[$d->id_distribusi] }}</span>
                                                @endif
                                            </td>
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td>
                                                    <a href="{{ route('distribution.show', $d->id_distribusi) }}"
                                                        class="btn btn-warning btn-sm mb-1">
                                                        <i class="fa fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm mb-1" data-toggle="modal"
                                                        data-target="#deleteConfirmationModal{{ $d->id_distribusi }}">
                                                        <i class="fa fa-trash-can"></i></a>
                                                    <a href="#" class="btn btn-primary btn-sm mb-1"><i
                                                            class="fa fa-edit"></i>
                                                    </a>
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
                                        Apakah Anda yakin ingin menghapus distribusi ini?
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

        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Input Distribusi</h1>
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
                                                        <select class="form-select" id="nama_toko" name="nama_toko" required
                                                            data-live-search="true">
                                                            <option value="">Pilih Nama Toko</option>
                                                            @foreach ($tokos as $toko)
                                                                <option value="{{ $toko->id_toko }}">
                                                                    {{ $toko->nama_toko }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal_distribusi">Tanggal Distribusi</label>
                                                        <input type="date" class="form-control"
                                                            id="tanggal_distribusi" value="{{ date('Y-m-d') }}"
                                                            name="tanggal_distribusi" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <label for="nama_sopir">Nama Sopir</label>
                                                        <input type="text" class="form-control" id="nama_sopir"
                                                            name="nama_sopir" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="plat_no">Plat No.</label>
                                                        <input type="text" class="form-control" id="plat_no"
                                                            name="plat_no" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="beras">Beras</label>
                                                        <select name="beras" id="beras"
                                                            class="form-control select2">
                                                            <option value="0">Pilih Beras</option>
                                                            @foreach ($beras as $item)
                                                                <option value="{{ $item->id }}"
                                                                    data-grade="{{ $item->grade_beras }}"
                                                                    data-jenis="{{ $item->jenis_beras }}"
                                                                    data-price="{{ $item->harga }}">
                                                                    {{ $item->merk_beras }} {{ $item->ukuran_beras }} Kg
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="harga">Harga Satuan</label>
                                                        <input type="text" id="harga" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
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
                                                                <td colspan="6" class="text-end"><strong>Total Jumlah
                                                                        Harga :</strong></td>
                                                                <td colspan="2"><span id="total-price">0</span></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-secondary rounded"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button id="simpanDistribusiBtn" class="btn btn-primary rounded"><i
                                                            class="fa fa-save"></i>
                                                        Simpan Distribusi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>


                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc0/dist/js/select2.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0/dist/js/bootstrap-select.min.js"></script>
                            <script>
                                const selectberas = document.getElementById('beras');
                                const inputHarga = document.getElementById('harga');

                                const transactionRecords = document.getElementById('transaction-records');
                                let totalHarga = 0;

                                selectberas.addEventListener('change', function() {
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

                                document.getElementById('simpanDistribusiBtn').addEventListener('click', function() {
                                    var Distribusi = [];
                                    var namaToko = document.getElementById('nama_toko').value;
                                    var tglDistribusi = document.getElementById('tanggal_distribusi').value;
                                    var namaSopir = document.getElementById('nama_sopir').value;
                                    var PlatNo = document.getElementById('plat_no').value;
                                    var totalHarga = document.getElementById('total-price').textContent;
                                    var jumlahDistribusi = 0;

                                    document.querySelectorAll('#transaction-records tr').forEach(function(row) {
                                        var berasId = row.getAttribute('data-idberas');
                                        var namaBeras = row.querySelector('td:nth-child(1)').textContent;
                                        var jenisBeras = row.querySelector('td:nth-child(2)').textContent;
                                        var gradeBeras = row.querySelector('td:nth-child(3)').textContent;
                                        var hargaBeras = parseFloat(row.querySelector('td:nth-child(4)').textContent);
                                        var subtotal = parseInt(row.querySelector('td:nth-child(6)').textContent, 10);
                                        var jumlah = subtotal / hargaBeras;
                                        var beratBeras = parseFloat(namaBeras.match(/\d+/));
                                        var subTotalBeras = jumlah * beratBeras;
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
                                        url: '{{ url('/admin/distribution/store') }}', // Ganti dengan URL yang sesuai di aplikasi Anda
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
                                        success: function(response) {
                                            // Distribusi berhasil disimpan
                                            Swal.fire('Success', 'Distribusi berhasil disimpan', 'success')
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
                            <script>
                                $(document).ready(function() {
                                    $('#nama_toko').selectpicker();
                                });
                            </script>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $("#tabel-distribusi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
