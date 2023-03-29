<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function autoCode()
    {
        $lates_evidence = Penyakit::orderby('id', 'desc')->first();
        $code = $lates_evidence->kode;
        $order = (int) substr($code, 1, 4);
        $order++;
        $letter = "P";
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
        return view('penyakit.index', [
            'title' => 'Data Penyakit',
            'penyakit' => Penyakit::orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penyakit.create', [
            'title' => 'Data Penyakit',
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
            'nama' => 'required',
            'definisi' => 'required',
            'solusi' => 'required'
        ]);

        Penyakit::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'definisi' => $request->definisi,
            'solusi' => $request->solusi
        ]);

        return redirect()->route('penyakit.index')->with('status', 'Data penyakit berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function show(Penyakit $penyakit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('penyakit.edit',[
            'title' => 'Data Penyakit',
            'kode' => $this->autoCode(),
            'get_penyakit' => Penyakit::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'definisi' => 'required',
            'solusi' => 'required'
        ]);

        Penyakit::where('id', $id)->update([
            'nama' => $request->nama,
            'definisi' => $request->definisi,
            'solusi' => $request->solusi
        ]);

        return redirect()->route('penyakit.index')->with('status', 'Data penyakit berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penyakit::destroy($id);
        return redirect()->route('penyakit.index')->with('status','Data penyakit berhasil dihapus');
    }
}
