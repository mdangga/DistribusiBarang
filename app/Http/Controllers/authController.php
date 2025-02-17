<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class authController extends Controller
{
    function showWelcome() {
        return view('dasboard');
    }
    // function Sign Up(start)
    function showSignup() {
        return view('signup');
    }
    
    function submitSignup(Request $request) {
        $user = new User();
    
        
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->nama_user = $request->nama_user;
        $user->no_telpon = $request->no_telpon;
        $user->nama_perusahaan = $request->nama_perusahaan;
        $user->alamat = $request->alamat;
        $user->save();      

        return redirect()->route('signin.show')->with('success', 'Akun berhasil dibuat, silakan login!');
    }
    // function Sign Up(end)

    // function Sign In(start)
    function showSignin() {
        return view('signin');
    }
    
    function submitSignin(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('welcome.show');
        }else{
            return redirect()->back()->with('gagal', 'Email atau Password salah');
        }
    }
    // function Sign Up(end)
}
