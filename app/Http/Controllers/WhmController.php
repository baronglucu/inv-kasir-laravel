<?php

namespace App\Http\Controllers;

use App\Models\TbWhm;
use Illuminate\Http\Request;
use DB;
use App\Models\Rakserver;
use Auth;

class WhmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Pemeliharaan';
        $subtitle   = 'Data WHM';
        $datawhm    = TbWhm::all();
        $datarak    = Rakserver::all();
        $panel       = DB::table('tb_whms')
                    ->leftJoin('rakservers', 'tb_whms.kodeRak', '=', 'rakservers.kodeRak')
                    ->select('tb_whms.*', 'rakservers.namaRak')
                    ->get();
        if($panel){
            return view('admin.whm.index', compact('title','subtitle', 'datawhm', 'datarak', 'panel'));
        } else {
            $panel= '';
            return view('admin.whm.index', compact('title','subtitle', 'datawhm', 'datarak', 'alat'));
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
            'ip_address'=> 'required|ip',
            'nama_whm'  => 'required',            
            'kodeRak'   => 'required',
            'kapasitas' => 'required',
            'kondisi'   => 'required',
            'tgl_aktif' => 'required|date',
            'tgl_akhir' => 'required|date',
            'lama_ssl'  => 'required',
            'keterangan'=> 'nullable'
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $ipwhm = $request->ip_address;
        $cek = TbWhm::where(['ip_address' => $ipwhm])->first();
        if (!$cek) {
            $validatedData['tgl_aktif'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif)));
            $validatedData['tgl_akhir'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_akhir)));
    
            $simpan = TbWhm::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'cPanel/WHM berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'cPanel/WHM gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'cPanel/WHM gagal ditambahkan, karena IP ADDRESS sudah ada'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $panel = TbWhm::find($id);
        return response()->json( $panel);
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
    public function update(Request $request, string $id)
    {
        $valData = $request->validate([
            'ip_address'=> 'required|ip',
            'nama_whm'  => 'required',            
            'kodeRak'   => 'required',
            'kapasitas' => 'required',
            'kondisi'   => 'required',
            'tgl_aktif' => 'required|date',
            'tgl_akhir' => 'required|date',
            'lama_ssl'  => 'required',
            'keterangan'=> 'nullable'
        ]);
        $valData['user_id'] = Auth::user()->id;
        $simpan = TbWhm::where('id', $request->id)->update([
                'ip_address'=> $request->ip_address,
                'nama_whm'  => $request->nama_whm,
                'kodeRak'   => $request->kodeRak,
                'keterangan'=> $request->keterangan,
                'kapasitas' => $request->kapasitas,
                'tgl_aktif' => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_aktif))),
                'tgl_akhir' => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_akhir))),
                'lama_ssl'  => $request->lama_ssl,
                'kondisi'   => $request->kondisi,
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->nama_whm.' berhasil di Update'
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
    public function destroy(string $id)
    {
        $whm = TbWhm::findOrFail($id);
        $whm->delete();
        // return redirect()->route('whm.index')->with('success', 'cPanel/WHM berhasil dihapus.');
        return redirect()->route('whm.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Dihapus!',
            'text' => 'cPanel/WHM berhasil dihapus.'
        ]);
    }

}
