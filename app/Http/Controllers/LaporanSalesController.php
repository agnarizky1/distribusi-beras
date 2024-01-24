<?php

namespace App\Http\Controllers;
use App\Models\Distribusi;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LaporanSalesController extends Controller
{
    public function index()
    {
        $penjualan = Distribusi::select(
            'distribusis.id_toko',
            'tokos.sales',
                DB::raw('YEAR(tanggal_distribusi) as tahun'),
                DB::raw('LPAD(MONTH(tanggal_distribusi), 2, "0") as bulan'),
                DB::raw('SUM(jumlah_distribusi - jumlah_return) as total_pembelian'),
                DB::raw('SUM(total_harga - uang_return - potongan_harga) as laba_kotor'))
            ->join('tokos', 'tokos.id_toko', '=', 'distribusis.id_toko')
            ->groupBy('distribusis.id_toko', 'tokos.sales', 'tahun', 'bulan')
            ->where('distribusis.status', 'Diterima')
            ->get();

        $tokos = Distribusi::select(
            'tokos.sales')
            ->join('tokos', 'tokos.id_toko', '=', 'distribusis.id_toko')
            ->groupBy('distribusis.id_toko', 'tokos.sales')
            ->get();
        
        return view('admin.laporanSales.index', compact('penjualan','tokos'));
    }

    public function show($sales, $bulan){
        list($tahun, $bulan) = explode('-', $bulan);

        $toko = Toko::where('sales', $sales)->first();

        $order = Distribusi::where('id_toko', $toko->id_toko)
            ->whereMonth('tanggal_distribusi', $bulan)
            ->whereYear('tanggal_distribusi', $tahun)
            ->get();
            
            return view('admin.laporanSales.show', compact('order'));
    }
}