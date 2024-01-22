<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;

class LaporanOrderController extends Controller
{
    public function index()
    {
        $penjualan = Distribusi::select(
            DB::raw('tanggal_distribusi as Tanggal_Penjualan'),
            DB::raw('SUM(jumlah_distribusi-jumlah_return) as Total_Penjualan'),
            DB::raw('SUM(total_harga-uang_return-potongan_harga) as Laba_Kotor'))
            ->groupBy('tanggal_distribusi')
            ->where('status', 'Diterima')
            ->get();

        // dd($penjualan);

        return view('admin.laporanOrder.index', compact('penjualan'));
    }

    public function show($Tanggal_Penjualan)
    {
        $order = Distribusi::where('tanggal_distribusi', $Tanggal_Penjualan)->get();

        return view('admin.laporanOrder.show', compact('order'));
    }
    public function downloadExcel()
    {
        return Excel::download(new YourExportClass, 'example.xlsx');
    }
}
