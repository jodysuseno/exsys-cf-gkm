<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index()
    {
        return view('user.index', [
            'title' => 'Data Admin',
            'role' => 'admin',
            'user' => User::where('role', 'admin')->orderByDesc('created_at')->get(),
        ]);
    }
    public function pakar_index()
    {
        return view('user.index', [
            'title' => 'Data Pakar',
            'role' => 'pakar',
            'user' => User::where('role', 'pakar')->orderByDesc('created_at')->get(),
        ]);
    }
    public function perawat_index()
    {
        return view('user.index', [
            'title' => 'Data Perawat',
            'role' => 'perawat',
            'user' => User::where('role', 'perawat')->orderByDesc('created_at')->get(),
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
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6',
            'repassword' => 'required|min:6|same:password|max:100',
            'nip' => 'required|numeric|max_digits:100',
            'phone' => 'required|numeric|min_digits:12|max_digits:15',
        ]);

        // dd($request);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nama' => $request->nama,
            'nip' => $request->nip,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        if ($request->role == 'admin') {
            $rt = 'admin_index';
        } else if($request->role == 'pakar'){
            $rt = 'pakar_index';
        } else if($request->role == 'perawat'){
            $rt = 'perawat_index';
        }
        

        return redirect()->route($rt)->with('status', 'Data berhasil disimpan');

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
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:100',
            'nip' => 'required|numeric|max_digits:100',
            'phone' => 'required|numeric|min_digits:12|max_digits:15',
        ]);
        
        if($request->password == ''){
            $password = User::findOrFail($id)->password;
        } else {
            $password = bcrypt($request->password);
        }

        User::where('id', $id)->update([
            'email' => $request->email,
            'password' => $password,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'phone' => $request->phone,
        ]);

        if ($request->role == 'admin') {
            $rt = 'admin_index';
        } else if($request->role == 'pakar'){
            $rt = 'pakar_index';
        } else if($request->role == 'perawat'){
            $rt = 'perawat_index';
        }
        

        return redirect()->route($rt)->with('status', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $getrole = User::findOrFail($id);
        User::destroy($id);
        
        if ($getrole->role == 'admin') {
            $rt = 'admin_index';
        } else if($getrole->role == 'pakar'){
            $rt = 'pakar_index';
        } else if($getrole->role == 'perawat'){
            $rt = 'perawat_index';
        }
        
        return redirect()->route($rt)->with('status','Data berhasil di hapus');
    }
}
