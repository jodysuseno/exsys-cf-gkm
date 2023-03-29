<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pasien.index', [
            'title' => 'Data Pasien',
            'pasien' => Pasien::orderByDesc('created_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pasien.create', [
            'title' => 'Data Pasien',
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
            'nomor_kartu_identitas' => 'required|numeric|unique:pasiens',
            'nama' => 'required',
            'umur' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:12,15',
        ]);

        Pasien::create([
            'nomor_kartu_identitas' => $request->nomor_kartu_identitas,
            'nama' => $request->nama,
            'umur' => $request->umur,
            'phone' => $request->phone,
        ]);
        
        return redirect()->route('pasien.index')->with('success', 'Data berhasil tersimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pasien.edit',[
            'title' => 'Data Pasien',
            'get_pasien' => Pasien::findOrFail($id)
        ]);
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
        $request->validate([
            'nomor_kartu_identitas' => 'required|numeric',
            'nama' => 'required',
            'umur' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:12,15',
        ]);

        Pasien::where('id', $id)->update([
            'nomor_kartu_identitas' => $request->nomor_kartu_identitas,
            'nama' => $request->nama,
            'umur' => $request->umur,
            'phone' => $request->phone,
        ]);
        
        return redirect()->route('pasien.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pasien::destroy($id);
        return redirect()->route('gejala.index')->with('status','Data berhasil dihapus');
    }
}
