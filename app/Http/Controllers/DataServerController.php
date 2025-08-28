<?php

namespace App\Http\Controllers;

use App\Models\DataServer;
use App\Models\DetailPenyedia;
use App\Models\Rakserver;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
use DB;
use Auth;
use Illuminate\Http\Request;

class DataServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Nominatif';
        $subtitle   = 'Server';
        $servers    = DataServer::all();
        $datarak    = Rakserver::all();
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $mitra      = DetailPenyedia::all();
        $alat       = DB::table('data_servers')
                    ->leftJoin('rakservers', 'data_servers.kodeRak', '=', 'rakservers.kodeRak')
                    ->leftJoin('detail_penyedias', 'data_servers.id_mitra', '=', 'detail_penyedias.id_mitra')
                    ->leftJoin('tbkotamas', 'data_servers.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('data_servers.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('data_servers.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('data_servers.*', 'rakservers.namaRak', 'detail_penyedias.nama_mitra', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->get();

        if($alat){
            return view('admin.server.index', compact('title','subtitle', 'servers', 'datarak', 'kotama', 'satuan', 'mitra', 'alat'));
        } else {
            $alat= '';
            return view('admin.server.index', compact('title','subtitle', 'servers', 'datarak', 'kotama', 'satuan', 'mitra', 'alat'));
        }
        // 'kotama'     = Tbkotama::all();
        // 'satuan'     = Tbsatminkal::all();
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
            'serialNumber'  => 'required',
            'merk'          => 'required',
            'model'         => 'required',
            'kapasitas'     => 'nullable|numeric',
            'kodeRak'       => 'required',
            'ip_address'    => 'required|ip',
            'tgl_aktif'     => 'nullable|date',
            'kondisi'       => 'required',
            'sistemOperasi' => 'nullable',
            'status'        => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'peruntukan'    => 'nullable',
            'keterangan'    => 'nullable',
            'id_mitra'      => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        
        $sn = $request->serialNumber;
        $cek = DataServer::where(['serialNumber' => $sn])->first();
        if (!$cek) {
            $validatedData['tgl_aktif'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif)));
            $validatedData['kd_ktm']  = $request->kotama; 
            $validatedData['kd_smkl'] = $request->satuan;
            $simpan = DataServer::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Server berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Server gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Server gagal ditambahkan, karena SERIAL NUMBER sudah ada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $daServer = DataServer::find(id: $id);
        // dd($dasers);
        return response()->json( $daServer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataServer $dataServer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataServer $dataServer)
    {
        $validatedData = $request->validate([
            'serialNumber'  => 'required',
            'merk'          => 'required',
            'model'         => 'required',
            'kapasitas'     => 'nullable|numeric',
            'kodeRak'       => 'required',
            'ip_address'    => 'required|ip',
            'tgl_aktif'     => 'nullable|date',
            'kondisi'       => 'required',
            'sistemOperasi' => 'nullable',
            'status'        => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'peruntukan'    => 'nullable',
            'keterangan'    => 'nullable',
            'id_mitra'      => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        // $validatedData['kd_ktm']  = $request->kotama; 
        // $validatedData['kd_smkl'] = $request->satuan;
        $simpan = DataServer::where('serialNumber', $request->serialNumber)->update([
            'merk' => $request->merk,
            'model' => $request->model,
            'kapasitas' => $request->kapasitas,
            'kodeRak' => $request->kodeRak,
            'ip_address' => $request->ip_address,
            'tgl_aktif' => $request->tgl_aktif,
            'kondisi' => $request->kondisi,
            'sistemOperasi' => $request->sistemOperasi,
            'status' => $request->status,
            'peruntukan' => $request->peruntukan,
            'keterangan' => $request->keterangan,
            'id_mitra' => $request->id_mitra,
            'kd_ktm' => $request->kotama,
            'kd_smkl' => $request->satuan
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
        $daftar = DataServer::findOrFail($id);
        $daftar->delete();
        return redirect('server')->with('success', 'Data berhasil dihapus.'); 
    }
}
