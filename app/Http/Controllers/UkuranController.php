<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $berat = Ukuran::all();
        return view('admin.ukuran.index', compact('berat'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ukuran.add');
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
            'berat' => 'required',
        ]);


        $berat = Ukuran::create([
            'berat' => $request->berat,
        ]);

        if ($berat) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.ukuran')->with('success', 'Data berat Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data berat Gagal Disimpan!');
            return back();
        }
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
        $berat = Ukuran::find($id);
        return view('admin.ukuran.edit', compact('berat'));
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
            'berat' => 'required',
        ]);

        $berat = Ukuran::find($id);
        $berat->update([
            'berat' => $request->berat,
        ]);

        return redirect()->route('admin.ukuran')->with('success', 'Data ukuran Berhasil Diubah!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berat = Ukuran::find($id);
        $berat->delete();
        Alert::error('Data ukuran Berhasil Dihapus!');
        return back();
    }
}
