<?php

namespace App\Http\Controllers;

use App\Models\LogProduk;
use App\Models\Produk;
use App\Models\Rakserver;
use Auth;
use Illuminate\Http\Request;
use DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Nominatif';
        $subtitle   = 'Produk';
        $produks    = Produk::all();
        $datarak    = Rakserver::all();
        $alat       = DB::table('produks')
                    ->leftJoin('rakservers', 'produks.kodeRak', '=', 'rakservers.kodeRak')
                    ->select('produks.id', 'produks.serialNumber', 'produks.namaProduk', 'produks.tgl_pengadaan', 'produks.deskripsi', 'produks.kodeRak', 'produks.kondisi', 'rakservers.namaRak')
                    ->get();
        if($alat){
            return view('admin.produk.index', compact('title','subtitle', 'produks', 'datarak', 'alat'));
        } else {
            $alat= '';
            return view('admin.produk.index', compact('title','subtitle', 'produks', 'datarak', 'alat'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title      = 'Produk';
        $subtitle   = 'Tambah';
        return view('admin.produk.create',compact('title','subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'serialNumber'  => 'required',
            'namaProduk'    => 'required',
            'kodeRak'       => 'required',
            'deskripsi'     => 'nullable',
            'tgl_pengadaan' => 'required|date',
            'kondisi'       => 'required'
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $sn = $request->serialNumber;
        $cek = Produk::where(['serialNumber' => $sn])->first();
        if (!$cek) {
            $validatedData['tgl_pengadaan'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_pengadaan)));
    
            $simpan = Produk::create($validatedData);
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Produk berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Produk gagal ditambahkan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500, 
                'message' => 'Produk gagal ditambahkan, karena SERIAL NUMBER sudah ada'
            ]);
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $produks = Produk::find($id);
        // return response()->json( $produks);
        
        $produks    = DB::table('produks')
                    ->leftJoin('rakservers', 'produks.kodeRak', '=', 'rakservers.kodeRak')
                    ->where('produks.id','=',$id)
                    ->select('produks.*', 'rakservers.namaRak')                    
                    ->get();
        // dd($produks);
        return response()->json( $produks);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produks = Produk::find($id);
        return response()->json( $produks);
        // $title      = 'Produk';
        // $subtitle   = 'Edit';
        // $produks    = Produk::find($id);
        // return view('admin.produk.edit', compact('title','subtitle', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $valData = $request->validate([
            'serialNumber'  => 'required',
            'namaProduk'    => 'required',
            'kodeRak'       => 'required',
            'deskripsi'     => 'required',
            'tgl_pengadaan' => 'required|date',
            'kondisi'       => 'required'
        ]);
        $valData['user_id'] = Auth::user()->id;
        $simpan = Produk::where('serialNumber', $request->serialNumber)->update([
                'namaProduk' => $request->namaProduk,
                'kodeRak' => $request->kodeRak,
                'deskripsi' => $request->deskripsi,
                'tgl_pengadaan' => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_pengadaan))),
                'kondisi' => $request->kondisi,
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
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect('produk')->with('success', 'Produk berhasil dihapus.');
    }

    public function edit_modal($id) 
    {
        $produks = Produk::find($id);
        return response()->json( $produks);
    }

    public function logproduk()
    {
        $title      = 'Produk';
        $subtitle   = 'Log Produk';
        $logproduk = LogProduk::join('produks', 'log_produks.serialNumber', '=', 'produks.serialNumber')
                    ->join('users', 'log_produks.UserId', '=', 'users.id')
                    ->join('rakservers', 'log_produks.kodeRak', '=', 'rakservers.kodeRak')
                    ->select('log_produks.kon_lama', 'log_produks.kon_baru','rakservers.namaRak','log_produks.serialNumber', 'log_produks.created_at', 'produks.namaProduk', 'users.name')
                    ->get();
        // dd($logproduk);
        return view('admin.produk.logproduk', compact('title','subtitle', 'logproduk'));
    }
    
    public function getProduk($id){
        $produk = Produk::where('id', $id)->get();
        return response()->json($produk);
    }
}
