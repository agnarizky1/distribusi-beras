<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merk;
use RealRashid\SweetAlert\Facades\Alert;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merk = Merk::all();
        return view('admin.merk_beras.index', compact('merk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merk_beras.add');
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
            'merk' => 'required',
        ]);


        $merk = Merk::create([
            'merk' => $request->merk,
        ]);

        if ($merk) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.merk')->with('success', 'Data Merk Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data Merk Gagal Disimpan!');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merk = Merk::find($id);
        return view('admin.merk_beras.edit', compact('merk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'merk' => 'required',
        ]);

        $merk = Merk::find($id);
        $merk->update([
            'merk' => $request->merk,
        ]);

        return redirect()->route('admin.merk')->with('success', 'Data Merk Berhasil Diubah!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merk = Merk::find($id);
        $merk->delete();
        Alert::error('Data Merk Berhasil Dihapus!');
        return back();
    }
}
