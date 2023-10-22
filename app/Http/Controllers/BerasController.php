<?php

namespace App\Http\Controllers;

use App\Models\Beras;
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
        return view('admin.stock.index', compact('beras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stock.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_beras' => 'required',
            'jenis_beras' => 'required',
            'harga' => 'required',
            'stock' => 'required',
        ]);

        // Mencari ID yang belum digunakan
        $nextId = $this->generateNextId();

        $beras = Beras::create([
            'id'   =>  $nextId,
            'nama_beras' => $request->nama_beras,
            'jenis_beras' => $request->jenis_beras,
            'harga' => $request->harga,
            'stock' => $request->stock,

        ]);

        if ($beras) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.stockberas')->with('success', 'Data Product Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data Product Gagal Disimpan!');
            return back();
        }
    }

    private function generateNextId()
     {
         $prefix = 'B-';
         $lastId = Beras::max('id');

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beras = Beras::find($id);
        return view('admin.stock.edit', compact('beras'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beras $id)
    {
        $request->validate([
            'id'   => 'required',
            'nama_beras' => 'required',
            'jenis_beras' => 'required',
            'harga' => 'required',
            'stock' => 'required',
        ]);

        // @dd($request);

            $id->update([
            'id'    =>  $request->id,
            'nama_beras' => $request->nama_beras,
            'jenis_beras' => $request->jenis_beras,
            'harga' => $request->harga,
            'stock' => $request->stock,
            ]);


        return redirect()->route('stock')->with('success', 'Data Product Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beras $id)
    {
        $id->delete();
        Alert::error('Data product Berhasil Dihapus!');
        return back();
    }
}
