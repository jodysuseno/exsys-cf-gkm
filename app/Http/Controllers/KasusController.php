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
            'kompleksitas' => BobotKompleksitas::all(),
            'get_penyakit' => Penyakit::all(),
            'title' => 'Buat Aturan Pakar'
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
            'pasien_id' => 'required'
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
        foreach ($request->gejala_id as $val_id_gejala) {
            BasisPengetahuan::create([
                'kasus_id' => $get_new_kasus_id,
                'gejala_id' => $val_id_gejala,
                'bobot_gejala_id' => BobotGejala::orderBy('bobot','asc')->first()->id,
            ]);
        }
        // add kompleksitas
        foreach ($request->kompleksitas_id as $req_komplek_val_item) {
            BasisPengetahuanKompleksitas::create([
                'kasus_id' => $get_new_kasus_id,
                'kompleksitas_id' => $req_komplek_val_item,
            ]);
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
        $id_gej = array();
        foreach ($pilihan as $item) {
            $id_gej[] = $item->id;
        }
        $id_bas = array();
        foreach ($basis as $item) {
            $id_bas[] = $item->gejala_id;
        }
        $result=array_diff($id_gej,$id_bas);
        return $result;
    }
    public function get_diff_selectk($basis, $pilihan)
    {
        $id_gej = array();
        foreach ($pilihan as $item) {
            $id_gej[] = $item->id;
        }
        $id_bas = array();
        foreach ($basis as $item) {
            $id_bas[] = $item->kompleksitas_id;
        }
        $result=array_diff($id_gej,$id_bas);
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




        return view('basis_pengetahuan.show',[
            'title' => 'Detail Kasus Pengetahaun',
            'kasus' => Kasus::where('id',$id)->first(),
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
        return view('revise.index',[
            'title' => 'Data revise',
            'kasus' => Kasus::orderBy('id', 'desc')->orderBy('keterangan', 'desc')->get(),
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




        return view('revise.show',[
            'title' => 'Data Detail Revise',
            'kasus' => Kasus::where('id',$id)->first(),
            'slc_gejala' => $slc_gejala,
            'gejala' => Gejala::all(),
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
        $get_kasus->note = $request->note;
        $get_kasus->save();

        return redirect()->route('detail_revise', $id);
    }

    public function ubah_keterangan(Request $request, $id)
    {
        if ($request->keterangan == 'tunggu') {
            $status = 'revise';
        } else {
            $status = 'reuse';
        }
        Kasus::where('id', $id)->update([
            'keterangan' => $request->keterangan,
            'status' => $status
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
        //
    }
}
