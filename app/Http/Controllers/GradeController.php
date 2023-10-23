<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grade = Grade::all();
        return view('admin.grade.index', compact('grade'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grade.add');
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
            'grade' => 'required',
        ]);


        $grade = Grade::create([
            'grade' => $request->grade,
        ]);

        if ($grade) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.grade')->with('success', 'Data grade Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data grade Gagal Disimpan!');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_grade
     * @return \Illuminate\Http\Response
     */
    public function show($id_grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id_grade)
    {
        $grade = Grade::find($id_grade);
        return view('admin.grade.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $id_grade)
    {
        $request->validate([
            'grade' => 'required',
        ]);

        // @dd($request);

        $id_grade->update([
            'grade' => $request->grade,
        ]);


        return redirect()->route('admin.grade')->with('success', 'Data grade Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $id_grade)
    {
        $id_grade->delete();
        Alert::error('Data grade Berhasil Dihapus!');
        return back();
    }
}
