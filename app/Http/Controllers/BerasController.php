<?php

namespace App\Http\Controllers;

use App\Models\Beras;
use App\Models\Grade;
use App\Models\Jenis;
use App\Models\Merk;
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
        $jenis = Jenis::all();
        $grade = Grade::all();
        $merk = Merk::all();
        return view('admin.stock.index', compact('beras','grade', 'jenis','merk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = Jenis::all();
        $grade = Grade::all();
        $merk = Merk::all();
        return view('admin.stock.add', compact('grade', 'jenis','merk'));
    }

    /**,
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'merk_beras' => 'required',
            'berat' => 'required',
            'jenis_beras' => 'required',
            'grade_beras' => 'required',
            'nama_sopir' => 'required',
            'plat_no' => 'required',
            'tanggal_masuk_beras' =>'required',
            'harga' => 'required',
            'stock' => 'required',
        ]);

        // Mencari ID yang belum digunakan
        $nextId = $this->generateNextId();

        $beras = Beras::create([
            'id_beras'   =>  $nextId,
            'merk_beras' => $request->merk_beras,
            'berat' => $request->berat,
            'jenis_beras' => $request->jenis_beras,
            'grade_beras' => $request->grade_beras,
            'nama_sopir' => $request->nama_sopir,
            'plat_no'=>$request->plat_no,
            'tanggal_masuk_beras' => $request->tanggal_masuk_beras,
            'harga' => $request->harga,
            'stock' => $request->stock,
        ]);

        if ($beras) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.stockberas')->with('success', 'Data Beras Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data Beras Gagal Disimpan!');
            return back();
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
        $jenis = Jenis::all();
        $grade = Grade::all();
        $merk = Merk::all();
        $beras = Beras::find($id)->first();
        // dd($beras);
        return view('admin.stock.show', compact('beras','grade','jenis', 'merk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_beras)
    {
        $jenis = Jenis::all();
        $grade = Grade::all();
        $merk = Merk::all();
        $beras = Beras::find($id_beras);
        return view('admin.stock.edit', compact('beras','grade','jenis', 'merk'));
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
            'harga' => 'required',
            'stock' => 'required',
        ]);

        // @dd($request);

            $id_beras->update([
            'harga' => $request->harga,
            'stock' => $request->stock,
            ]);


        return redirect()->route('admin.stockberas')->with('success', 'Data Beras Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beras $id_beras)
    {
        $id_beras->delete();
        Alert::error('Data Beras Berhasil Dihapus!');
        return back();
    }
}
