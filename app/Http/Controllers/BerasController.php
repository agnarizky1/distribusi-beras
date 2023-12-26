<?php

namespace App\Http\Controllers;

use App\Models\Beras;
use App\Models\Merk;
use App\Models\totalStock;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BerasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beras = Beras::all();
        $merk = Merk::all();
        $total = totalStock::all();
        $ukuran = Ukuran::all();
        return view('admin.stock.index', compact('beras','merk','total','ukuran'));
    }

    public function store(Request $request)
    {
        $berasArray = $request->input ('beras');
        $namaSopir = $request->input ('namaSopir');
        $platNo = $request->input ('platNo');
        $tanggal_masuk = $request->input ('tanggal_masuk');

        foreach ($berasArray as $d) {
            $nextId = $this->generateNextId();
            $beras = new Beras();
            $beras->id_beras = $nextId;
            $beras->merk_beras = $d['merk'];
            $beras->berat = $d['berat'];
            $beras->harga = $d['harga'];
            $beras->stock = $d['jumlah'];
            $beras->nama_sopir = $namaSopir;
            $beras->plat_no = $platNo;
            $beras->tanggal_masuk_beras = $tanggal_masuk;

            $beras->save();

            $tStock = totalStock::where('merk_beras', $d['merk'])
            ->where('ukuran_beras', $d['berat'])
            ->first();

            if ($tStock) {
                $tStock->jumlah_stock += $d['jumlah'];
                $tStock->harga = $d['harga'];
                $tStock->save();
            } else {
                // Jika total_stock belum ada, buat yang baru
                totalStock::create([
                    'merk_beras' =>  $d['merk'],
                    'ukuran_beras' =>  $d['berat'],
                    'jumlah_stock' =>  $d['jumlah'],
                    'harga' =>  $d['harga'],
                ]);
            }

            $updateharga = TotalStock::where('merk_beras',  $d['merk'])->update(['harga' => $d['harga']]);
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
        $merk = Merk::all();
        $beras = Beras::find($id)->first();
        // dd($beras);
        return view('admin.stock.show', compact('beras', 'merk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_beras)
    {
        $merk = Merk::all();
        $beras = Beras::find($id_beras);
        return view('admin.stock.edit', compact('beras', 'merk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beras $id_beras)
    {
        $request->validate([
            'stock' => 'required',
        ]);

        $stockawal = $id_beras->stock;
        $selisihStock = $request->stock;

        $merk_beras = $request->input('nama_beras');
        $berat = $request->input('berat');

        $tStock = totalStock::where('merk_beras', $merk_beras)
        ->where('ukuran_beras', $berat)
        ->first();

        if ($tStock) {
            if($selisihStock > $stockawal){
                $selisihStock -= $stockawal;
                $tStock->jumlah_stock += $selisihStock;
                $tStock->save();
            }
            elseif ($selisihStock < $stockawal) {
                $stockawal -= $selisihStock;
                $tStock->jumlah_stock -= $stockawal;
                $tStock->save();
            }
        }

        $id_beras->update([
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.stockberas')->with('success', 'Data Beras Berhasil Disimpan!');
    }

    public function editjumlah($id)
    {
        $total =totalStock::find($id);
        return view('admin.stock.edit_jumlah_stock', compact('total'));
    }

    public function updatejumlah(Request $request, $id)
    {
        // ini fungsi untuk update harga pada stok beras
        $request->validate([
            'harga' => 'required',
        ]);

        $query = totalStock::find($id);
        $getData = $query->first();
        // dd($getData);

        if($getData){
            $getData->update([
                'harga' => $request->harga,
            ]);
        }
        return redirect()->route('admin.stockberas')->with('success', 'Harga Beras Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beras $id_beras)
    {
        $tStock = totalStock::where('merk_beras', $id_beras->merk_beras)
            ->where('ukuran_beras', $id_beras->berat)
            ->first();

        if ($tStock) {
            $tStock->jumlah_stock -= $id_beras->stock;

            if ($tStock->jumlah_stock <= 0) {
                $tStock->delete();
            } else {
                $tStock->save();
            }
        }
        $id_beras->delete();

        Alert::error('Data Beras Berhasil Dihapus!');
        return back();
    }
}
