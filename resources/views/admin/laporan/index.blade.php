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
                                        <th>Tanggal Penjualan</th>
                                        <th>Jumlah Tonase</th>
                                        <th>Laba Kotor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->Tanggal_Penjualan }}</td>
                                        <td>{{ $p->Total_Penjualan }}</td>
                                        <td>{{ $p->Laba_Kotor }}</td>
                                        <td>
                                            <a href="{{ route('admin.laporan.show', $p->Tanggal_Penjualan) }}"
                                                class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            var table = $('#tabel-distribusi').DataTable({
                // Konfigurasi DataTable
                // ...
            });

            // Tambahkan event listener untuk filter tanggal
            $('#filterTanggal').on('change', function () {
                var tanggal = $(this).val();
                table.column(1).search(tanggal).draw();
            });

            // Tambahkan event listener untuk filter bulan
            $('#filterBulan').on('change', function () {
                var bulan = $(this).val();
                table.column(1).search(bulan).draw();
            });

            // Tambahkan event listener untuk filter tahun
            $('#filterTahun').on('change', function () {
                var tahun = $(this).val();
                table.column(1).search(tahun).draw();
            });
        });

    </script>
@endsection