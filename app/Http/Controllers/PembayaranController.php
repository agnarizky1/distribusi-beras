<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Distribusi;
use Carbon\Carbon;

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

        return redirect()->route('distribution.show', $pembayaran->id_distribusi)->with('success', 'Data pembayaran berhasil disimpan.');
    }
}