@extends('layouts.app')
@section('content')
    <style>
        .select2-container {
            border: 1px solid #dce7f1;
            padding: 0.275rem 0.75rem;
            border-radius: 0.25rem;
            max-width: 100% !important;
            box-sizing: border-box;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #fff;
        }
    </style>

    <div class="page-heading">
        <h3>Laporan Penjualan Sales</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-4">
                            <label for="filterToko">Filter Sales</label>
                            <select class="form-control" id="filterToko">
                                <option value="">Cari Sales</option>
                                @foreach ($tokos as $toko)
                                    <option value="{{ $toko->id_toko }}">{{ $toko->sales }}</option>
                                @endforeach

                            </select>
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
                                        <th>Toko</th>
                                        <th>Bulan</th>
                                        <th>Jumlah Tonase Pembelian</th>
                                        <th>Total Pembelian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $p)
                                        <tr class="list-penjualan text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td id="nama">{{ $p->sales }}</td>
                                            <td data-bulan="{{ $p->tahun }}-{{ $p->bulan }}">
                                                {{ date('F Y', mktime(0, 0, 0, $p->bulan, 1, $p->tahun)) }}
                                            </td>
                                            <td data-tonase="{{ $p->total_pembelian }}">{{ $p->total_pembelian }} Kg</td>
                                            <td data-laba="{{$p->laba_kotor}}"> Rp. {{ number_format($p->laba_kotor, 0, '.', '.') }}</td>
                                            <td>
                                                <a href="{{ route('admin.laporanSales.show', ['sales' => $p->sales, 'bulan' => $p->tahun . '-' . $p->bulan]) }}"
                                                    class="btn btn-success btn-sm mb-1">
                                                    <i class="fa fa-regular fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <td colspan="3" class="text-end"><b>Total</b></td>
                                    <td id="totalTonase" class="text-center"></td>
                                    <td colspan="2" id="totalLaba" class="text-center"></td>
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
            $('#filterToko').select2();

            function updateTotalTonase() {
                var totalTonase = 0;
                $('.list-penjualan:visible').each(function () {
                    totalTonase += parseFloat($(this).find('[data-tonase]').data('tonase'));
                });
                $('#totalTonase').text(totalTonase + ' Kg');
            }

            // Fungsi untuk menghitung dan memperbarui totalLaba
            function updateTotalLaba() {
                var totalLaba = 0;
                $('.list-penjualan:visible').each(function () {
                    totalLaba += parseFloat($(this).find('[data-laba]').data('laba'));
                });
                var formattedTotalLaba = 'Rp. ' + totalLaba.toLocaleString('id-ID');
                $('#totalLaba').text(formattedTotalLaba);
            }

            updateTotalTonase();
            updateTotalLaba();

            $('#filterToko, #filterBulan').on('change', function() {
                var selectToko = $('#filterToko').find('option:selected');
                var namaToko = selectToko.text();
                var bulan = $('#filterBulan').val();

                // Loop melalui semua kartu data
                $('.list-penjualan').each(function() {
                    const nama = $(this).find('#nama').text();
                    const card = $(this);
                    const dataBulan = $(this).find('td:nth-child(3)').data('bulan');

                    // Periksa apakah data sesuai dengan jenis yang dipilih
                    if ((namaToko === nama || namaToko === 'Cari Sales') && (bulan === '' ||
                            dataBulan === bulan)) {
                        card.show();
                    } else {
                        card.hide();
                    }
                });
                    
                updateTotalTonase();
                updateTotalLaba();
            });

            $('.btn-primary').on('click', function() {
                // Reset nilai filterToko dan filterBulan
                $('#filterToko').val('').trigger('change');;
                $('#filterBulan').val('');
                $('.list-penjualan').show();
                    
                updateTotalTonase();
                updateTotalLaba();
            });
        });
    </script>
@endsection
