<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class authController extends Controller
{
    // controller untuk dashboard
    function showAdmin() {
        $user = Auth::user();
        return view('admin.dashboard', [
            'username' => $user->username,
        ]);
    }
    function showUser() {
        return view('dashboard');
    }
    // function signup (start)
    // menampilkan tampilan signup
    function showSignup() {
        return view('signup');
    }
    // submit signup
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
    // function signup (end)

    // function signin (start)
    // menampilkan tampilan signin
    function showSignin() {
        return view('signin');
    }
    // submit signin
    function submitSignin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            return match($user->role){
                'admin' => redirect()->route('admin.show'),
                default => redirect()->route('user.show'),
            };
        }

        return redirect()->back()->with([
            'gagal', 'Email atau password salah',
        ])->onlyInput('email');
    }
    
    // function signin (end)

    // function signout (start)
    function signOut(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('default.show')
        ->with('logout', 'Anda telah berhasil logout.');
    }
    // function signout (end)
}
