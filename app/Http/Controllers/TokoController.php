<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Sales;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

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
        $sales = Sales::all();
        return view('admin.toko.index', compact('toko', 'sales'));
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
    
    public function store(Request $request)
{
    $request->validate([
        'sales' => 'required',
        'foto_toko' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nama_toko' => 'required',
        'pemilik' => 'required',
        'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'alamat' => 'required',
        'nomor_tlp' => 'required',
    ]);

    // Mencari ID yang belum digunakan
    $nextId = $this->generateNextId();

    //foto toko
    if ($request->hasFile('foto_toko') && $request->hasFile('foto_ktp')) {
        $nama_toko = $request->file('foto_toko');
        $namaGambartoko = time() . 'toko.' . $nama_toko->getClientOriginalExtension();
        $nama_toko->move(public_path('uploads/toko'), $namaGambartoko); 

        $foto_ktp = $request->file('foto_ktp');
        $namaGambarktp = time() . 'ktp.' . $foto_ktp->getClientOriginalExtension();
        $foto_ktp->move(public_path('uploads/ktp'), $namaGambarktp); 
    } else {
        $namaGambartoko = null; // Jika tidak ada gambar yang diunggah
        $namaGambarktp = null; // Jika tidak ada gambar yang diunggah
    }

    $toko = Toko::create([
        'id_toko' => $nextId,
        'sales' => $request->sales,
        'foto_toko' => $namaGambartoko,
        'nama_toko' => $request->nama_toko,
        'pemilik' => $request->pemilik,
        'foto_ktp' => $namaGambarktp,
        'alamat' => $request->alamat,
        'nomor_tlp' => $request->nomor_tlp,
        'koordinat' => $request->koordinat,
    ]);


    if ($toko) {
        //redirect dengan pesan sukses
        return redirect()->route('admin.toko')->with('success', 'Data Toko Berhasil Disimpan!');
    } else {
        //redirect dengan pesan error
        Alert::error('Data Toko Gagal Disimpan!');
        return back();
    }
}


    private function generateNextId()
     {
         $prefix = 'T-';
         $lastId = Toko::max('id_toko');

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
        $toko = Toko::findOrFail($id);

        return view('admin.toko.show', compact('toko'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_toko)
    {
        $toko = Toko::find($id_toko);
        return view('admin.toko.edit', compact('toko', ));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'sales' => 'required',
        'foto_toko' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nama_toko' => 'required',
        'pemilik' => 'required',
        'foto_ktp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'alamat' => 'required',
        'nomor_tlp' => 'required',
    ]);

    $toko = Toko::find($id);

    if (!$toko) {
        // Redirect with an error message if the toko is not found
        Alert::error('Data Toko Tidak Ditemukan!');
        return back();
    }

    // Update fields that are not file uploads
    $toko->update([
        'sales' => $request->sales,
        'nama_toko' => $request->nama_toko,
        'pemilik' => $request->pemilik,
        'alamat' => $request->alamat,
        'nomor_tlp' => $request->nomor_tlp,
    ]);

    // Update foto toko if a new file is uploaded
    if ($request->hasFile('foto_toko')) {
        $foto_toko = $request->file('foto_toko');
        $foto_toko->storeAs('public/toko/', $foto_toko->hashName());
        $toko->update(['foto_toko' => $foto_toko->hashName()]);
    }

    // Update foto ktp if a new file is uploaded
    if ($request->hasFile('foto_ktp')) {
        $foto_ktp = $request->file('foto_ktp');
        $foto_ktp->storeAs('public/ktp/', $foto_ktp->hashName());
        $toko->update(['foto_ktp' => $foto_ktp->hashName()]);
    }

    // Redirect with a success message
    return redirect()->route('admin.toko')->with('success', 'Data Toko Berhasil Diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toko $id_toko)
    {
        if ($id_toko->foto_toko) {
            $gambartoko = public_path('uploads/toko/' . $id_toko->foto_toko);
            $gambarktp = public_path('uploads/ktp/' . $id_toko->foto_ktp);
    
            if (File::exists($gambartoko, $gambarktp)) {
                File::delete($gambartoko, $gambarktp);
            }
        }
        $id_toko->delete();
        Alert::error('Data Toko Berhasil Dihapus!');
        return back();
    }
}
