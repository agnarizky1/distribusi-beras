<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order</title>
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

        th,
        td {
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
            justify-content: space-between;
        }

        .col-12 {
            width: 100%;
        }

        .col-md-3 {
            width: 25%;
        }

        .col-md-3 {
            width: 48%;
            /* Adjust the width as needed */
        }
    </style>
</head>

<body>
    <div class="row margin-top-20">
        <div class="col-12 text-center">
            <h3>UD. SUMBER REJEKI SEJATI</h3>
            <p>Jalan Letjen Suprapto 72E, Kebonsari, Sumbersari, Jember. No.Telp (082133208080)</p>
            <h4>Delivery Order</h4>
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
                    @foreach ($merk as $m)
                        @if (!in_array($m->merk_beras, $merkColumns))
                            <?php
                            $merkColumns[] = $m->merk_beras;
                            $colspan = count(
                                array_filter($merk->toArray(), function ($item) use ($m) {
                                    return $item['merk_beras'] === $m->merk_beras;
                                }),
                            );
                            ?>
                            <th colspan="{{ $colspan }}">{{ $m->merk_beras }}</th>
                        @endif
                    @endforeach
                    <th rowspan="2">Tonase</th>
                </tr>
                <tr>
                    @foreach ($merkColumns as $merkColumn)
                        @foreach ($merk as $m)
                            @if ($m->merk_beras === $merkColumn)
                                <th>{{ $m->ukuran_beras }}</th>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php
                $columnTotals = array_fill_keys(range(0, count($merk) - 1), 0);
                $totalTonase = 0;
                ?>
                <tr>
                    <td>{{ $distribusi->tanggal_distribusi }}</td>
                    <td>{{ $distribusi->toko->nama_toko }}</td>
                    <td>{{ $distribusi->toko->alamat }}</td>
                    <td>{{ $distribusi->toko->sales }}</td>
                    <?php
                    $tonase = 0;
                    ?>
                    @foreach ($merk as $colIndex => $product)
                        <?php
                        $jumlahBeras = 0;
                        $found = false;
                        foreach ($detailDistribusi as $dist) {
                            $namaBeras = $product->merk_beras . ' ' . $product->ukuran_beras . ' KG';
                            if (strtolower($dist->nama_beras) == strtolower($namaBeras)) {
                                $jumlahBeras = $dist->jumlah_beras;
                                $tonase += $product->ukuran_beras * $jumlahBeras;
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
                <tr>
                    <td colspan="4">Total Sak/PCS</td>
                    @foreach ($columnTotals as $total)
                        <td>{{ $total }}</td>
                    @endforeach
                    <td>{{ $totalTonase }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="text-align: left; margin-top: 20px;">
        <strong style="margin-left: 5%;">Tanggal Kirim: {{ $delivery->tanggal_kirim }}</strong>
    </div>
    <div>
        <strong style="margin-left: 10%;">TTD</strong>
        <strong style="margin-left: 20%;">TTD</strong>
    </div>
    <div>
        <strong>
            <span style="margin-left: 10%;">Sopir</span>
            <span style="margin-left: 19.5%;">Toko</span>
        </strong>
    </div>
    <br><br><br><br>
    <div>
        <strong>
            <span style="margin-left: 10%;">{{ $delivery->nama_sopir }}</span>
        </strong>
    </div>

</body>

</html>
