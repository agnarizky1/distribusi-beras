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
        <h3>Laporan Pembelian Toko</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-4">
                            <label for="filterToko">Filter Toko</label>
                            <select class="form-control" id="filterToko">
                                <option value="">Cari Toko</option>
                                @foreach ($tokos as $toko)
                                    <option value="{{ $toko->id_toko }}">{{ $toko->nama_toko }}</option>
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
                                    @foreach($penjualan as $p)
                                    <tr class="list-penjualan text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td id="nama">{{ $p->nama_toko }}</td>
                                        <td data-bulan="{{$p->tahun}}-{{$p->bulan}}">{{ date('F', mktime(0, 0, 0, $p->bulan, 1)) }} {{ $p->tahun }}</td>
                                        <td>{{ $p->total_pembelian }}</td>
                                        <td>{{ $p->laba_kotor }}</td>
                                        <td>
                                            <a href="{{ route('admin.laporanToko.show', ['id' => $p->id_toko, 'bulan' => $p->tahun . '-' . $p->bulan]) }}"
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
            $('#filterToko').select2();

            $('#filterToko, #filterBulan').on('change', function () {
                var selectToko = $('#filterToko').find('option:selected');
                var namaToko = selectToko.text();
                var bulan = $('#filterBulan').val();

                // Loop melalui semua kartu data
                $('.list-penjualan').each(function () {
                    const nama = $(this).find('#nama').text();
                    const card = $(this);
                    const dataBulan = $(this).find('td:nth-child(3)').data('bulan');

                    // Periksa apakah data sesuai dengan jenis yang dipilih
                    if ((namaToko === nama || namaToko === 'Cari Toko') && (bulan === '' || dataBulan === bulan)) {
                        card.show();
                    } else {
                        card.hide();
                    }
                });
            });

            $('.btn-primary').on('click', function(){
                // Reset nilai filterToko dan filterBulan
                $('#filterToko').val('').trigger('change');;
                $('#filterBulan').val('');
                $('.list-penjualan').show();
            });
        });
    </script>
@endsection