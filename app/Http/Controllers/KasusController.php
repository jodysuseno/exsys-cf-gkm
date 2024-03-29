<?php

namespace App\Http\Controllers;

use App\Models\BasisPengetahuan;
use App\Models\BasisPengetahuanKompleksitas;
use App\Models\Gejala;
use App\Models\BobotGejala;
use App\Models\BobotKompleksitas;
use Illuminate\Http\Request;
use App\Models\Kasus;
use App\Models\Pasien;
use App\Models\Penyakit;
use Illuminate\Support\Facades\DB;

class KasusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('basis_pengetahuan.index', [
            'title' => 'Basis Pengetahuan',
            'kasus' => Kasus::orderBy('id', 'desc')->get(),
            // 'kasus' => Kasus::where('status', 'reuse')->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basis_pengetahuan.create', [
            'pasien' => Pasien::orderByDesc('created_at')->get(),
            'gejala' => Gejala::all(),
            'bobot_gejala' => BobotGejala::all(),
            'kompleksitas' => BobotKompleksitas::all(),
            'get_penyakit' => Penyakit::all(),
            'title' => 'Buat Aturan Basis Data '
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required',
            'gejala_id' => 'required|array',
            'gejala_id.*' => 'required',
        ]);

        Kasus::create([
            'pasien_id' => $request->pasien_id,
            'user_id' => auth()->user()->id,
            'penyakit_id' => $request->penyakit_id,
            'similarity' => 1.00,
            'status' => 'reuse',
        ]);

        // get id form new kasus
        $get_new_kasus_id = Kasus::orderByDesc('id')->first()->id;

        // add new gejala 
        foreach ($request->gejala_id as $keyg => $valueg) {
            foreach ($request->bobot_gejala_id as $keyb => $valueb) {
                if ($keyg == $keyb) {
                    BasisPengetahuan::create([
                        'kasus_id' => $get_new_kasus_id,
                        'gejala_id' => $valueg,
                        'bobot_gejala_id' => $valueb,
                    ]);
                }
            }
        }
        // add kompleksitas
        if (!empty($request->kompleksitas_id)) {
            foreach ($request->kompleksitas_id as $req_komplek_val_item) {
                BasisPengetahuanKompleksitas::create([
                    'kasus_id' => $get_new_kasus_id,
                    'kompleksitas_id' => $req_komplek_val_item,
                ]);
            }
        }

        return redirect()->route('kasus.index')->with('status', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_diff_select($basis, $pilihan)
    {
        // mengambil data gejala dari gejala dan di tampung di variabel array $id_gej 
        $id_gej = array();
        foreach ($pilihan as $item) {
            $id_gej[] = $item->id;
        }
        // mengambil data gejala dari basis pengetahuan dan di tampung di variabel array $id_bas 
        $id_bas = array();
        foreach ($basis as $item) {
            $id_bas[] = $item->gejala_id;
        }
        // mengambil data gejala yang tidak ada sama pada antara data gejala dan data basis pengetahuan
        // misal
        // data gejala = [1,2,3,4,5]
        // data basispengetahuan = [1,3,5]
        // hasil setelah menggunakan array_diff() = [2,4]
        $result = array_diff($id_gej, $id_bas);
        return $result;
    }
    public function get_diff_selectk($basis, $pilihan)
    {
        // mengambil data kompleksitas dari kompleksitas dan di tampung di variabel array $id_gej 
        $id_gej = array();
        foreach ($pilihan as $item) {
            $id_gej[] = $item->id;
        }
        // mengambil data kompleksitas dari basis pengetahuan dan di tampung di variabel array $id_bas 
        $id_bas = array();
        foreach ($basis as $item) {
            $id_bas[] = $item->kompleksitas_id;
        }
        // mengambil data kompleksitas yang tidak ada sama pada antara data kompleksitas dan data basis pengetahuan
        // data kompleksitas = [1,2,3,4,5]
        // data basispengetahuan = [1,3,5]
        // hasil setelah menggunakan array_diff() = [2,4]
        $result = array_diff($id_gej, $id_bas);
        return $result;
    }


    public function show($id)
    {

        $gejala = Gejala::all();
        $basis_gejala = BasisPengetahuan::where('kasus_id', $id)->get();
        $kompleksitas = BobotKompleksitas::all();
        $basis_kompleksitas = BasisPengetahuanKompleksitas::where('kasus_id', $id)->get();

        $slc_gejala = $this->get_diff_select($basis_gejala, $gejala);
        $slc_kompleksitas = $this->get_diff_selectk($basis_kompleksitas, $kompleksitas);




        return view('basis_pengetahuan.show', [
            'title' => 'Detail Kasus Pengetahuan',
            'kasus' => Kasus::where('id', $id)->first(),
            'slc_gejala' => $slc_gejala,
            'gejala' => Gejala::all(),
            'bobot_gejala' => BobotGejala::all(),
            'slc_kompleksitas' => $slc_kompleksitas,
            'kompleksitas' => BobotKompleksitas::all(),
            'bp_gejala' => BasisPengetahuan::where('kasus_id', $id)->get(),
            'bp_kompleksitas' => BasisPengetahuanKompleksitas::where('kasus_id', $id)->get()
        ]);
    }

    public function data_revise()
    {
        return view('revise.index', [
            'title' => 'Data revise',
            'kasus' => Kasus::where('status', 'revise')->orderBy('id', 'desc')->get(),
            'gejala' => BasisPengetahuan::all(),
            'kompleksitas' => BasisPengetahuanKompleksitas::all(),
        ]);
    }

    public function detail_revise($id)
    {
        $gejala = Gejala::all();
        $basis_gejala = BasisPengetahuan::where('kasus_id', $id)->get();
        $kompleksitas = BobotKompleksitas::all();
        $basis_kompleksitas = BasisPengetahuanKompleksitas::where('kasus_id', $id)->get();

        $slc_gejala = $this->get_diff_select($basis_gejala, $gejala);
        $slc_kompleksitas = $this->get_diff_selectk($basis_kompleksitas, $kompleksitas);




        return view('revise.show', [
            'title' => 'Data Detail Revise',
            'kasus' => Kasus::where('id', $id)->first(),
            'slc_gejala' => $slc_gejala,
            'gejala' => Gejala::all(),
            'penyakit' => Penyakit::all(),
            'bobot_gejala' => BobotGejala::all(),
            'slc_kompleksitas' => $slc_kompleksitas,
            'kompleksitas' => BobotKompleksitas::all(),
            'bp_gejala' => BasisPengetahuan::where('kasus_id', $id)->get(),
            'bp_kompleksitas' => BasisPengetahuanKompleksitas::where('kasus_id', $id)->get(),
            'note' => Kasus::where('id', $id)->first()->note,
        ]);
    }

    public function save_revise_note(Request $request, $id)
    {
        $get_kasus = Kasus::where('id', $id)->first();
        $get_kasus->penyakit_id = $request->penyakit_id;
        $get_kasus->note = $request->note;
        $get_kasus->keterangan = 'selesai';
        $get_kasus->save();

        return redirect()->route('data_revise');
    }

    public function ubah_keterangan(Request $request, $id)
    {
        Kasus::where('id', $id)->update([
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('data_revise');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kasus::where('id', $id)->get()->each->delete();
        return redirect()->route('kasus.index')->with('status', 'Data kasus berhasil dihapus!');
    }
}
