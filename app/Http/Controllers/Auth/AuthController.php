<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        // dd($request->all());
        // $data = User::where('email',$request->email)->firstOrFail();
        // if($data){
        //     if(Hash::check($request->password,$data->password)){
        //         session(['berhasil_login' => true]);
        //         return redirect('dashboard');
        //     }
        // }
        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($user){
            if(count(Auth::user()->roles) == 0) {
                Auth::logout();
                return redirect()->back()->with("message", "anda tidak memiliki role untuk mengakses dashboard");
            }
            return redirect('dashboard');
        }
        return redirect('/')->with('message','Email atau Password Salah');
    }

    public function logout(Request $request){
        // $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
