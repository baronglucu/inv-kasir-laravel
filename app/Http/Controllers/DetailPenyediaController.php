<?php

namespace App\Http\Controllers;

use App\Models\DetailPenyedia;
use Auth;
use Illuminate\Http\Request;

class DetailPenyediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Mitra';
        $subtitle   = 'Data Mitra';
        $datamitra  = DetailPenyedia::all();
        return view('admin.mitra.index', compact('title','subtitle', 'datamitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_mitra'      => 'required',
            'nama_mitra'    => 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'provinsi'      => 'required',
            'notelp'        => 'required_without:email|nullable',
            'email'         => 'required_without:notelp|nullable|email',
            'alamat_web'    => 'required_without:email|nullable',
            'nama_pimpinan' => 'nullable',
            'nohp_pimpinan' => 'nullable',
            'email_pimpinan'=> 'nullable',
            'npwp'          => 'nullable',
            'siup'          => 'nullable',
            'keterangan'    => 'nullable'
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        // dd($validatedData);
        $im = $request->id_mitra;
        $cek = DetailPenyedia::where(['id_mitra' => $im])->first();
        if (!$cek) {
            $simpan = DetailPenyedia::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Mitra berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Mitra gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Data gagal ditambahkan, karena ID MITRA sudah ada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mitras = DetailPenyedia::find(id: $id);
        // dd($mitras);
        return response()->json( $mitras);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title      = 'Data Mitra';
        $subtitle   = 'Edit';
        $mitras     = DetailPenyedia::find($id);
        return view('admin.mitra.edit', compact('title','subtitle', 'mitras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPenyedia $detailPenyedia)
    {
        $valData = $request->validate([
            'id_mitra'      => 'required',
            'nama_mitra'    => 'required',
            'alamat'        => 'required',
            'kota'          => 'required',
            'provinsi'      => 'required',
            'notelp'        => 'required_without:email|nullable',
            'email'         => 'required_without:notelp|nullable|email',
            'alamat_web'    => 'required_without:email|nullable',
            'nama_pimpinan' => 'nullable',
            'nohp_pimpinan' => 'nullable',
            'email_pimpinan'=> 'nullable',
            'npwp'          => 'nullable',
            'siup'          => 'nullable',
            'keterangan'    => 'nullable'
        ]);
        $valData['user_id'] = Auth::user()->id;
        $simpan = DetailPenyedia::where('id_mitra', $request->id_mitra)->update([
                'nama_mitra' => $request->nama_mitra,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'notelp' => $request->notelp,
                'email' => $request->email,
                'alamat_web' => $request->alamat_web,
                'nama_pimpinan' => $request->nama_pimpinan,
                'nohp_pimpinan' => $request->nohp_pimpinan,
                'email_pimpinan' => $request->email_pimpinan,
                'npwp' => $request->npwp,
                'siup' => $request->siup,
                'keterangan' => $request->keterangan,
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->id_mitra.' berhasil di Update'
            ]);
        } else {
            return response()->json([
                'status' => 500, 
                'pesan' => 'Nomor  GAGAL di Update'
            ]);
        }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $daftar = DetailPenyedia::findOrFail($id);
        $daftar->delete();
        return redirect('mitra')->with('success', 'Data berhasil dihapus.'); 
    }
}
