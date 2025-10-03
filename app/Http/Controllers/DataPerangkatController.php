<?php

namespace App\Http\Controllers;

use App\Models\DataPerangkat;
use App\Models\DetailPenyedia;
use App\Models\Domain;
use App\Models\Rakserver;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
use App\Models\Tbjenis;
use App\Models\DataAplSisfo;
use DB;
use Auth;
use Illuminate\Http\Request;

class DataPerangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Nominatif';
        $subtitle   = 'Perangkat';
        $servers    = DataPerangkat::all();
        $datarak    = Rakserver::all();
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $aplsisfo   = DataAplSisfo::all();
        $jenis      = Tbjenis::all();
        $domain     = Domain::all();
        $mitra      = DetailPenyedia::all();
        $alat       = DB::table('data_perangkats')
                    ->leftJoin('rakservers', 'data_perangkats.kodeRak', '=', 'rakservers.kodeRak')
                    ->leftJoin('detail_penyedias', 'data_perangkats.id_mitra', '=', 'detail_penyedias.id_mitra')
                    ->leftJoin('data_apl_sisfos', 'data_perangkats.id_apl', '=', 'data_apl_sisfos.id_apl')
                    ->leftJoin('tbjenis', 'data_perangkats.kode_jns', '=', 'tbjenis.kode_jns')
                    ->leftJoin('tbkotamas', 'data_perangkats.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('data_perangkats.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('data_perangkats.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('data_perangkats.*', 'rakservers.namaRak', 'detail_penyedias.nama_mitra', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl', 'data_apl_sisfos.nama_apl', 'tbjenis.nama_jns')
                    ->get();

        if($alat){
            return view('admin.perangkat.index', compact('title','subtitle', 'servers', 'datarak', 'kotama', 'satuan', 'mitra', 'jenis', 'alat', 'aplsisfo'));
        } else {
            $alat= '';
            return view('admin.perangkat.index', compact('title','subtitle', 'servers', 'datarak', 'kotama', 'satuan', 'mitra', 'jenis', 'alat', 'aplsisfo'));
        }
    }

    public function getSatuan($kd_ktm)
    {
        $satuan = Tbsatminkal::where('kd_ktm', $kd_ktm)->get();
        return response()->json($satuan);
    }

    public function getDomain($kd_smkl)
    {
        $domain = Domain::where('kd_smkl', $kd_smkl)->get();
        return response()->json($domain);
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
            'serialNumber'  => 'required',
            'merk'          => 'required',
            'model'         => 'required',
            'kapasitas'     => 'nullable',
            'storage'       => 'nullable',
            'kode_jns'      => 'nullable',
            'kodeRak'       => 'required',
            'ip_address'    => 'nullable|ip',
            'tgl_aktif'     => 'nullable|date',
            'kondisi'       => 'required',
            'sistemOperasi' => 'nullable',
            'status'        => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'peruntukan'    => 'nullable',
            'id_mitra'      => 'nullable',
            'id_apl'        => 'nullable',
            'keterangan'    => 'nullable'           
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        
        $sn = $request->serialNumber;
        $cek = DataPerangkat::where(['serialNumber' => $sn])->first();
        if (!$cek) {
            $validatedData['tgl_aktif'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif)));
            $validatedData['kd_ktm']  = $request->kotama; 
            $validatedData['kd_smkl'] = $request->satuan;
            $simpan = DataPerangkat::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Data perangkat berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Data perangkat gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Data perangkat gagal ditambahkan, karena SERIAL NUMBER sudah ada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $daServer   = DB::table('data_perangkats')
                    ->leftJoin('rakservers', 'data_perangkats.kodeRak', '=', 'rakservers.kodeRak')
                    ->leftJoin('detail_penyedias', 'data_perangkats.id_mitra', '=', 'detail_penyedias.id_mitra')
                    ->leftJoin('data_apl_sisfos', 'data_perangkats.id_apl', '=', 'data_apl_sisfos.id_apl')
                    ->leftJoin('tbjenis', 'data_perangkats.kode_jns', '=', 'tbjenis.kode_jns')
                    ->leftJoin('tbkotamas', 'data_perangkats.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('data_perangkats.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('data_perangkats.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->where('data_perangkats.id', '=', $id)
                    ->select('data_perangkats.*', 'rakservers.namaRak', 'detail_penyedias.nama_mitra', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl', 'data_apl_sisfos.nama_apl', 'tbjenis.nama_jns')                    
                    ->get();
        return response()->json( $daServer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPerangkat $dataPerangkat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPerangkat $dataPerangkat)
    {
        $validatedData = $request->validate([
            'serialNumber'  => 'required',
            'merk'          => 'required',
            'model'         => 'required',
            'kapasitas'     => 'nullable',
            'storage'       => 'nullable',
            'kode_jns'      => 'nullable',
            'kodeRak'       => 'required',
            'ip_address'    => 'nullable|ip',
            'tgl_aktif'     => 'nullable|date',
            'kondisi'       => 'required',
            'sistemOperasi' => 'nullable',
            'status'        => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'peruntukan'    => 'nullable',
            'id_mitra'      => 'nullable',
            'id_apl'        => 'nullable',
            'keterangan'    => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        // $validatedData['kd_ktm']  = $request->kotama; 
        // $validatedData['kd_smkl'] = $request->satuan;
        $simpan = DataPerangkat::where('serialNumber', $request->serialNumber)->update([
            'merk'          => $request->merk,
            'model'         => $request->model,
            'kapasitas'     => $request->kapasitas,
            'storage'       => $request->storage,
            'kode_jns'      => $request->kode_jns,
            'kodeRak'       => $request->kodeRak,
            'ip_address'    => $request->ip_address,
            'tgl_aktif'     => $request->tgl_aktif,
            'kondisi'       => $request->kondisi,
            'sistemOperasi' => $request->sistemOperasi,
            'status'        => $request->status,
            'peruntukan'    => $request->peruntukan,            
            'id_mitra'      => $request->id_mitra,
            'id_apl'        => $request->id_apl,
            'kd_ktm'        => $request->kotama,
            'kd_smkl'       => $request->satuan,
            'keterangan'    => $request->keterangan
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->serialNumber.' berhasil di Update'
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
        $daftar = DataPerangkat::findOrFail($id);
        $daftar->delete();
        return redirect('server')->with('success', 'Data berhasil dihapus.'); 
    }
}
