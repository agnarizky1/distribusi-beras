<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Distribusi;
use App\Models\DetailDistribusi;
use App\Models\Pengembalian;
use App\Models\Beras;
use App\Models\totalStock;

class PengembalianController extends Controller
{
    public function index()
    {
    $latestDistributions = Distribusi::select('id_toko', DB::raw('MAX(created_at) as latest_created_at'))
        ->where('status', 'Diterima')
        ->groupBy('id_toko');

    $distri = Distribusi::with('toko')
        ->whereIn(DB::raw('(id_toko, created_at)'), $latestDistributions)
        ->get();

    $pengembalian = Pengembalian::all();

    return view('admin.pengembalian.index', compact('distri','pengembalian'));
    }

    public function getPembelianTerakhir(Request $request)
    {
        // Ambil id distribusi dari request
        $idDistri = $request->input('idDistri');

        // Ambil detail pembelian terakhir
        $detailDistribusi = DetailDistribusi::where('id_distribusi', $idDistri)->get();

        return response()->json($detailDistribusi);
    }

    public function store(Request $request)
    {
        $idDistri = $request->input('idDistri');
        $tglPengembalian = $request->input('tglPengembalian');
        $jumlahReturn = $request->input('jumlahReturn');
        $uangReturn = $request->input('uangReturn');
        $platNomor = $request->input('platNomor');
        $namaSopir = $request->input('namaSopir');
        $dataReturn = $request->input('pengembalian');

        $timestamp = time(); // Waktu saat ini dalam detik
        $randomValue = mt_rand(1000, 9999); // Nilai acak antara 1000 dan 9999

        // Gabungkan elemen-elemen tersebut untuk membuat kode transaksi
        $kode_pengembalian = 'RT' . date('mdH', $timestamp) . $randomValue;

        $detailDistribusis = DetailDistribusi::where('id_distribusi', $idDistri)->get();

        // Simpan data pengembalian
        $pengembalian = new Pengembalian();
        $pengembalian->kode_pengembalian = $kode_pengembalian;
        $pengembalian->id_distribusi = $idDistri;
        $pengembalian->tanggal_pengembalian = $tglPengembalian;
        $pengembalian->jumlah_return = $jumlahReturn;
        $pengembalian->uang_return = $uangReturn;
        $pengembalian->save();

        foreach ($dataReturn as $data) {
            $nextId = $this->generateNextId();

            $detail = DetailDistribusi::find($data['detailId']);
            if ($detail) {
                $detail->update([
                    'jumlah_return' => $detail->jumlah_return+$data['rusak']+$data['baik'],
                ]);
            }

            $produkString = $detail->nama_beras;
            $namaProduk = trim(preg_replace('/\d+(\.\d+)? Kg$/', '', $produkString));

            $beratString = preg_match('/(\d+(\.\d+)?) Kg$/', $produkString, $matches) ? $matches[1] : null;
            $berat = $beratString ? floatval($beratString) : null;

            $hargaPcs = $detail->harga;
            $hargaKG = $hargaPcs/$berat;

            if($data['baik'] > 0){
                // beras return dan menambah stok
                $berasReturn = New Beras();
                $berasReturn->id_beras = $nextId;
                $berasReturn->merk_beras = $namaProduk;
                $berasReturn->berat = $berat;
                $berasReturn->nama_sopir = $namaSopir;
                $berasReturn->plat_no = $platNomor;
                $berasReturn->tanggal_masuk_beras = $tglPengembalian;
                $berasReturn->harga = $hargaKG;
                $berasReturn->stock = $data['baik'];
                $berasReturn->keterangan = 'Beras Return';
                $berasReturn->save();

                $tStock = totalStock::where('merk_beras', $namaProduk)
                    ->where('ukuran_beras', $berat)
                    ->first();
            
                if ($tStock) {
                    $tStock->jumlah_stock += intval($data['baik']);
                    $tStock->harga = $hargaKG;
                    $tStock->save();
                }
            }

            if($data['rusak'] > 0){
                $berasRusak = 'Rusak';

                $stockRusak = totalStock::where('merk_beras', $namaProduk)
                    ->where('ukuran_beras', $berat)
                    ->where('status', $berasRusak)//status rusak ->kari iki wes
                    ->first();

                if ($stockRusak) {
                    $stockRusak->jumlah_stock += intval($data['rusak']);
                    $stockRusak->harga = $hargaKG;
                    $stockRusak->save();
                } else {
                    $berasRusakToStock = new totalStock();
                    $berasRusakToStock->merk_beras = $namaProduk;
                    $berasRusakToStock->ukuran_beras = $berat;
                    $berasRusakToStock->jumlah_stock = $data['rusak'];
                    $berasRusakToStock->harga = $hargaKG;
                    $berasRusakToStock->status = 'Rusak';
                    $berasRusakToStock->save();
                }
            }
        }

        $distribusi = Distribusi::find($idDistri);

        if ($distribusi) {
            $distribusi->update([
                'uang_return' => $distribusi->uang_return+$uangReturn,
                'sisa_uang_return' => $distribusi->sisa_uang_return+$uangReturn,
                'jumlah_return' => $distribusi->jumlah_return+$jumlahReturn,
            ]);
        }
    }

    private function generateNextId()
    {
         $prefix = 'B-';
         $lastId = Beras::max('id_beras');

         if (!$lastId) {
             // Jika belum ada data laporan, gunakan nomor 1
             return $prefix . '00001';
         }

         // Ambil angka dari ID terakhir, tambahkan 1, dan lakukan padding
         $lastNumber = intval(substr($lastId, strlen($prefix)));
         $nextNumber = $lastNumber + 1;
         $nextId = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

         return $nextId;
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::find($id); 
        if (!$pengembalian) {
            return redirect()->route('admin.pengembalian')->with('error', 'Pengembalian tidak ditemukan.');
        }

        $distribusi = $pengembalian->distribusi;
        $detailDistribusi = $distribusi->detailDistribusi;

        return view('admin.pengembalian.show', compact('distribusi', 'pengembalian', 'detailDistribusi'));
    }

}
