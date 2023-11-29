@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-md-6">
                <h3>Detail Order</h3>
            </div>

        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="col-md-6">
                            <a href="{{ route('distribution') }}" class="btn btn-primary">
                                Kembali
                            </a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nama Toko : {{ $toko->nama_toko }}</p>
                                <p>Alamat : {{ $toko->alamat }}</p>
                                <p>Sales : {{ $toko->sales }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tanggal Order Beras : {{ $distribusi->tanggal_distribusi }}</p>
                                <p>Jumlah Seluruh Orderan : {{ $distribusi->jumlah_distribusi }} KG</p>
                                <p>Yang Harus Dibayar : {{ $distribusi->total_harga }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama Beras</th>
                                            <th>Jumlah (QTY)</th>
                                            <th>Harga (satuan)</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalHarga = 0;
                                        @endphp
                                        @foreach ($detailDistribusi as $detail)
                                            <tr>
                                                <td>{{ $detail->nama_beras }}</td>
                                                <td>{{ $detail->jumlah_beras }}</td>
                                                <td>{{ $detail->harga }}</td>
                                                <td>{{ $detail->sub_total }}</td>
                                            </tr>
                                            @php
                                                $totalHarga += $detail->sub_total;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total :</strong>
                                            </td>
                                            <td>Rp. {{ number_format($totalHarga, 0, '.', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Diskon :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($totalHarga - $distribusi->total_harga, 0, '.', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="3">
                                                <strong>Total Harga :</strong>
                                            </td>
                                            <td>Rp.
                                                {{ number_format($distribusi->total_harga, 0, '.', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="text-end">
                                <a href="{{ route('distribution.cetak', $distribusi->id_distribusi) }}"
                                    class="btn btn-warning btn-sm">Print</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $("#btnBayar").click(function() {
                                        $("#pembayaranModal").modal("show");
                                    });

                                    if ($('p#status').length) {
                                        $('#bayarButton').prop('disabled', true);
                                    }
                                });

                                const btnCheckout = document.getElementById('simpanPembayaran');
                                btnCheckout.disabled = true;

                                // Mengambil semua elemen input yang perlu diisi
                                const tanggalPembayaranInput = document.getElementById('tanggalPembayaran');
                                const jumlahPembayaranInput = document.getElementById('jumlahPembayaran');
                                const metodePembayaranInput = document.getElementById('metodePembayaran');

                                // Mendengarkan perubahan pada setiap input
                                tanggalPembayaranInput.addEventListener('input', enableCheckoutButton);
                                jumlahPembayaranInput.addEventListener('input', enableCheckoutButton);
                                metodePembayaranInput.addEventListener('input', enableCheckoutButton);

                                // Fungsi untuk memeriksa apakah semua input telah diisi
                                function enableCheckoutButton() {
                                    if (
                                        tanggalPembayaranInput.value &&
                                        jumlahPembayaranInput.value &&
                                        metodePembayaranInput.value
                                    ) {
                                        // Semua input telah diisi, aktifkan tombol "Simpan Pembayaran"
                                        btnCheckout.disabled = false;
                                    } else {
                                        // Salah satu atau semua input belum diisi, nonaktifkan tombol "Simpan Pembayaran"
                                        btnCheckout.disabled = true;
                                    }
                                }

                                document.getElementById('simpanPembayaran').addEventListener('click', function() {
                                    var tanggalPembayaran = tanggalPembayaranInput.value;
                                    var jumlahPembayaran = jumlahPembayaranInput.value;
                                    var metodePembayaran = metodePembayaranInput.value;
                                    var id_distribusi = document.getElementById('id_distribusi').value;

                                    // Kirim data ke server menggunakan AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('/admin/pembayaran/store') }}', // Ganti dengan URL yang sesuai di aplikasi Anda
                                        data: {
                                            id_distribusi: id_distribusi,
                                            tanggalPembayaran: tanggalPembayaran,
                                            jumlahPembayaran: jumlahPembayaran,
                                            metodePembayaran: metodePembayaran,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            // Pembayaran berhasil disimpan
                                            Swal.fire('Success', 'Pembayaran Berhasil', 'success')
                                                .then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.reload();
                                                    }
                                                });
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
                            </script> -->
@endsection
