<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\DetailDistribusi;
use App\Models\Toko;
use App\Models\Beras;
use App\Models\totalStock;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;


class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tokos = Toko::all();
        $beras = totalStock::all();
        $distri = Distribusi::join('tokos', 'distribusis.id_toko', '=', 'tokos.id_toko')
            ->select('distribusis.*', 'tokos.nama_toko')
            ->get();

        $pembayaranTotals = [];
        foreach ($distri as $d) {
            $pembayaranTotal = Pembayaran::where('id_distribusi', $d->id_distribusi)->sum('jumlah_pembayaran');
            $pembayaranTotals[$d->id_distribusi] = $pembayaranTotal;
        }
        return view('admin.distribusi.index', compact('tokos', 'beras','distri','pembayaranTotals'));
    }

    public function store(Request $request)
    {
        // Mendapatkan data dari permintaan POST
        $namaToko = $request->input('namaToko');
        $totalHarga = $request->input('totalHarga');
        $tglDistri = $request->input('tglDistri');
        $platNo = $request->input('PlatNo');
        $namaSopir = $request->input('namaSopir');
        $jumlahDistribusi =$request->input('jumlahDistribusi');
        $distribusi = $request->input('Distribusi');

        $timestamp = time(); // Waktu saat ini dalam detik
        $randomValue = mt_rand(1000, 9999); // Nilai acak antara 1000 dan 9999

        // Gabungkan elemen-elemen tersebut untuk membuat kode transaksi
        $kode_distribusi = 'DS' . date('mdH', $timestamp) . $randomValue;

        // mngelola data dan menyimpannya ke dalam database sesuai dengan struktur tabel yang ada.
        $distribusiModel = new Distribusi();
        $distribusiModel->id_toko = $namaToko;
        $distribusiModel->kode_distribusi = $kode_distribusi;
        $distribusiModel->nama_sopir = $namaSopir;
        $distribusiModel->plat_no = $platNo;
        $distribusiModel->total_harga = $totalHarga;
        $distribusiModel->tanggal_distribusi = $tglDistri;
        $distribusiModel->jumlah_distribusi = $jumlahDistribusi;
        $distribusiModel->total_harga = $totalHarga;

        $distribusiModel->save();

        $pembayaran = new Pembayaran();
        $pembayaran->id_distribusi = $distribusiModel->id_distribusi;

        $tanggalDistribusi = Carbon::parse($distribusiModel->tanggal_distribusi);
        $tengatWaktu = $tanggalDistribusi->addDays(10)->format('Y-m-d');

        $pembayaran->tanggal_tengat_pembayaran = $tengatWaktu;
        
        $pembayaran->save();

        // Kemudian, simpan setiap Distribusi ke dalam tabel DetailDistribusi
        foreach ($distribusi as $item) {
            $detailDistribusi = new DetailDistribusi();
            $detailDistribusi->id_distribusi = $distribusiModel->id_distribusi;
            $detailDistribusi->nama_beras = $item['nama'];
            $detailDistribusi->jenis_beras = $item['jenis'];
            $detailDistribusi->harga = $item['harga'];
            $detailDistribusi->jumlah_beras = $item['jumlah'];
            $detailDistribusi->sub_total = $item['harga']*$item['jumlah'];

            $dataBeras = totalStock::where('id', $item['idBeras'])->first();
            if ($dataBeras) {
                if ($dataBeras->jumlah_stock >= $item['jumlah']) {
                    $dataBeras->jumlah_stock -= $item['jumlah'];
                    $dataBeras->save();
                } else {
                    return response()->json(['error' => 'Beras merk ' . $dataBeras->merk_beras . ' Habis'], 400);
                }
            } else {
                return response()->json(['error' => 'Beras tidak ditemukan'], 404);
            }
            $detailDistribusi->save();
        }
    }

    public function show($id)
    {
        $distribusi = Distribusi::find($id); // Gantilah 'Distribusi' sesuai dengan model Anda
        if (!$distribusi) {
            return redirect()->route('distribution')->with('error', 'Distribusi tidak ditemukan.');
        }

        // Jika Distribusi ditemukan, Anda dapat mengambil data terkait di sini
        $toko = $distribusi->toko; // Anda perlu memiliki relasi antara Distribusi dan Toko dalam model Anda
        $detailDistribusi = $distribusi->detailDistribusi;
        $pembayaran = $distribusi->pembayaran->first();

        $bayar = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();

        return view('admin.distribusi.show', compact('distribusi', 'toko', 'detailDistribusi', 'pembayaran', 'bayar'));
    }

    public function destroy($id)
    {
        $distribusi = Distribusi::find($id);
        $dataDetails = DetailDistribusi::where('id_distribusi', $distribusi->id_distribusi)->get();
        $pembayaranDetails = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();

        foreach ($dataDetails as $detail) {
            $detail->delete();
        }

        foreach ($pembayaranDetails as $bayar) {
            $bayar->delete();
        }

        $distribusi->delete();

        return redirect()->route('distribution')->with('success', 'Transaksi telah dihapus.');
    }

    public function cetak($id) {
        $distribusi = Distribusi::with('detailDistribusi')->where('id_distribusi', $id)->get();
        $kode_distribusi = Distribusi::where('id_distribusi', $id)->pluck('kode_distribusi');
        // $sopir = Distribusi::where('id_distribusi', $id)->select('nama_sopir','plat_no')->get();
        $id_toko = Distribusi::where('id_distribusi', $id)->pluck('id_toko');
        $toko = Toko::where('id_toko', $id_toko)->select('nama_toko','alamat','nomor_tlp')->get();
        $total_harga = Distribusi::where('id_distribusi', $id)->select('total_harga', 'nama_sopir','plat_no')->first();

        $pdf = PDF::loadview('admin.distribusi.distribusi_pdf', compact('distribusi', 'toko','total_harga','kode_distribusi'));
        return $pdf->download('distribusi' . $kode_distribusi . '.pdf');
    }
}

