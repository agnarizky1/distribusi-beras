<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merk;
use App\Models\Distribusi;
use App\Models\Toko;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        $user = User::all();
        $merk = Merk::all();
        $distribusi = Distribusi::all();
        $toko = Toko::all();
        return view('superadmin.dashboard', compact('user','merk','distribusi','toko'));
    }

    public function stock()
    {
        return view('admin.stock.index');
    }

}
