<?php

namespace App\Http\Controllers;
use App\Models\Distribusi;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LaporanTokoController extends Controller
{
    public function index()
    {
        $penjualan = Distribusi::select(
            'tokos.nama_toko',
                DB::raw('YEAR(tanggal_distribusi) as tahun'),
                DB::raw('LPAD(MONTH(tanggal_distribusi), 2, "0") as bulan'),
                DB::raw('SUM(jumlah_distribusi - jumlah_return) as total_pembelian'),
                DB::raw('SUM(total_harga - uang_return - potongan_harga) as laba_kotor'))
            ->join('tokos', 'tokos.id_toko', '=', 'distribusis.id_toko')
            ->groupBy('distribusis.id_toko', 'tokos.nama_toko', 'tahun', 'bulan')
            ->where('distribusis.status', 'Diterima')
            ->get();

        $tokos = Distribusi::select(
            'tokos.nama_toko')
            ->join('tokos', 'tokos.id_toko', '=', 'distribusis.id_toko')
            ->groupBy('distribusis.id_toko', 'tokos.nama_toko')
            ->get();
        
        return view('admin.laporanToko.index', compact('penjualan','tokos'));
    }
}
