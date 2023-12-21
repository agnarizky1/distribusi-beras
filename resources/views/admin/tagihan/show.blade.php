@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-md-6">
                <h3>Detail Tagihan</h3>
            </div>

        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Nota Pembayaran: {{ $distribusi->kode_distribusi }}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko: {{ $toko->nama_toko }}</p>
                                <p>Jumlah Keseluruhan Distribusi: {{ $distribusi->jumlah_distribusi }} KG</p>
                                <p>Total Harga Pembelian: Rp. {{ number_format($distribusi->total_harga, 0, '.', '.') }}</p>

                                @if ($distribusi->uang_return != 0)
                                    <p class="text-danger">Uang Return Saat Pengiriman: Rp.
                                        {{ number_format($distribusi->uang_return, 0, '.', '.') }}</p>
                                @endif

                                @if ($distribusi->potongan_harga != 0)
                                    <p class="text-danger">Potongan Harga Dari Return: Rp.
                                        {{ number_format($distribusi->potongan_harga, 0, '.', '.') }}</p>
                                @endif

                                @if ($distribusi->potongan_harga != 0 || $distribusi->uang_return != 0)
                                    <p>Total Yang Harus Dibayarkan: Rp.
                                        {{ number_format($distribusi->total_harga - $distribusi->uang_return - $distribusi->potongan_harga, 0, '.', '.') }}
                                    </p>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Kirim Beras : {{ $distribusi->tanggal_distribusi }}</p>
                                <p>Tanggal Tengat Waktu: {{ $pembayaran->tanggal_tengat_pembayaran }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Bayar</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Jumlah yang dibayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalPembayaran = 0;
                                            $yangDibayarkan = $distribusi->total_harga - $distribusi->uang_return - $distribusi->potongan_harga;
                                        @endphp
                                        @foreach ($bayar as $pembayaran)
                                            <tr>
                                                @if ($pembayaran->tanggal_pembayaran != null)
                                                    <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                                                    <td>{{ $pembayaran->metode_pembayaran }}</td>
                                                    <td>Rp.
                                                        {{ number_format($pembayaran->jumlah_pembayaran, 0, '.', '.') }}
                                                    </td>
                                                    @php
                                                        $totalPembayaran += $pembayaran->jumlah_pembayaran;
                                                    @endphp
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"><strong>Total yang sudah terbayarkan</strong></td>
                                            <td>Rp.
                                                {{ number_format($totalPembayaran, 0, '.', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @php
                                    $sisaPembayaran = $yangDibayarkan - $totalPembayaran;
                                @endphp
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                @if ($sisaPembayaran > 0)
                                    <p>Sisa yang harus dibayar: Rp.
                                        {{ number_format($sisaPembayaran, 0, '.', '.') }}</p>
                                @else
                                    <p id="status">Status: Lunas</p>
                                @endif
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('admin.tagihan') }}" type="button" class="btn btn-warning btn-sm"><i
                                        class='nav-icon fas fa-arrow-left'></i> &nbsp;
                                    Kembali</a>
                                <a id="bayarButton" href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#pembayaranModal">Bayar</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pembayaranModal" tabindex="-1" role="dialog"
                        aria-labelledby="pembayaranModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pembayaranModalLabel">Form Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form id="formPembayaran">
                                        <div class="form-group">
                                            <input type="hidden" id="id_distribusi" name="id_distribusi"
                                                value="{{ $distribusi->id_distribusi }}">
                                            <label for="tanggalPembayaran">Tanggal Pembayaran:</label>
                                            <input type="date" class="form-control" id="tanggalPembayaran"
                                                name="tanggalPembayaran" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahPembayaran">Jumlah Pembayaran:</label>
                                            <input type="number" class="form-control" id="jumlahPembayaran"
                                                name="jumlahPembayaran" required>
                                            <small>Sisa yang harus dibayar: Rp.
                                                {{ number_format($sisaPembayaran, 0, '.', '.') }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="metodePembayaran">Metode Pembayaran:</label>
                                            <select class="form-control" id="metodePembayaran" name="metodePembayaran"
                                                required>
                                                <option value="tunai">Tunai</option>
                                                <option value="transfer">Transfer</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="form-bank" style="display: none;">
                                            <label for="jenisBank">Jenis Bank:</label>
                                            <select class="form-control" id="jenisBank" name="jenisBank" required>
                                                <option value="BRI">BRI</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BCA">BCA</option>
                                                <option value="Mandiri">Mandiri</option>

                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button id="simpanPembayaran" class="btn btn-primary" disable>Simpan
                                        Pembayaran</button>
                                </div>
                            </div>
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
            $("#btnBayar").click(function() {
                $("#pembayaranModal").modal("show");
            });

            if ($('p#status').length) {
                $('#bayarButton').prop('disabled', true);
            }

            $('#metodePembayaran').on('change', function() {
                const selectedDiskonOption = $(this).val();
                switch (selectedDiskonOption) {
                    case 'transfer':
                        $('#form-bank').show();
                        inputmetode = metodePembayaranInput.val() + ' ' + jenisBankInput.val();
                        break;
                    default:
                        $('#form-bank').css('display', 'none');
                        inputmetode = metodePembayaranInput.val();
                        break;
                }
            });

            $('#jenisBank').on('change', function() {
                const pilihanJenisBank = $(this).val();
                jenisBankInput.val(pilihanJenisBank);
                inputmetode = metodePembayaranInput.val() + ' ' + jenisBankInput.val();
            });
        });

        const btnCheckout = $('#simpanPembayaran');
        btnCheckout.prop('disabled', true);

        // Mengambil semua elemen input yang perlu diisi
        const tanggalPembayaranInput = $('#tanggalPembayaran');
        const jumlahPembayaranInput = $('#jumlahPembayaran');
        const metodePembayaranInput = $('#metodePembayaran');
        const jenisBankInput = $('#jenisBank');
        let inputmetode = metodePembayaranInput.val();

        // Mendengarkan perubahan pada setiap input
        tanggalPembayaranInput.on('input', enableCheckoutButton);
        jumlahPembayaranInput.on('input', enableCheckoutButton);
        metodePembayaranInput.on('input', enableCheckoutButton);

        // Fungsi untuk memeriksa apakah semua input telah diisi
        function enableCheckoutButton() {
            if (
                tanggalPembayaranInput.val() &&
                jumlahPembayaranInput.val() &&
                metodePembayaranInput.val()
            ) {
                btnCheckout.prop('disabled', false);
            } else {
                btnCheckout.prop('disabled', true);
            }
        }

        btnCheckout.on('click', function() {
            var tanggalPembayaran = tanggalPembayaranInput.val();
            var jumlahPembayaran = jumlahPembayaranInput.val();
            var metodePembayaran = inputmetode;
            var id_distribusi = $('#id_distribusi').val();

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: '{{ url('/admin/tagihan/store') }}', // Ganti dengan URL yang sesuai di aplikasi Anda
                data: {
                    id_distribusi: id_distribusi,
                    tanggalPembayaran: tanggalPembayaran,
                    jumlahPembayaran: jumlahPembayaran,
                    metodePembayaran: metodePembayaran,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Pembayaran berhasil disimpan
                    Swal.fire('Success', 'Pembayaran Berhasil', 'success');
                    window.location.reload();
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Pembayaran Gagal',
                    });
                }
            });
        });
    </script>
@endsection
