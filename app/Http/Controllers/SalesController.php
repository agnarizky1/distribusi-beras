<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::all();
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.add');
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
            'nama_sales' => 'required',
            'no_telpon' => 'required',
        ]);


        $sales = Sales::create([
            'nama_sales' => $request->nama_sales,
            'no_telpon' => $request->no_telpon,
        ]);

        if ($sales) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.sales')->with('success', 'Data Sales Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data Sales Gagal Disimpan!');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = Sales::find($id);
        return view('admin.sales.edit', compact('sales'));
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
            'nama_sales' => 'required',
            'no_telpon' => 'required',
        ]);

        $sales = Sales::find($id);
        $sales->update([
            'nama_sales' => $request->nama_sales,
            'no_telpon' => $request->no_telpon,
        ]);

        return redirect()->route('admin.sales')->with('success', 'Data sales Berhasil Diubah!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sales::find($id);
        $sales->delete();
        Alert::error('Data sales Berhasil Dihapus!');
        return back();
    }
}
