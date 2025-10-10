<?php

namespace App\Http\Controllers;

use App\Models\Rakserver;
use App\Models\Tbjenisrak;
use App\Models\DataPerangkat;
use App\Models\tbmodelraks;
use Auth;
use DB;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Group;

class RakserverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Pemeliharaan';
        $subtitle   = 'Rak Server';
        // $datarak    = Rakserver::all();
        $jnsrak     = Tbjenisrak::all();
        $modrak     = tbmodelraks::all();
        $dperang    = DataPerangkat::all();

        $perangkat = DB::table('data_perangkats')->get()->groupBy('kodeRak');

        // $datarak    = DB::table('rakservers')
        //             ->leftJoin('tbjenisraks', 'rakservers.kdjenis', '=', 'tbjenisraks.kdjenis')
        //             ->leftJoin('tbmodelraks', 'rakservers.kdmodel', '=', 'tbmodelraks.kdmodel')
        //             ->leftjoin('data_perangkats', 'rakservers.kodeRak', '=', 'data_perangkats.kodeRak')
        //             ->select('rakservers.*',
        //             'tbmodelraks.namaModel', 
        //             'data_perangkats.serialNumber', 
        //             'data_perangkats.merk', 
        //             'data_perangkats.model', 
        //             'data_perangkats.kapasitas as kapasitasPerangkat', 
        //             'tbjenisraks.namaJenis',
        //             DB::raw('(SELECT COUNT(*) FROM data_perangkats WHERE data_perangkats.kodeRak = rakservers.kodeRak) as jml'
        //             ))
        //             ->get();
         $datarak    = DB::table('rakservers')
                    ->leftJoin('tbjenisraks', 'rakservers.kdjenis', '=', 'tbjenisraks.kdjenis')
                    ->leftJoin('tbmodelraks', 'rakservers.kdmodel', '=', 'tbmodelraks.kdmodel')
                    ->select('rakservers.*',
                    'tbmodelraks.namaModel', 
                    'tbjenisraks.namaJenis',
                    DB::raw('(SELECT COUNT(*) FROM data_perangkats WHERE data_perangkats.kodeRak = rakservers.kodeRak) as jml'
                    ))
                    ->get();

            if($datarak){
                return view('admin.rakserver.index', compact('title','subtitle', 'datarak', 'jnsrak', 'modrak', 'perangkat'));
            } else {
                $datarak= '';
                return view('admin.rakserver.index', compact('title','subtitle', 'datarak', 'jnsrak','modrak', 'perangkat'));
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
            'kodeRak'       => 'required',
            'namaRak'       => 'required',
            'model'         => 'required',
            'kdjenis'       => 'required',
            'kapasitas'     => 'required|numeric',
            'keterangan'    => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        
        $sn = $request->kodeRak;
        $cek = Rakserver::where(['kodeRak' => $sn])->first();
        if (!$cek) {
            $simpan = Rakserver::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Rak Server berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Rak Server gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Rak Server gagal ditambahkan, karena Kode Rak sudah ada'
            ]);
        }
    }

    public function getModel($kdjenis)
    {
        $kdmodel = tbmodelraks::where('kdjenis', $kdjenis)->get();
        return response()->json($kdmodel);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = DB::table('rakservers')
                ->leftJoin('tbjenisraks', 'rakservers.kdjenis', '=', 'tbjenisraks.kdjenis')
                ->leftJoin('tbmodelraks', 'rakservers.kdmodel', '=', 'tbmodelraks.kdmodel')
                ->select('rakservers.*',
                'tbmodelraks.namaModel', 
                'tbjenisraks.namaJenis',
                DB::raw('(SELECT COUNT(*) FROM data_perangkats WHERE data_perangkats.kodeRak = rakservers.kodeRak) as jml'
                ))
                ->get();
        return response()->json( $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'kodeRak'       => 'required',
            'namaRak'       => 'required',
            'model'         => 'required',
            'kdjenis'       => 'required',
            'kapasitas'     => 'required|numeric',
            'keterangan'    => 'nullable'            
        ]);
        
        $validatedData['user_id'] = Auth::user()->id;
        $simpan = Rakserver::where('id', $request->id)->update([
            'namaRak'    => $request->namaRak,
            'model'      => $request->model,
            'kdjenis'    => $request->kdjenis,
            'kapasitas'  => $request->kapasitas,
            'keterangan' => $request->keterangan
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nama Rak Server : '.$request->namaRak.' berhasil di Update'
            ]);
        } else {
            return response()->json([
                'status' => 500, 
                'pesan' => 'Rak Server GAGAL di Update'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $daftar = Rakserver::findOrFail(id: $id);
        $daftar->delete();
        return redirect('rakserver')->with('success', 'Data berhasil dihapus.');
    }
}
