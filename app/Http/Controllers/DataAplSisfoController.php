<?php

namespace App\Http\Controllers;

use App\Models\DataAplSisfo;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
use App\Models\DetailPenyedia;
use DB;
use Auth;
use Illuminate\Http\Request;

class DataAplSisfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Nominatif';
        $subtitle   = 'Aplikasi/Sisfo';
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $mitra      = DetailPenyedia::all();
        $dataapl    = DB::table('data_apl_sisfos')
                    ->leftJoin('detail_penyedias', 'data_apl_sisfos.id_mitra', '=', 'detail_penyedias.id_mitra')
                    ->leftJoin('tbkotamas', 'data_apl_sisfos.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('data_apl_sisfos.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('data_apl_sisfos.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('data_apl_sisfos.*', 'detail_penyedias.nama_mitra', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->get();

        if($dataapl){
            return view('admin.aplsisfo.index', compact('title','subtitle', 'kotama', 'satuan', 'mitra', 'dataapl'));
        } else {
            $dataapl= '';
            return view('admin.aplsisfo.index', compact('title','subtitle', 'kotama', 'satuan', 'mitra', 'dataapl'));
        }
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
            'id_apl'        => 'required',
            'nama_apl'      => 'required',
            'ip_add'        => 'required|ip',
            'thn_ada'       => 'nullable|numeric',
            'status'        => 'required',
            'nm_dom'        => 'nullable',
            'tgl_aktif'     => 'nullable|date',
            'lkt'           => 'nullable',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'jaringan'      => 'nullable',
            'fungsi'        => 'nullable',
            'id_mitra'      => 'required',
            'keterangan'    => 'nullable'                        
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        
        $ida = $request->id_apl;
        $cek = DataAplSisfo::where(['id_apl' => $ida])->first();
        if (!$cek) {
            $validatedData['tgl_aktif'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif)));
            $validatedData['kd_ktm']  = $request->kotama; 
            // $validatedData['kd_smkl'] = $request->satuan;
            if($request->satuan === '' ? $validatedData['kd_smkl']='000000' : $validatedData['kd_smkl'] = $request->satuan);
            $simpan = DataAplSisfo::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Aplikasi/Sisfo berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Aplikasi/Sisfo gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Aplikasi/Sisfo gagal ditambahkan, karena ID APLIKASI sudah ada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DataAplSisfo $dataAplSisfo)
    {
        $dataapl    = DB::table('data_apl_sisfos')
                    ->leftJoin('detail_penyedias', 'data_apl_sisfos.id_mitra', '=', 'detail_penyedias.id_mitra')
                    ->leftJoin('tbkotamas', 'data_apl_sisfos.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('data_apl_sisfos.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('data_apl_sisfos.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('data_apl_sisfos.*', 'detail_penyedias.nama_mitra', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->get();

         return response()->json($dataapl);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataAplSisfo $dataAplSisfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataAplSisfo $dataAplSisfo)
    {
        $validatedData = $request->validate([
            'id_apl'        => 'required',
            'nama_apl'      => 'required',
            'ip_add'        => 'required|ip',
            'thn_ada'       => 'nullable|numeric',
            'status'        => 'required',
            'nm_dom'        => 'nullable',
            'tgl_aktif'     => 'nullable|date',
            'lkt'           => 'nullable',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'jaringan'      => 'nullable',
            'fungsi'        => 'nullable',
            'id_mitra'      => 'required',
            'keterangan'    => 'nullable'                        
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $simpan = DataAplSisfo::where('id', $request->id)->update([
                'id_apl'        => $request->id_apl,
                'kd_ktm'        => $request->kotama,
                'kd_smkl'       => $request->satuan,
                'nama_apl'      => $request->nama_apl,
                'tgl_aktif'     => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif))),               
                'ip_add'        => $request->ip_add,
                'thn_ada'       => $request->thn_ada,
                'nm_dom'        => $request->nm_dom,
                'status'        => $request->status,
                'lkt'           => $request->lkt,
                'jaringan'      => $request->jaringan,
                'fungsi'        => $request->fungsi,
                'id_mitra'      => $request->id_mitra,
                'keterangan'    => $request->keterangan 
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->id_apl.' berhasil di Update'
            ]);
        } else {
            return response()->json([
                'status' => 500, 
                'pesan' => 'Nomor GAGAL di Update'
            ]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataAplSisfo $dataAplSisfo)
    {
        //
    }
}
