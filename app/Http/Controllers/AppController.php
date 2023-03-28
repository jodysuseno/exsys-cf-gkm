<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\Kasus;
use App\models\Gejala;
use App\models\Penyakit;

class AppController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'cnt_user' => User::count(),
            'cnt_kasus' => Kasus::count(),
            'cnt_gejala' => Gejala::count(),
            'cnt_penyakit' => Penyakit::count(),
        ]);
    }
    public function login()
    {
        return view('login');
    }
    public function proses_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6|'
        ]);
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }
        return redirect('/login')->with('status', 'Login Gagal!');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function pasien()
    {
        return view('pasien');
    }

    public function pakar()
    {
        return view('pakar');
    }

    public function evaluasi()
    {
        return view('evaluasi');
    }
}
