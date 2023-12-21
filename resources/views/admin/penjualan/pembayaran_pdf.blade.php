<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
</head>

<body>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 8px;
        }

        .responsive-table td {
            white-space: nowrap;
        }

        @media screen and (max-width: 768px) {
            .responsive-table td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
    <div style="padding: 20px;">
        <center>
            <h3>UD. SUMBER REJEKI SEJATI</h3>
            <p>Jalan Letjen Suprapto 72E, Kebonsari, Sumbersari, Jember. No.Telp (082133208080)</p>
            @foreach ($distribusi as $distribusi)
                <h3>Nota Pembelian</h3>
            @endforeach
        </center>

        <table class="responsive-table">
            <tr>
                <td>Tanggal : {{ Carbon\Carbon::parse($distribusi->tanggal_distribusi)->format('d M, Y') }}</td>
                <td style="padding-left:20px"></td>
                <td>No. Nota Pengiriman : {{ $distribusi->kode_distribusi }}</td>
            </tr>
            <tr>
                <td>Nama Toko : {{ $toko->nama_toko }}</td>
                <td style="padding-left:20px"></td>
                <td>Nopol Armada : {{ $nopol->plat_no }}</td>
            </tr>
            <tr>
                <td>No. Telp : {{ $toko->nomor_tlp }}</td>
                <td style="padding-left:20px"></td>
                <td>Sales : {{ $toko->sales }}</td>
            </tr>
        </table>

        <div style="margin-top: 20px;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000;">No.</th>
                        <th style="border: 1px solid #000;">Jumlah</th>
                        <th style="border: 1px solid #000;">Nama Beras</th>
                        <th style="border: 1px solid #000;">Tonase Per KG</th>
                        <th style="border: 1px solid #000;">Harga Per KG</th>
                        <th style="border: 1px solid #000;">Harga Per Kemasan</th>
                        <th style="border: 1px solid #000;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalHarga = 0;
                    $totalTonase = 0; ?>
                    @foreach ($distribusi->detailDistribusi as $detail)
                        <?php
                        $produkString = $detail->nama_beras;
                        $namaProduk = trim(preg_replace('/\d+(\.\d+)? Kg$/', '', $produkString));
                        
                        $beratString = preg_match('/(\d+(\.\d+)?) Kg$/', $produkString, $matches) ? $matches[1] : null;
                        $berat = $beratString ? floatval($beratString) : null;
                        
                        $hargaPcs = $detail->harga;
                        $hargaKG = $hargaPcs / $berat;
                        $tonase = $berat * $detail->jumlah_beras;
                        ?>
                        <tr>
                            <td style="text-align: center; border: 1px solid #000;">{{ $loop->iteration }}</td>
                            <td style="text-align: center; border: 1px solid #000;">{{ $detail->jumlah_beras }}</td>
                            <td style="text-align: center; border: 1px solid #000;">{{ $detail->nama_beras }}</td>
                            <td style="text-align: center; border: 1px solid #000;">{{ $tonase }}</td>
                            <td style="text-align: center; border: 1px solid #000;">Rp.
                                {{ number_format($hargaKG, 0, '.', '.') }}</td>
                            <td style="text-align: center; border: 1px solid #000;">Rp.
                                {{ number_format($detail->harga, 0, '.', '.') }}</td>
                            <td style="text-align: center; border: 1px solid #000;">Rp.
                                {{ number_format($detail->sub_total, 0, '.', '.') }}</td>
                        </tr>
                        <?php
                        $totalHarga += $detail->sub_total;
                        $totalTonase += $tonase;
                        ?>
                    @endforeach
                    <tr>
                        <td style="text-align: center;" colspan="3">
                            <strong>Total</strong>
                        </td>
                        <td style="text-align: center;">{{ $distribusi->jumlah_distribusi }}</td>
                        <td style="text-align: left;" colspan="2"></td>
                        <td style="text-align: right;">Rp. {{ number_format($totalHarga, 0, '.', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;" colspan="6">
                            <strong>Diskon :</strong>
                        </td>
                        <td style="text-align: right;">Rp.
                            {{ number_format($totalHarga - $distribusi->total_harga, 0, '.', '.') }}
                        </td>
                    </tr>
                    @if ($distribusi->uang_return != 0)
                        <tr>
                            <td style="text-align: right;" colspan="6">
                                <strong>Total Uang Return :</strong>
                            </td>
                            <td style="text-align: right;">Rp.
                                {{ number_format($distribusi->uang_return, 0, '.', '.') }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="text-align: right;" colspan="6">
                            <strong>Total Harga :</strong>
                        </td>
                        <td style="text-align: right;">Rp.
                            {{ number_format($distribusi->total_harga - $distribusi->uang_return, 0, '.', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 20px;">
                <span>Driver</span>
                <span style="margin-left: 15%;">Pengirim</span>
                <span style="margin-left: 15%;">Diterima Oleh</span>
            </div>
        </div>
    </div>
</body>

</html>
