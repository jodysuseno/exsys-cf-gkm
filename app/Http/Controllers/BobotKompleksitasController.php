<?php

namespace App\Http\Controllers;

use App\Models\BasisPengetahuanKompleksitas;
use App\Models\BobotKompleksitas;
use Illuminate\Http\Request;

class BobotKompleksitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kompleksitas.index', [
            'title' => 'Data Rekam Medis',
            'kompleksitas' => BobotKompleksitas::orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kompleksitas.create', [
            'title' => 'Data Rekam Medis'
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
            'nama' => 'required',
            'bobot' => 'required|numeric'
        ]);

        BobotKompleksitas::create([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('kompleksitas.index')->with('status', 'Data gejala berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BobotKompleksitas  $bobotKompleksitas
     * @return \Illuminate\Http\Response
     */
    public function show(BobotKompleksitas $bobotKompleksitas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BobotKompleksitas  $bobotKompleksitas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('kompleksitas.edit',[
            'title' => 'Data Rekam Medis',
            'get_kompleksitas' => BobotKompleksitas::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BobotKompleksitas  $bobotKompleksitas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required|numeric'
        ]);

        BobotKompleksitas::where('id', $id)->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('kompleksitas.index')->with('status', 'Data gejala berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BobotKompleksitas  $bobotKompleksitas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BasisPengetahuanKompleksitas::where('kompleksitas_id')->delete();
        BobotKompleksitas::destroy($id);
        return redirect()->route('kompleksitas.index')->with('status','Data gejala berhasil dihapus');
    }
}
