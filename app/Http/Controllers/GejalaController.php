<?php

namespace App\Http\Controllers;

use App\Models\BasisPengetahuan;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{

    public function autoCode()
    {
        $lates_evidence = Gejala::orderby('id', 'desc')->first();
        $code = $lates_evidence->kode;
        $order = (int) substr($code, 1, 4);
        $order++;
        $letter = "G";
        $code = $letter . sprintf("%04s", $order);
        return $code;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gejala.index', [
            'title' => 'Data Gejala',
            'gejala' => Gejala::orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gejala.create', [
            'title' => 'Data Gejala',
            'kode' => $this->autoCode()
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
            'nama' => 'required'
        ]);

        Gejala::create([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);

        return redirect()->route('gejala.index')->with('status', 'Data gejala berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gejala  $gejala
     * @return \Illuminate\Http\Response
     */
    public function show(Gejala $gejala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gejala  $gejala
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('gejala.edit',[
            'title' => 'Data Gejala',
            'kode' => $this->autoCode(),
            'get_gejala' => Gejala::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gejala  $gejala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Gejala::where('id', $id)->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('gejala.index')->with('status', 'Data gejala berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gejala  $gejala
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BasisPengetahuan::where('gejala_id',$id)->delete();
        Gejala::destroy($id);
        return redirect()->route('gejala.index')->with('status','Data gejala berhasil dihapus');
    }
}
