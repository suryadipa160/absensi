<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    function showFormLogin()
    {
        return view("auth.login");
    }

    function showLoginAdmin()
    {
        return view("auth.loginadmin");
    }

    function proseslogin(Request $request)
    {
        $message = [
            'required' => ' :attribute masih kosong!'
        ];
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ], $message);

        $data = [
            'nik' => $request->input('nik'),
            'password' => $request->input('password') 
        ];

        if(Auth::guard('karyawan')->attempt($data))
        {
            return redirect('/dashboard');
        }
        else{
            Session::flash('error', 'NIK atau Password salah');
            return redirect()->back()->with('nik', $request->nik);
        }
    }

    function logout(){
        Auth::guard('karyawan')->logout(); // menghapus session yang aktif
        return redirect('/');
    }

    function prosesloginadmin(Request $request)
    {
        $message = [
            'required' => ' :attribute masih kosong!'
        ];
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], $message);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password') 
        ];
        if(Auth::guard('user')->attempt($data))
        {
            return redirect('/panel/dashboardadmin');
        }
        else{
            Session::flash('error', 'Email atau Password salah');
            return redirect('/panel')->with('email', $request->email);
        }
    }
    function logoutadmin(){
        Auth::guard('user')->logout(); // menghapus session yang aktif
        return redirect('/panel');
    }

}
