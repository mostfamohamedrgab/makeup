<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   
    public function showlogin(){
        return view('admin.login');
      }
    // login
    public function login(Request $req){
    
    $req->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $remember_me = ! empty($req->remember_me); // checkbox remmeber
    // get admin data
    $data = [
        'email' => $req->email,
        'password' => $req->password
    ];
    // check data
    if(auth()->guard('admin')->attempt($data))
    {
        return redirect()->route('admin.');
    }
    // back if notfound
    return back()->with('danger','account not found');
    }

    // logout
    public function logout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin.showlogin');
    }
}
