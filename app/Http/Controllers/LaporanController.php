<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribusi;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $penjualan = Distribusi::select(
            DB::raw('tanggal_distribusi as Tanggal_Penjualan'),
            DB::raw('SUM(jumlah_distribusi) as Total_Penjualan'),
            DB::raw('SUM(total_harga-uang_return-potongan_harga) as Laba_Kotor'))
            ->groupBy('tanggal_distribusi')
            ->get();

        // dd($penjualan);

        return view('admin.laporan.index', compact('penjualan'));
    }

    public function show($Tanggal_Penjualan)
    {
        
    }
}