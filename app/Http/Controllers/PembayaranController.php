<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Toko;
use App\Models\Distribusi;
use App\Models\Pembayaran;
use App\Models\DetailDistribusi;
use App\Models\DetailDelivery;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        $distri = Distribusi::join('tokos', 'distribusis.id_toko', '=', 'tokos.id_toko')
            ->select('distribusis.*', 'tokos.*')
            ->where('status', 'Diterima')
            ->get();

        $pembayaranTotals = [];
        foreach ($distri as $d) {
            $pembayaranTotal = Pembayaran::where('id_distribusi', $d->id_distribusi)->sum('jumlah_pembayaran');
            $pembayaranTotals[$d->id_distribusi] = $pembayaranTotal;
        }
        return view('admin.tagihan.index', compact('tokos','distri','pembayaranTotals'));
    }

    public function store(Request $request)
    {
        $id_distribusi = $request->input('id_distribusi');
        $bayar = Pembayaran::where('id_distribusi', $id_distribusi)->first();

        $pembayaran = new Pembayaran();
        $pembayaran->id_distribusi = $id_distribusi;
        $pembayaran->tanggal_pembayaran = $request->input('tanggalPembayaran');
        $pembayaran->jumlah_pembayaran = $request->input('jumlahPembayaran');
        $pembayaran->metode_pembayaran = $request->input('metodePembayaran');

        $distribusi = Distribusi::with('pembayaran')->find($id_distribusi);
        $tanggalDistribusi = Carbon::parse($distribusi->tanggal_distribusi);
        $tengatWaktu = $tanggalDistribusi->addDays(10)->format('Y-m-d');

        $pembayaran->tanggal_tengat_pembayaran = $tengatWaktu;

        $distri = Distribusi::find($id_distribusi);
        $pembayaranTotal = Pembayaran::where('id_distribusi', $distri->id_distribusi)->sum('jumlah_pembayaran');
        $totalBayar = intval($pembayaranTotal);

        $totalHargaAwal = intval($distri->total_harga);
        $totalHarga = $totalHargaAwal -  $distri->uang_return - $distri->potongan_harga;

        $sisaPembayaran = $totalHarga - $totalBayar;

        $jumlahPembayaran = $request->input('jumlahPembayaran');

        if( $jumlahPembayaran > $sisaPembayaran){
            $response = [
                'status' => 'error',
                'message' => 'Pembayaran Gagal',
                'sisaPembayaran' => $sisaPembayaran,
            ];
            return response()->json($response, 500);
        }else{
            $pembayaran->save();
        }

        $toko = Toko::find($distri->id_toko);
        $totalPembayaran = Pembayaran::where('id_distribusi', $distri->id_distribusi)->sum('jumlah_pembayaran');
        $totPembayaran = intval($totalPembayaran);

        if ($totPembayaran >= $totalHarga) {
            $distri->update([
                'status_bayar' => 'Lunas',
            ]);

            $toko->update([
                'tanggungan' => 'Tidak Punya'
            ]);
        }

        if($bayar->jumlah_pembayaran == null ){
            $bayar->delete();
        }
    }

    public function show($id)
    {
        $distribusi = Distribusi::find($id);
        if (!$distribusi) {
            return redirect()->route('penjualan')->with('error', 'Order tidak ditemukan.');
        }

        $toko = $distribusi->toko;
        $detailDistribusi = $distribusi->detailDistribusi;
        $pembayaran = $distribusi->pembayaran->first();

        $bayar = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();

        return view('admin.tagihan.show', compact('distribusi', 'toko', 'detailDistribusi', 'pembayaran', 'bayar'));
    }

    public function destroy($id)
    {
        $distribusi = Distribusi::find($id);
        $dataDetails = DetailDistribusi::where('id_distribusi', $distribusi->id_distribusi)->get();
        $pembayaranDetails = Pembayaran::where('id_distribusi', $distribusi->id_distribusi)->get();
        $detailDO = DetailDelivery::where('id_distribusi', $distribusi->id_distribusi)->get();
        $toko = Toko::where('id_toko', $distribusi->id_toko)->first();

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

        $totalDistribusi = Distribusi::where('id_toko', $distribusi->id_toko)->count();

        if($totalDistribusi == 0){
            $toko->update([
                'tanggungan' => 'Tidak Punya'
            ]);
        }

        return redirect()->route('admin.tagihan')->with('success', 'Transaksi telah dihapus.');
    }

    public function cetak($id) {
        $distribusi = Distribusi::with('detailDistribusi')->where('id_distribusi', $id)->get();
        $kode_distribusi = Distribusi::where('id_distribusi', $id)->pluck('kode_distribusi');
        $id_toko = Distribusi::where('id_distribusi', $id)->pluck('id_toko');
        $toko = Toko::where('id_toko', $id_toko)->select('nama_toko','alamat','nomor_tlp')->get();
        $total_harga = Distribusi::where('id_distribusi', $id)->select('total_harga')->first();

        $pdf = PDF::loadview('admin.distribusi.pembayaran_pdf', compact('distribusi','toko','total_harga','kode_distribusi'));
        return $pdf->download('nota' . $kode_distribusi . '.pdf');
    }
}
