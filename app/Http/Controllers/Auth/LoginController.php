<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(Request $request){
        if ($request->email === 'admin@example.com' && $request->password === 'admin123') {
            session(['user' => $request->email]);
            return redirect()->route('products.index');
        }
    
        return redirect()->back()->withErrors(['login' => 'Invalid email or password.']);
    }

    public function logout(Request $request){
        session()->forget('user');
        return redirect()->route('loginPage');
    }
    
    public function checkRoot() {
        return session()->has('user') ? redirect()->route('products.index') : redirect()->route('login');
    }
}