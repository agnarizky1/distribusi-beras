<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\DetailDistribusi;
use App\Models\Toko;
use App\Models\Beras;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distri = Distribusi::join('tokos', 'distribusis.id_toko', '=', 'tokos.id_toko')
            ->select('distribusis.*', 'tokos.nama_toko')
            ->get();
        return view('admin.distribusi.index', compact('distri'));

    }


    public function create()
    {
        $tokos = Toko::all();
        $beras = Beras::all();

        return view('admin.distribusi.create', compact('tokos', 'beras'));
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
        $randomValue = mt_rand(100, 999); // Nilai acak antara 1000 dan 9999

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
    
        // Kemudian, simpan setiap Distribusi ke dalam tabel DetailDistribusi
        foreach ($distribusi as $item) {
            $detailDistribusi = new DetailDistribusi();
            $detailDistribusi->id_distribusi = $distribusiModel->id_distribusi;
            $detailDistribusi->nama_beras = $item['nama'];
            $detailDistribusi->jenis_beras = $item['jenis'];    
            $detailDistribusi->harga = $item['harga'];
            $detailDistribusi->jumlah_beras = $item['jumlah'];
            $detailDistribusi->sub_total = $item['harga']*$item['jumlah'];

            $dataBeras = Beras::where('nama_beras', $item['nama_asli'])->first();
            if ($dataBeras) {
                if ($dataBeras->stock >= $item['jumlah']) {
                    $dataBeras->stock -= $item['jumlah'];
                    $dataBeras->save();
                } else {
                    return response()->json(['error' => '' . $dataBeras->nama . ' Stok Habis'], 400);
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
        return view('admin.distribusi.show', compact('distribusi', 'toko', 'detailDistribusi'));
    }

    public function destroy(Beras $id)
    {
        $distribusi = Distribusi::find($id);
        $dataDetail = DetailDistribusi::where('id_distribusi', $distribusi->id_distribusi)->first();
        if($dataDetail == null){
            $distribusi->delete(); 
        }else{
            $dataDetail->delete();
        }
        $distribusi->delete(); 
        return redirect()->route('distribution')->with('success', 'Transaksi telah dihapus.');
    
    }
}
