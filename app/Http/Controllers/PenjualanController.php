<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Toko;
use App\Models\Sales;
use App\Models\Distribusi;
use App\Models\Pembayaran;
use App\Models\totalStock;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\DetailDelivery;
use Illuminate\Routing\Controller;

class PenjualanController extends Controller
{

    public function index()
    {
        $tokos = Toko::all();
        $distri = Distribusi::join('tokos', 'distribusis.id_toko', '=', 'tokos.id_toko')
            ->select('distribusis.*', 'tokos.*')
            ->whereIn('status', ['Diterima','Ditolak'])
            ->get();

        $pembayaranTotals = [];
        foreach ($distri as $d) {
            $pembayaranTotal = Pembayaran::where('id_distribusi', $d->id_distribusi)->sum('jumlah_pembayaran');
            $pembayaranTotals[$d->id_distribusi] = $pembayaranTotal;
        }
        return view('admin.penjualan.index', compact('tokos','distri','pembayaranTotals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distribusi = Distribusi::find($id); // Gantilah 'Distribusi' sesuai dengan model Anda
        if (!$distribusi) {
            return redirect()->route('penjualan')->with('error', 'Order tidak ditemukan.');
        }

        // Jika Distribusi ditemukan, Anda dapat mengambil data terkait di sini
        $toko = $distribusi->toko; // Anda perlu memiliki relasi antara Distribusi dan Toko dalam model Anda
        $detailDistribusi = $distribusi->detailDistribusi;
        $pembayaran = $distribusi->pembayaran;

        $bayar = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();

        return view('admin.penjualan.show', compact('distribusi', 'toko', 'detailDistribusi', 'pembayaran', 'bayar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('penjualan')->with('success', 'Transaksi telah dihapus.');
    }

    public function cetak($id) {
        $distribusi = Distribusi::with('detailDistribusi')->where('id_distribusi', $id)->get();
        $kode_distribusi = Distribusi::where('id_distribusi', $id)->pluck('kode_distribusi');
        $id_toko = Distribusi::where('id_distribusi', $id)->pluck('id_toko');
        $toko = Toko::where('id_toko', $id_toko)->get();
        $total_harga = Distribusi::where('id_distribusi', $id)->select('total_harga')->first();
        $delivery = DetailDelivery::where('id_distribusi', $id)->first();
        $nopol = DeliveryOrder::where('id_delivery', $delivery->id_delivery)->first();

        $pdf = PDF::loadview('admin.penjualan.pembayaran_pdf', compact('distribusi','toko','total_harga','kode_distribusi','nopol',));
        return $pdf->download('nota' . $kode_distribusi . '.pdf');
    }
}
