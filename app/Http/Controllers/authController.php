<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class authController extends Controller
{
    function showWelcome() {
        return view('welcome');
    }
    // function Sign Up(start)
    function showSignup() {
        return view('signup');
    }
    
    function submitSignup(Request $request) {
        $user = new User();
        
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->save();
                
        return redirect()->route('signin.show');
    }
    // function Sign Up(end)

    // function Sign In(start)
    function showSignin() {
        return view('signin');
    }
    
    function submitSignin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('welcome.show');
        }else{
            return redirect()->back()->with('gagal', 'Email atau Password salah');
        }
    }
    // function Sign Up(end)
}
