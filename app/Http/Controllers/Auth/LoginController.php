<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_token'); 
        
        if(auth()->attempt($credentials, $remember)){
            return redirect()->route('students.list');
        }else{
            return redirect()->route('login')->withErrors(['message' => 'Login is invalid']);
        }
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
}
