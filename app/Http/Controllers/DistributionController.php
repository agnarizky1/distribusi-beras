<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Toko;
use App\Models\Beras;
use App\Models\Sales;
use App\Models\Distribusi;
use App\Models\Pembayaran;
use App\Models\totalStock;
use Illuminate\Http\Request;
use App\Models\DetailDistribusi;
use App\Models\DetailDelivery;
use App\Models\DeliveryOrder;


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
        $sales = Sales::all();
        $beras = totalStock::where('status', 'Baik')->get();
        $distri = Distribusi::with('toko')
            ->whereIn('status', ['Pending', 'Dikirim'])
            ->get();

        $pembayaranTotals = [];
        foreach ($distri as $d) {
            $pembayaranTotal = Pembayaran::where('id_distribusi', $d->id_distribusi)->sum('jumlah_pembayaran');
            $pembayaranTotals[$d->id_distribusi] = $pembayaranTotal;
        }
        return view('admin.distribusi.index', compact('tokos', 'sales', 'beras','distri','pembayaranTotals'));
    }

    public function cekTanggungan($idToko)
    {
        $toko = Toko::find($idToko);
        $tanggungan = $toko->tanggungan;

        if ($tanggungan != 'Punya') {
            return response()->json(['tanggungan' => $tanggungan]);
        }
    }

    public function validasi(Request $request){
        $getUser = User::all();

        foreach($getUser as $user){
            $role = $user->role;
            if($role == 'superadmin'){
                if (password_verify($request->input('pass'), $user->password)) {
                    return response()->json(['password' => 'benar']);
                }
            }else{
                return response()->json(['password' => 'salah'], 401);
            }
        }
    }

    public function store(Request $request)
    {
        // Mendapatkan data dari permintaan POST
        $namaToko = $request->input('namaToko');
        $totalHarga = $request->input('totalHarga');
        $tglDistri = $request->input('tglDistri');
        $jumlahDistribusi =$request->input('jumlahDistribusi');
        $distribusi = $request->input('Distribusi');
        $metodeBayar = $request->input('metodeBayar');

        $timestamp = time(); // Waktu saat ini dalam detik
        $randomValue = mt_rand(1000, 9999); // Nilai acak antara 1000 dan 9999

        // Gabungkan elemen-elemen tersebut untuk membuat kode transaksi
        $kode_distribusi = 'OB' . date('mdH', $timestamp) . $randomValue;

        $toko = Toko::find($namaToko);

        // mngelola data dan menyimpannya ke dalam database sesuai dengan struktur tabel yang ada.
        $distribusiModel = new Distribusi();
        $distribusiModel->id_toko = $namaToko;
        $distribusiModel->kode_distribusi = $kode_distribusi;
        $distribusiModel->tanggal_distribusi = $tglDistri;
        $distribusiModel->jumlah_distribusi = $jumlahDistribusi;
        $distribusiModel->total_harga = $totalHarga;
        $distribusiModel->status = 'Pending';
        $distribusiModel->jenis_pembayaran = $metodeBayar;
        $distribusiModel->potongan_harga = $toko->sisa_uang_return;

        $distribusiModel->save();

        $pembayaran = new Pembayaran();
        $pembayaran->id_distribusi = $distribusiModel->id_distribusi;

        $tanggalDistribusi = Carbon::parse($distribusiModel->tanggal_distribusi);
        $tengatWaktu = $tanggalDistribusi->addDays(10)->format('Y-m-d');

        $pembayaran->tanggal_tengat_pembayaran = $tengatWaktu;
        $pembayaran->metode_pembayaran = 'tunai';

        $pembayaran->save();

        // Kemudian, simpan setiap Distribusi ke dalam tabel DetailDistribusi
        foreach ($distribusi as $item) {
            $detailDistribusi = new DetailDistribusi();
            $detailDistribusi->id_distribusi = $distribusiModel->id_distribusi;
            $detailDistribusi->nama_beras = $item['nama'];
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

        $toko->update([
            'sisa_uang_return' => 0,
            'tanggungan' => 'Punya' ,
        ]);
    }

    public function update(Request $request){
        $id_distribusi = $request->input('id');
        $status = $request->input('statusPenerimaan');
        $dataBeras = $request->input('formData');
        $jumlahTonaseReturn = $request->input('jumlahReturn');

        if($status == 'Dikembalikan'){
            $status = 'Diterima';

        }

        $distribusi = Distribusi::find($id_distribusi);
        $jumlahReturn = 0;

        if($dataBeras != null){
            foreach($dataBeras as $data){
                $nextId = $this->generateNextId();

                $detail = DetailDistribusi::find($data['idDetail']);
                if ($detail) {
                    $detail->update([
                        'jumlah_return' => $data['jumlahBaik']+$data['jumlahRusak'],
                    ]);
                }

                $produkString = $detail->nama_beras;
                $namaProduk = trim(preg_replace('/\d+(\.\d+)? Kg$/', '', $produkString));

                $beratString = preg_match('/(\d+(\.\d+)?) Kg$/', $produkString, $matches) ? $matches[1] : null;
                $berat = $beratString ? floatval($beratString) : null;

                $orderDetail = DetailDelivery::where('id_distribusi', $distribusi->id_distribusi)->get();
                $idDelivery = $orderDetail->first()->id_delivery;

                $delivery = DeliveryOrder::find($idDelivery);
                $hargaPcs = $detail->harga;
                $hargaKG = $hargaPcs/$berat;

                if($data['jumlahBaik'] > 0){
                    // beras return dan menambah stok
                    $berasReturn = New Beras();
                    $berasReturn->id_beras = $nextId;
                    $berasReturn->merk_beras = $namaProduk;
                    $berasReturn->berat = $berat;
                    $berasReturn->nama_sopir = $delivery->nama_sopir;
                    $berasReturn->plat_no = $delivery->plat_no;
                    $berasReturn->tanggal_masuk_beras = $delivery->tanggal_kirim;
                    $berasReturn->harga = $hargaKG;
                    $berasReturn->stock = $data['jumlahBaik'];
                    $berasReturn->keterangan = 'Beras Return';
                    $berasReturn->save();

                    $tStock = totalStock::where('merk_beras', $namaProduk)
                        ->where('ukuran_beras', $berat)
                        ->first();
                
                    if ($tStock) {
                        $tStock->jumlah_stock += intval($data['jumlahBaik']);
                        $tStock->harga = $hargaKG;
                        $tStock->save();
                    }
                }
                
                if($data['jumlahRusak'] > 0){
                    $berasRusak = 'Rusak';

                    $stockRusak = totalStock::where('merk_beras', $namaProduk)
                        ->where('ukuran_beras', $berat)
                        ->where('status', $berasRusak)//status rusak ->kari iki wes
                        ->first();

                    if ($stockRusak) {
                        $stockRusak->jumlah_stock += intval($data['jumlahRusak']);
                        $stockRusak->harga = $hargaKG;
                        $stockRusak->save();
                    } else {
                        $berasRusakToStock = new totalStock();
                        $berasRusakToStock->merk_beras = $namaProduk;
                        $berasRusakToStock->ukuran_beras = $berat;
                        $berasRusakToStock->jumlah_stock = $data['jumlahRusak'];
                        $berasRusakToStock->harga = $hargaKG;
                        $berasRusakToStock->status = 'Rusak';
                        $berasRusakToStock->save();
                    }
                }
                $jumlahReturn += $hargaPcs*($data['jumlahBaik']+$data['jumlahRusak']);
            }
        }

        if ($distribusi) {
            $distribusi->update([
                'status' => $status,
                'uang_return' => $jumlahReturn,
                'jumlah_return' => $jumlahTonaseReturn,
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
        $distribusi = Distribusi::find($id);
        if (!$distribusi) {
            return redirect()->route('distribution')->with('error', 'Distribusi tidak ditemukan.');
        }

        $toko = $distribusi->toko; // Anda perlu memiliki relasi antara Distribusi dan Toko dalam model Anda
        $detailDistribusi = $distribusi->detailDistribusi;

        return view('admin.distribusi.show', compact('distribusi', 'toko', 'detailDistribusi'));
    }

    public function destroy($id)
    {
        $distribusi = Distribusi::find($id);
        $dataDetails = DetailDistribusi::where('id_distribusi', $distribusi->id_distribusi)->get();
        $pembayaranDetails = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();
        $detailDO = DetailDelivery::where('id_distribusi', $distribusi->id_distribusi)->get();

        foreach ($dataDetails as $detail) {
            $detail->delete();
        }

        foreach ($pembayaranDetails as $bayar) {
            $bayar->delete();
        }

        foreach ($detailDO as $detailDO) {
            $detailDO->delete();
        }

        $distribusi->delete();

        return redirect()->route('distribution')->with('success', 'Orderan telah dihapus.');
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

