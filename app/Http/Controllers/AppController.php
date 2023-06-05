<?php

namespace App\Http\Controllers;

use App\Models\BasisPengetahuan;
use App\Models\BasisPengetahuanKompleksitas;
use App\Models\BobotGejala;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kasus;
use App\Models\Gejala;
use App\Models\BobotKompleksitas;
use App\Models\Pasien;
use App\Models\Penyakit;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function index()
    {
        // membuka view index.blade.php
        return view('index', [
            'title' => 'Selamat Datang'
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', [
            'title' => 'dashboard', // judul
            'user' => User::orderByDesc('created_at')->get(), // menampilkan data user
            'kasus' => Kasus::orderByDesc('created_at')->get(), // menampilkan data kasus
            'penyakit' => Penyakit::orderByDesc('created_at')->get(), // menampilkan data penyakit
            'cnt_user_admin' => User::where('role', 'admin')->count(), // mengambil jumlah data user admin
            'cnt_user_pakar' => User::where('role', 'pakar')->count(), // mengambil jumlah data user pakar
            'cnt_user_perawat' => User::where('role', 'perawat')->count(), // mengambil jumlah data user perawat
            'cnt_penyakit' => Penyakit::orderByDesc('role', 'penyakit')->count(), // mengambil jumlah data penyakit
            'cnt_pasien' => Pasien::count(), //  // mengambil jumlah data pasien
        ]);
    }
    public function login()
    {
        return view('login'); // menampilkan form login di login.blade.php
    }
    public function proses_login(Request $request)
    {
        // validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6|'
        ]);
        // proses login jika berhasil
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }
        // jika gagal maka diarahkan ke form login
        return redirect('/login')->with('status', 'Login Gagal!');
    }
    public function logout()
    {
        // proses logout
        Auth::logout();
        return redirect('/login');
    }

    public function sistem_pakar()
    {
        return view('sistem_pakar', [ // mengarahkan ke view sistem_pakar.blade.php
            'pasien' => Pasien::orderByDesc('created_at')->get(), //  menampilkan data pasien 
            'gejala' => Gejala::all(), // untuk menampilkan pilihan gejala
            'kompleksitas' => BobotKompleksitas::all(), // untuk menampilkan pilihan kompleksitas
            'title' => 'Sistem Diagnosa' // judul
        ]);
    }

    public function hasil_pakar(Request $request)
    {

        $request->validate([ // validasi input dari form sistem pakar
            'pasien_id' => 'required',
            'gejala_id' => 'required|array',
            'gejala_id.*' => 'required',
        ]);

        // mengambil data kasus yang berstatus selesai untuk dilakuakn perhitungan certainty factor
        $kasus = Kasus::where('keterangan', 'selesai')->get();
        // buat variabel array kosong
        // $kasus_id = array();
        $data_penyakit_id = array();
        $data_penyakit_name = array();
        $data_penyakit_devinisi = array();
        $data_penyakit_solusi = array();
        $data_pasien_name = array();
        $data_result = array();
        $data_same_gejala = array();
        $data_same_kompleksitas = array();
        $data_kasus_gejala = array();
        $data_kasus_kompleksitas = array();
        // looping data kasus
        foreach ($kasus as $item) {
            // mengambil id gejala data input data gejala yang dipilih  
            $req_gejala_id = array();
            foreach ($request->gejala_id as $req_gejala_item) {
                $req_gejala_id[] = $req_gejala_item; // memasukan gejala yang diambil ke array $req_gejala_id
            }
            // mengambil id gejala dari basis pengetahuan berdasarkan id kasus  
            $data_gejala_id = array();
            foreach (BasisPengetahuan::where('kasus_id', $item->id)->get() as $data_gejala_item) {
                $data_gejala_id[] = $data_gejala_item->gejala_id; // memasukan id gejala pada array $data_gejala_id[]  
            }
            // megnmbil id gejala yang sama antara array $req_gejala_id dan $data_gejala_id
            $same_gejala = array_intersect($req_gejala_id, $data_gejala_id);

            // mengambil nilai gejala data input data gejala yang dipilih  
            $req_gejala_val = array();
            foreach ($same_gejala as $req_gejala_val_item) {
                $req_gejala_val[] = BasisPengetahuan::where('kasus_id', $item->id)->where('gejala_id', $req_gejala_val_item)->first()->bobot_gejala->bobot; // memasukan nilai bobot gejala yang diambil ke array $req_gejala_val
            }
            //mengambil nilai gejala dari basis pengetahuan berdasarkan nilai kasus
            $data_gejala_val = array();
            foreach ($data_gejala_id as $data_gejala_val_item) {
                $data_gejala_val[] = BasisPengetahuan::where('kasus_id', $item->id)->where('gejala_id', $data_gejala_val_item)->first()->bobot_gejala->bobot; // memasukan nilai bobot gejala yang pada array $data_gejala_val 
            }
            // proses menghitung similarity

            if (is_null($request->kompleksitas_id)) { //jika kompleksitas tidak ada yang dipilih
                $mergeSW = $req_gejala_val; // variabel $mergeSW sama dengan $req_gejala_val 
                $mergeW = $data_gejala_val; // $mergeW sama dengan $data_gejala_val
                $same_komplek = null; // variabel $same_komplek diset null/kosong 
                $data_komplek_id = null; // variabel $data_komplek_id diset null/kosong
            } else { //jika kompleksitas ada yang dipilih
                // mengambil id kopleksitas data input data kopleksitas yang dipilih
                $req_komplek_id = array();
                foreach ($request->kompleksitas_id as $req_komplek_item) {
                    $req_komplek_id[] = $req_komplek_item; // memasukan kompleksitas yang diambil ke array $req_kompleksitas_id
                }
                // mengambil id kompleksitas dari basis pengetahuan kompleksitas berdasarkan id kasus  
                $data_komplek_id = array();
                foreach (BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->get() as $data_komplek_item) {
                    $data_komplek_id[] = $data_komplek_item->kompleksitas_id; // memasukan id kompleksitas pada array $data_kompleksitas_id[]  
                }

                // mendapatkan id kompleksitas yang diarray sama antara array $req_komplek_id dan $data_komplek_id
                $same_komplek = array_intersect($req_komplek_id, $data_komplek_id);

                // mengambil nilai bobot kompleksitas dari $same_komplek
                $req_komplek_val = array();
                foreach ($same_komplek as $req_komplek_val_item) {
                    $req_komplek_val[] = BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->where('kompleksitas_id', $req_komplek_val_item)->first()->kompleksitas->bobot;
                }
                //mengambil nilai bobot kompleksitas dari $data_komplek_id
                $data_komplek_val = array();
                foreach ($data_komplek_id as $data_komplek_val_item) {
                    $data_komplek_val[] = BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->where('kompleksitas_id', $data_komplek_val_item)->first()->kompleksitas->bobot;
                }

                // menggabungkan id gejala dan id kompleksitas yang didapatkan
                $mergeSW = array_merge($req_gejala_val, $req_komplek_val);
                $mergeW = array_merge($data_gejala_val, $data_komplek_val);
            }

            // Rumus Similarity = Σ $mergeSW / Σ $mergeW

            $totSW = 0; // definisikan variabel untuk Σ $mergeSW
            // sum($mergeSWs)
            foreach ($mergeSW as $mergeSWs) {
                $totSW = $totSW + $mergeSWs;
            }

            $totW = 0; // definisikan variabel untuk Σ $mergeW
            // sum($mergeW)
            foreach ($mergeW as $mergeWs) {
                $totW = $totW + $mergeWs;
            }

            // bagi $totSW dengan $totW untuk mendapatkan hasil similarity
            $result = $totSW / $totW; //hasil similarity

            // set value in variable
            $data_kasus_id = $item->id; 
            $data_penyakit_id = $item->penyakit->id;
            $data_penyakit_name = $item->penyakit->nama;
            $data_penyakit_devinisi = $item->penyakit->definisi;
            $data_penyakit_solusi = $item->penyakit->solusi;
            $data_pasien_name = $item->pasien->nama;
            $data_result = $result;
            $data_same_gejala = $same_gejala;
            $data_same_kompleksitas = $same_komplek;
            $data_kasus_gejala = $data_gejala_id;
            $data_kasus_kompleksitas = $data_komplek_id;

            // masukan semua nilai dari fariabel diatas ke array $result_data
            $result_data[] = [
                'data_kasus_id' => $data_kasus_id,
                'data_penyakit_id' => $data_penyakit_id,
                'data_penyakit_name' => $data_penyakit_name,
                'data_penyakit_devinisi' => $data_penyakit_devinisi,
                'data_penyakit_solusi' => $data_penyakit_solusi,
                'data_pasien_name' => $data_pasien_name,
                'data_result' => $data_result,
                'data_same_gejala' => $data_same_gejala,
                'data_same_kompleksitas' => $data_same_kompleksitas,
                'data_kasus_gejala' => $data_kasus_gejala,
                'data_kasus_kompleksitas' => $data_kasus_kompleksitas,
            ];
        }
        $data_kasus_id;
        $data_penyakit_id;
        $data_penyakit_name;
        $data_penyakit_devinisi;
        $data_penyakit_solusi;
        $data_pasien_name;
        $data_result;
        $data_same_gejala;
        $data_same_kompleksitas;
        $data_kasus_gejala;
        $data_kasus_kompleksitas;
        
        // mendapatkan nilai similiarity tertinggi
        $data_result = 0;
        foreach ($result_data as $record) {
            if ($record['data_result'] > $data_result) {
                $data_kasus_id = $record['data_kasus_id'];
                $data_penyakit_id = $record['data_penyakit_id'];
                $data_penyakit_name = $record['data_penyakit_name'];
                $data_penyakit_devinisi = $record['data_penyakit_devinisi'];
                $data_penyakit_solusi = $record['data_penyakit_solusi'];
                $data_pasien_name = $record['data_pasien_name'];
                $data_result = $record['data_result'];
                $data_same_gejala = $record['data_same_gejala'];
                $data_same_kompleksitas = $record['data_same_kompleksitas'];
                $data_kasus_gejala = $record['data_kasus_gejala'];
                $data_kasus_kompleksitas = $record['data_kasus_kompleksitas'];
            }
        }
        $result_data;

        // sort descending of higher similarity
        $columns = array_column($result_data, 'data_result');
        array_multisort($columns, SORT_DESC, $result_data);

        // create new kasus
        Kasus::create([
            'pasien_id' => $request->pasien_id,
            'user_id' => auth()->user()->id,
            'penyakit_id' => $data_penyakit_id,
            'similarity' => $data_result,
            'status' => 'reuse',
            'keterangan' => 'selesai',
        ]);

        // get id form new kasus
        $get_new_kasus_id = Kasus::orderByDesc('id')->first();

        // if similarity < 0.5
        if ($data_result < 0.5) {
            $get_new_kasus_id->status = 'revise';
            $get_new_kasus_id->keterangan = 'tunggu';
            $get_new_kasus_id->save();
        }

        // jika similarity sama tetapi penyakitnya berbeda akan di ubah menjadi revise
        if (($result_data[0]["data_result"] == $data_result) && ($result_data[0]['data_penyakit_name'] != $data_penyakit_name)) {
            $get_new_kasus_id->status = 'revise';
            $get_new_kasus_id->save();
        }

        // add new gejala 
        foreach ($request->gejala_id as $val_id_gejala) {
            BasisPengetahuan::create([
                'kasus_id' => $get_new_kasus_id->id,
                'gejala_id' => $val_id_gejala,
                'bobot_gejala_id' => BobotGejala::orderBy('bobot', 'asc')->first()->id,
            ]);
        }
        // replace bobot with bobot gejala from case
        foreach ($data_same_gejala as $val_id_gejala_same) {
            $get_kasus_bobot = BasisPengetahuan::where('kasus_id', $data_kasus_id)->where('gejala_id', $val_id_gejala_same)->first();
            $get_set_bobot = BasisPengetahuan::where('kasus_id', $get_new_kasus_id->id)->where('gejala_id', $val_id_gejala_same)->first();
            $get_set_bobot->bobot_gejala_id = $get_kasus_bobot->bobot_gejala_id;
            $get_set_bobot->save();
        }
        // add kompleksitas
        if (!is_null($same_komplek)) {
            foreach ($same_komplek as $req_komplek_val_item) {
                BasisPengetahuanKompleksitas::create([
                    'kasus_id' => $get_new_kasus_id->id,
                    'kompleksitas_id' => $req_komplek_val_item,
                ]);
            }
        }
        //return to hasil_pakar view
        return view('hasil_pakar', [
            'title' => 'Hasil Pakar',
            'pasien_kartu_identitas' => $request->nomor_kartu_identitas,
            'pasien_nama' => $request->nama,
            'pasien_umur' => $request->umur,
            'pasien_phone' => $request->phone,
            'diagnosa_penyakit' => $data_penyakit_name,
            'diagnosa_nilai_similarity' => $data_result,
            'data_penyakit_devinisi' => $data_penyakit_devinisi,
            'data_penyakit_solusi' => $data_penyakit_solusi,
            'gejala' => $request->gejala_id,
            'data_gejala' => Gejala::all(),
            'data_kompleksitas' => BobotKompleksitas::all(),
            'kompleksitas' => $request->kompleksitas_id,
            'kasus' => $result_data,
            'id_kasus' => $get_new_kasus_id,
        ]);
    }

    public function cek_sebagai_revise($id_kasus) // proses mengubah hasil pakar reuse menjadi revise. Proses untuk tombol "cek as revise" yang ada di hasil pakar
    {
        Kasus::where('id', $id_kasus)->update([
            'status' => 'revise',
            'keterangan' => 'tunggu',
        ]);

        return redirect()->route('data_revise');
    }
}
