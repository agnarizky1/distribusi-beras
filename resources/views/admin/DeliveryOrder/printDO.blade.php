<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Delivery Order</title>
<style>
        .table-container {
        margin-top: 20px;
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
        text-align: center;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .text-center {
        text-align: center;
    }

    .margin-top-20 {
        margin-top: 20px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-12 {
        width: 100%;
    }

    .col-md-3 {
        width: 25%;
    }
</style>
</head>
<body>

<div class="row margin-top-20">
    <div class="col-12 text-center">
        <h3>Detail Delivery Order</h3>
    </div>
</div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Tanggal Masuk</th>
                    <th rowspan="2">Toko</th>
                    <th rowspan="2">Alamat</th>
                    <th rowspan="2">Sales</th>
                    <?php
                        $merkColumns = [];
                    ?>
                    @foreach($merk as $m)
                        @if (!in_array($m->merk_beras, $merkColumns))
                            <?php 
                                $merkColumns[] = $m->merk_beras;
                                $colspan = count(array_filter($merk->toArray(), function($item) use ($m) {
                                    return $item['merk_beras'] === $m->merk_beras;
                                }));
                            ?>
                            <th colspan="{{ $colspan }}">{{ $m->merk_beras }}</th>
                        @endif
                    @endforeach
                    <th rowspan="2">Tonase</th>
                </tr>
                <tr>
                    @foreach($merkColumns as $merkColumn)
                        @foreach($merk as $m)
                            @if ($m->merk_beras === $merkColumn)
                                <th>{{ $m->ukuran_beras }}</th>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php
                    $columnTotals = array_fill_keys(range(0, count($merk)-1), 0);
                    $totalTonase = 0;
                ?>
                @foreach($detailDeliveries as $index => $detail)
                    <tr>
                        <td>{{ $detail->distribusi->tanggal_distribusi }}</td>
                        <td>{{ $detail->distribusi->toko->nama_toko }}</td>
                        <td>{{ $detail->distribusi->toko->alamat }}</td>
                        <td>{{ $detail->distribusi->toko->sales }}</td>
                        <?php
                            $tonase = 0;
                        ?>
                        @foreach($merk as $colIndex => $product)
                            <?php
                                $jumlahBeras = 0;
                                $found = false;
                                foreach($detailDistribusi[$index] as $dist) {
                                    $namaBeras = $product->merk_beras . ' ' . $product->ukuran_beras . ' KG';
                                    if (strtolower($dist->nama_beras) == strtolower($namaBeras)){
                                        $jumlahBeras = $dist->jumlah_beras;
                                        $tonase += ($product->ukuran_beras*$jumlahBeras);
                                        $columnTotals[$colIndex] += $jumlahBeras;
                                        $found = true;
                                        break;
                                    }
                                }
                            ?>
                            @if ($found)
                                <td>{{ $jumlahBeras }}</td>
                            @else
                                <td></td>
                            @endif
                        @endforeach
                        <td>{{ $tonase }}</td>
                        <?php
                            $totalTonase += $tonase;
                        ?>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total Sak/PCS</td>
                    @foreach($columnTotals as $total)
                        <td>{{ $total }}</td>
                    @endforeach
                    <td>{{ $totalTonase }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row margin-top-20">
        <div class="col-md-3 text-center">
            <strong>Tanggal Kirim: {{ $delivery->tanggal_kirim }}</strong>
            <strong>
                <div>
                    TTD
                </div>
                <div>
                    Sopir
                </div>
            </strong>
            <br><br><br>
            <div>{{ $delivery->nama_sopir }}</div>
        </div>
    </div>

</body>
</html>
