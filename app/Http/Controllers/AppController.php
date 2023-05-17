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
    public function dashboard()
    {
        return view('dashboard', [
            'title' => 'dashboard',
            'user' => User::orderByDesc('created_at')->get(),
            'kasus' => Kasus::orderByDesc('created_at')->get(),
            'penyakit' => Penyakit::orderByDesc('created_at')->get(),
            'cnt_user_admin' => User::where('role', 'admin')->count(),
            'cnt_user_pakar' => User::where('role', 'pakar')->count(),
            'cnt_user_perawat' => User::where('role', 'perawat')->count(),
            'cnt_pasien' => Pasien::count(),
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

    public function sistem_pakar()
    {
        return view('sistem_pakar', [
            'pasien' => Pasien::orderByDesc('created_at')->get(),
            'gejala' => Gejala::all(),
            'kompleksitas' => BobotKompleksitas::all(),
            'title' => 'Sistem Pakar'
        ]);
    }

    public function hasil_pakar(Request $request)
    {

        $request->validate([
            'pasien_id' => 'required',
            // 'gejala_id' => 'required|array|min:1'
        ]);

        // get data kasus
        $kasus = Kasus::where('status', 'reuse')->get();
        //set array variabel
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
        // loop data kasus
        foreach ($kasus as $item) {
            // req gejala
            $req_gejala_id = array();
            foreach ($request->gejala_id as $req_gejala_item) {
                $req_gejala_id[] = $req_gejala_item;
            }
            // data gejala
            $data_gejala_id = array();
            foreach (BasisPengetahuan::where('kasus_id', $item->id)->get() as $data_gejala_item) {
                $data_gejala_id[] = $data_gejala_item->gejala_id;
            }
            // get same id form request and kasus
            $same_gejala = array_intersect($req_gejala_id, $data_gejala_id);

            //get req bobot gejala value
            $req_gejala_val = array();
            foreach ($same_gejala as $req_gejala_val_item) {
                $req_gejala_val[] = BasisPengetahuan::where('kasus_id', $item->id)->where('gejala_id', $req_gejala_val_item)->first()->bobot_gejala->bobot;
            }
            //get data bobot gejala value
            $data_gejala_val = array();
            foreach ($data_gejala_id as $data_gejala_val_item) {
                $data_gejala_val[] = BasisPengetahuan::where('kasus_id', $item->id)->where('gejala_id', $data_gejala_val_item)->first()->bobot_gejala->bobot;
            }
            // count similarity
            // merge data from gejala and kompleksitas
            
            if (is_null($request->kompleksitas_id)) {
                $mergeSW = $req_gejala_val;
                $mergeW = $data_gejala_val;
                $same_komplek = null;
                $data_komplek_id = null;
            } else {
                // req komplek
                $req_komplek_id = array();
                foreach ($request->kompleksitas_id as $req_komplek_item) {
                    $req_komplek_id[] = $req_komplek_item;
                }
                // data komplek
                $data_komplek_id = array();
                foreach (BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->get() as $data_komplek_item) {
                    $data_komplek_id[] = $data_komplek_item->kompleksitas_id;
                }

                // get same id form request and kasus
                $same_komplek = array_intersect($req_komplek_id, $data_komplek_id);

                //get req bobot kompleksitas value
                $req_komplek_val = array();
                foreach ($same_komplek as $req_komplek_val_item) {
                    $req_komplek_val[] = BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->where('kompleksitas_id', $req_komplek_val_item)->first()->kompleksitas->bobot;
                }
                //get data bobot kompleksitas value
                $data_komplek_val = array();
                foreach ($data_komplek_id as $data_komplek_val_item) {
                    $data_komplek_val[] = BasisPengetahuanKompleksitas::where('kasus_id', $item->id)->where('kompleksitas_id', $data_komplek_val_item)->first()->kompleksitas->bobot;
                }
                $mergeSW = array_merge($req_gejala_val, $req_komplek_val);
                $mergeW = array_merge($data_gejala_val, $data_komplek_val);
            }

            // $mergeSW = array_merge($req_gejala_val, $req_komplek_val);
            
            $totSW = 0;
            // count SW
            foreach ($mergeSW as $mergeSWs) {
                $totSW = $totSW + $mergeSWs;
            }
            // $mergeW = array_merge($data_gejala_val, $data_komplek_val);
            $totW = 0;
            // count W
            foreach ($mergeW as $mergeWs) {
                $totW = $totW + $mergeWs;
            }
            // devide SW and W
            
            $result = $totSW / $totW;
            // dd($result);

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

            // include variable to array
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

        // sort descending of higher similarity
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
        $columns = array_column($result_data, 'data_result');
        array_multisort($columns, SORT_DESC, $result_data);

        // difine status base similarity value
        if ($data_result < 0.5) {
            $get_status = 'revise';
        } else {
            $get_status = 'reuse';
        }
        
        // create new kasus
        Kasus::create([
            'pasien_id' => $request->pasien_id,
            'user_id' => auth()->user()->id,
            'penyakit_id' => $data_penyakit_id,
            'similarity' => $data_result,
            'status' => $get_status,
            'keterangan' => 'selesai',
        ]);

        // get id form new kasus
        $get_new_kasus_id = Kasus::orderByDesc('id')->first();

        // add new gejala 
        foreach ($request->gejala_id as $val_id_gejala) {
            BasisPengetahuan::create([
                'kasus_id' => $get_new_kasus_id->id,
                'gejala_id' => $val_id_gejala,
                'bobot_gejala_id' => BobotGejala::orderBy('bobot','asc')->first()->id,
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

    public function cek_sebagai_revise($id_kasus)
    {
        Kasus::where('id', $id_kasus)->update([
            'status' => 'revise',
            'keterangan' => 'tunggu',
        ]);

        return redirect()->route('data_revise');
    }
}
