<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nota {{ $kode_distribusi }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        /* Container untuk mengatur posisi absolut */
        .container {
            position: relative;
        }


        /* Gaya untuk masing-masing elemen <ul> */
        .info-list {
            display: inline-block;
            margin-right: 20px;
            /* Atur margin antara elemen-elemen <ul> */
            vertical-align: top;
            /* Atur vertikal align ke atas */
        }
    </style>
</head>


<body>

    <Center>
        <h3>UD. SUMBER REJEKI SEJATI</h3>
        <p>Jalan Letjen Suprapto 72E, Kebonsari, Sumbersari, Jember. No.Telp (082133208080)</p>
        @foreach ($distribusi as $distribusi)
        @endforeach
    </Center>
    <br>
    <center>
        <h4>Nota Pembelian</h4>
    </center>
    <div class="row">

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
                    <li>Nopol Armada : {{ $nopol->plat_no }}</li>
                    <li>Sales : {{ $toko->sales }}</li>
                </ul>
            </div>
        @endforeach
    </div>

    <table class="table table-bordered">
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
    <p>Driver</p>&nbsp;<p>Pengirim</p>&nbsp;<p>Diterima Oleh</p>


</body>

</html>
