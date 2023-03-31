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
            'kasus' => Kasus::where('status', 'reuse')->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
