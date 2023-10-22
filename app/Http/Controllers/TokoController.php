<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toko = Toko::all();
        return view('admin.toko.index', compact('toko'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.toko.add');
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
            'nama_toko' => 'required',
            'pemilik' => 'required',
            'alamat' => 'required',
            'nomor_tlp' => 'required',
        ]);

        // Mencari ID yang belum digunakan
        $nextId = $this->generateNextId();

        $toko = Toko::create([
            'id'   =>  $nextId,
            'nama_toko' => $request->nama_toko,
            'pemilik' => $request->pemilik,
            'alamat' => $request->alamat,
            'nomor_tlp' => $request->nomor_tlp,

        ]);

        if ($toko) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.toko')->with('success', 'Data Product Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data Product Gagal Disimpan!');
            return back();
        }
    }

    private function generateNextId()
     {
         $prefix = 'T-';
         $lastId = Toko::max('id');

         if (!$lastId) {
             // Jika belum ada data laporan, gunakan nomor 1
             return $prefix . '0001';
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
        $toko = Toko::find($id);
        return view('admin.toko.edit', compact('toko'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Toko $id)
    {
        $request->validate([
            'nama_toko' => 'required',
            'pemilik' => 'required',
            'alamat' => 'required',
            'nomor_tlp' => 'required',
        ]);

        // @dd($request);

            $id->update([
            'nama_toko' => $request->nama_toko,
            'pemilik' => $request->pemilik,
            'alamat' => $request->alamat,
            'nomor_tlp' => $request->nomor_tlp,
            ]);


        return redirect()->route('admin.toko')->with('success', 'Data Product Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toko $id)
    {
        $id->delete();
        Alert::error('Data product Berhasil Dihapus!');
        return back();
    }
}
