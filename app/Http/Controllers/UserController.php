<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
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
            'name'   => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);


        $user = User::create([
            'name'   => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.user')->with('success', 'Data user Berhasil Disimpan!');
        } else {
            //redirect dengan pesan error
            Alert::error('Data user Gagal Disimpan!');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User
     * @return \Illuminate\Http\Response
     * @return \RealRashid\SweetAlert\Facades
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'        => 'required',
            'role'       => 'required',


        ]);
        $user = User::find($id);

        $password = $request->input('password');
        // @dd($user);

        User::where('id', $id)->update([
            'name'   => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($password) : $user->password, // Periksa apakah ada password yang diisi sebelum melakukan hash.
            'role' => $request->role,
        ]);
        return redirect()->route('admin.user')->with('success', 'Data User Berhasil Disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $id)
    {
        $id->delete();
        Alert::error('Data User Berhasil Dihapus!');
        return back();
    }
}
