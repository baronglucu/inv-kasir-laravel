<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Rakserver;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
use App\Models\TbWhm;
use Auth;
use DB;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Nominatif';
        $subtitle   = 'Domain di Data Center';
        $domains    = Domain::all();
        $whm        = TbWhm::all();
        // $datarak    = Rakserver::all();
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $alat       = DB::table('domains')
                    ->leftJoin('tb_whms', 'domains.id_whm', '=', 'tb_whms.id')
                    ->leftJoin('tbkotamas', 'domains.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', 'domains.kd_smkl', '=', 'tbsatminkals.idsmkl')
                    ->select('domains.*', 'tb_whms.nama_whm', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->get();

        if($alat){
            return view('admin.domain.index', compact('title','subtitle', 'domains', 'whm', 'kotama', 'satuan', 'alat'));
        } else {
            $alat= '';
            return view('admin.domain.index', compact('title','subtitle', 'domains', 'whm', 'kotama', 'satuan', 'alat'));
        }
    }

    public function getSatuan($kd_ktm)
    {
        $satuan = Tbsatminkal::where('kd_ktm', $kd_ktm)->get();
        return response()->json($satuan);
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
            'nama_domain'   => 'required',
            'hosting'       => 'required',
            'framework'     => 'nullable',
            'status'        => 'required',
            'id_whm'        => 'required',
            'tgl_aktif'     => 'nullable|date',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'keterangan'    => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        
        $sn = $request->nama_domain;
        $cek = Domain::where(['nama_domain' => $sn])->first();
        if (!$cek) {
            $validatedData['tgl_aktif'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif)));
            $validatedData['kd_ktm']  = $request->kotama; 
            $validatedData['kd_smkl'] = $request->satuan;
            $simpan = Domain::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Domain berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Domain gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Domain gagal ditambahkan, karena SERIAL NUMBER sudah ada'
            ]);
        }
    }
 
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $dadom = Domain::find(id: $id);
        $dadom       = DB::table('domains')
                    ->leftJoin('tb_whms', 'domains.id_whm', '=', 'tb_whms.id')
                    ->leftJoin('tbkotamas', 'domains.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', 'domains.kd_smkl', '=', 'tbsatminkals.idsmkl')
                    ->where('domains.id','=',$id)
                    ->select('domains.*', 'tb_whms.nama_whm', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->get();
        return response()->json( $dadom);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nama_domain'   => 'required',
            'hosting'       => 'required',
            'framework'     => 'nullable',
            'status'        => 'required',
            'id_whm'        => 'required',
            'tgl_aktif'     => 'nullable|date',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'keterangan'    => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        // $validatedData['kd_ktm']  = $request->kotama; 
        // $validatedData['kd_smkl'] = $request->satuan;
        $simpan = Domain::where('nama_domain', $request->nama_domain)->update([
            'hosting' => $request->hosting,
            'framework' => $request->framework,
            'status' => $request->status,
            'id_whm' => $request->id_whm,
            'tgl_aktif' => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif))),
            'keterangan' => $request->keterangan,
            'kd_ktm' => $request->kotama,
            'kd_smkl' => $request->satuan
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nama Domain : '.$request->nama_domain.' berhasil di Update'
            ]);
        } else {
            return response()->json([
                'status' => 500, 
                'pesan' => 'Domain GAGAL di Update'
            ]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $daftar = Domain::findOrFail($id);
        $daftar->delete();
        return redirect('server')->with('success', 'Data berhasil dihapus.');
    }
}
