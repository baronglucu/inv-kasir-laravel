<?php

namespace App\Http\Controllers;

use App\Models\Rakserver;
use App\Models\Tbjenisrak;
use Auth;
use DB;
use Illuminate\Http\Request;

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
        $datarak    = DB::table('rakservers')
                    ->leftJoin('tbjenisraks', 'rakservers.kdjenis', '=', 'tbjenisraks.kdjenis')
                    ->select('rakservers.*', 'tbjenisraks.namaJenis')
                    ->get();

            if($datarak){
                return view('admin.rakserver.index', compact('title','subtitle', 'datarak', 'jnsrak'));
            } else {
                $datarak= '';
                return view('admin.rakserver.index', compact('title','subtitle', 'datarak', 'jnsrak'));
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Rakserver::find($id);
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
