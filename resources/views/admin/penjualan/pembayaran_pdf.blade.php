<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nota {{ $kode_distribusi }}</title>
    <style>
        .container {
            position: relative;
        }
        p {
            margin: 0;
        }

        .driver,
        .pengirim,
        .diterima-oleh {
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .info-list {
            display: inline-block;
            margin-right: 10px;
            vertical-align: top;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .signatures {
            display: flex;
            justify-content: flex-end;
        }

        .signatures p {
            margin-right: 70px;
            margin-top: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        center {
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        h3, p, h4 {
            margin: 0;
        }
    </style>
</head>

<body>

    <center>
        <h3>UD. SUMBER REJEKI SEJATI</h3>
        <p>Jalan Letjen Suprapto 72E, Kebonsari, Sumbersari, Jember. No.Telp (082133208080)</p>
        @foreach ($distribusi as $distribusi)
        <h4>nota # <span>{{ $distribusi->kode_distribusi }}</span></h4>
        @endforeach
    </center>
    <br>
    <center>
        <h3>Nota Pembelian</h3>
    </center>
    <div class="row" style="display: flex; justify-content: space-between;">

    @foreach ($toko as $toko)
        <div class="info-list">
            <ul style="list-style:none;">
                <li>Tanggal : {{ Carbon\Carbon::parse($distribusi->tanggal_distribusi)->format('d M, Y') }}</li>
                <li>Nama Toko : {{ $toko->nama_toko }}</li>
                <li>No. Telp : {{ $toko->nomor_tlp }}</li>
            </ul>
        </div>

        <div class="info-list">
            <ul style="list-style:none;">
                <li>No. Nota Pengiriman : {{ $distribusi->kode_distribusi }}</li>
                <li>Nopol Armada : {{ $toko->alamat }}</li>
                <li>Sales : {{ $toko->sales }}</li>
            </ul>
        </div>
    @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th>Jumlah (qty)</th>
                <th>Beras</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            @foreach ($distribusi->detailDistribusi as $distribusi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $distribusi->jumlah_beras }}</td>
                    <td>{{ $distribusi->nama_beras }}</td>
                    <td>Rp. {{ number_format($distribusi->harga, 0, '.', '.') }}</td>
                    <td>Rp. {{ number_format($distribusi->sub_total, 0, '.', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="4"><strong>Diskon</strong></td>
                <td><strong>Rp.{{ number_format($total_harga->total_harga, 0, '.', '.') }}</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>Rp.{{ number_format($total_harga->total_harga, 0, '.', '.') }}</strong></td>
            </tr>

        </tbody>
    </table>
    <div class="signatures">
        <p>Driver</p>
        <p>Pengirim</p>
        <p>Diterima Oleh</p>
    </div>

</body>

</html>

