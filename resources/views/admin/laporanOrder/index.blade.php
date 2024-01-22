@extends('layouts.app')
@section('content')
    <div class="page-heading">
        <h3>Laporan Penjualan</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-4">
                            <label for="filterTanggal">Filter Tanggal</label>
                            <input type="date" class="form-control" id="filterTanggal">
                        </div>
                        <div class="col-md-4">
                            <label for="filterBulan">Filter Bulan</label>
                            <input type="month" class="form-control" id="filterBulan">
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Reset</button>
                        </div>
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
                            <table id="tabel-distribusi" class="table table-bordered table-striped " style="width:100%">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th>ID Order</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Jumlah Tonase</th>
                                        <th>Laba Kotor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $p)
                                        <tr class="list-penjualan text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $p->kode_distribusi }}</td>
                                            <td id="tanggal">{{ $p->Tanggal_Penjualan }}</td>
                                            <td>{{ $p->Total_Penjualan }}</td>
                                            <td>Rp. {{ number_format($p->Laba_Kotor, 0, '.', '.') }}</td>
                                            <td>
                                                <a href="{{ route('admin.laporanOrder.show', $p->Tanggal_Penjualan) }}"
                                                    class="btn btn-success btn-sm mb-1">
                                                    <i class="fa fa-regular fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><b>Total</b></td>
                                    <td class="text-center">100 Kg</td>
                                    <td class="text-center">Rp. 100.000</td>
                                    <td></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            // Tambahkan event listener untuk filter tanggal
            $('#filterTanggal').on('change', function() {
                $('#filterBulan').val('');
                var selectTanggal = $(this).val();

                // Loop melalui semua kartu data
                $('.list-penjualan').each(function() {
                    const tanggal = $(this).find('#tanggal').text();
                    const card = $(this);

                    // Periksa apakah data sesuai dengan jenis yang dipilih
                    if (selectTanggal === tanggal || selectTanggal === '') {
                        card.show(); // Tampilkan kartu data
                    } else {
                        card.hide(); // Sembunyikan kartu data yang tidak sesuai
                    }
                });
            });

            // Tambahkan event listener untuk filter bulan
            $('#filterBulan').on('change', function() {
                $('#filterTanggal').val('');
                var selectBulan = $(this).val();

                // Loop melalui semua kartu data
                $('.list-penjualan').each(function() {
                    const tanggal = $(this).find('#tanggal').text();
                    const card = $(this);
                    const tahunBulan = tanggal.substring(0, 7);

                    // Periksa apakah data sesuai dengan jenis yang dipilih
                    if (selectBulan === tahunBulan || selectBulan === '') {
                        card.show(); // Tampilkan kartu data
                    } else {
                        card.hide(); // Sembunyikan kartu data yang tidak sesuai
                    }
                });
            });

            $('.btn-primary').on('click', function() {
                // Reset nilai filterTanggal dan filterBulan
                $('#filterTanggal').val('');
                $('#filterBulan').val('');
                $('.list-penjualan').show();
            });
        });
    </script>
@endsection
