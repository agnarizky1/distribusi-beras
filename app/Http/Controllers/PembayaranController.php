<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Toko;
use App\Models\Distribusi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        $id_distribusi = $request->input('id_distribusi');

        $pembayaran = new Pembayaran();
        $pembayaran->id_distribusi = $id_distribusi;
        $pembayaran->tanggal_pembayaran = $request->input('tanggalPembayaran');
        $pembayaran->jumlah_pembayaran = $request->input('jumlahPembayaran');
        $pembayaran->metode_pembayaran = $request->input('metodePembayaran');

        $distribusi = Distribusi::with('pembayaran')->find($id_distribusi);
        $tanggalDistribusi = Carbon::parse($distribusi->tanggal_distribusi);
        $tengatWaktu = $tanggalDistribusi->addDays(7)->format('Y-m-d');

        $pembayaran->tanggal_tengat_pembayaran = $tengatWaktu;
        $pembayaran->save();
        return redirect()->route('distribution.show', $pembayaran->id_distribusi);
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
