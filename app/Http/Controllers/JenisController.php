<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis = Jenis::all();
        return view('admin.jenis.index', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jenis.add');
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
            'jenis' => 'required',
        ]);


        $jenis = Jenis::create([
            'jenis' => $request->jenis,
        ]);

        if ($jenis) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.jenis')->with('success', 'Data jenis Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data jenis Gagal Disimpan!');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_jenis
     * @return \Illuminate\Http\Response
     */
    public function show($id_jenis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_jenis
     * @return \Illuminate\Http\Response
     */
    public function edit($id_jenis)
    {
        $jenis = Jenis::find($id_jenis);
        return view('admin.jenis.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_jenis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jenis $id_jenis)
    {
        $request->validate([
            'jenis' => 'required',
        ]);

        // @dd($request);

        $id_jenis->update([
            'jenis' => $request->jenis,
        ]);


        return redirect()->route('admin.jenis')->with('success', 'Data jenis Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_jenis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jenis $id_jenis)
    {
        $id_jenis->delete();
        Alert::error('Data jenis Berhasil Dihapus!');
        return back();
    }
}
