<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangController extends Controller
{
    public function tampilkanData(){
        $barang = Barang::all();
        $user = Auth::user();

        return view('admin.barang', compact('barang'), ['username' => $user->username,
            'email' => $user->email,]);
    }
}
