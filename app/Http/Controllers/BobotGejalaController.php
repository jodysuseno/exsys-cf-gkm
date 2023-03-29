<?php

namespace App\Http\Controllers;

use App\Models\BobotGejala;
use Illuminate\Http\Request;

class BobotGejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bobot_gejala.index', [
            'title' => 'Data Bobot Gejala',
            'bobot_gejala' => BobotGejala::orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bobot_gejala.create', [
            'title' => 'Data Bobot Gejala'
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

        BobotGejala::create([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('bobot_gejala.index')->with('status', 'Data gejala berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BobotGejala  $bobotGejala
     * @return \Illuminate\Http\Response
     */
    public function show(BobotGejala $bobotGejala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BobotGejala  $bobotGejala
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('bobot_gejala.edit',[
            'title' => 'Data Bobot Gejala',
            'get_bobot_gejala' => BobotGejala::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BobotGejala  $bobotGejala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'bobot' => 'required|numeric'
        ]);

        BobotGejala::where('id', $id)->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('bobot_gejala.index')->with('status', 'Data gejala berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BobotGejala  $bobotGejala
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BobotGejala::destroy($id);
        return redirect()->route('bobot_gejala.index')->with('status','Data gejala berhasil dihapus');
    }
}
