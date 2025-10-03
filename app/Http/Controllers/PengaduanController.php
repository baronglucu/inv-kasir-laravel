<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Pengaduan;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
USE App\Models\TbWhm;
use App\Models\Rakserver;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Laporan Pengaduan';
        $subtitle   = 'Nominatif Pengaduan';
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $domain     = Domain::all();
        $alat       = DB::table('pengaduans')
                    ->leftJoin('domains', 'domains.id', '=', 'pengaduans.id_domain')
                    ->leftJoin('tbkotamas', 'pengaduans.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('pengaduans.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('pengaduans.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('pengaduans.*', 'domains.nama_domain', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->orderBy('pengaduans.tgl_laporan', 'asc')
                    ->get();
            
        if($alat){
            return view('admin.pengaduan.index', compact('title','subtitle', 'kotama', 'satuan', 'domain', 'alat'));
        } else {
            $alat= '';
            return view('admin.pengaduan.index', compact('title','subtitle', 'kotama', 'satuan', 'domain', 'alat'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $file = Pengaduan::findOrNew($id);
        
        if ($file) {
            // Dapatkan path file dari storage
            $path = Storage::disk('files')->path($file->file_surat); 
            // Atau bisa menggunakan full_path untuk mendapatkan nama lengkap file            
            return view('pengaduan.create', [
                'file' => $file,
                'full_path' => $file->full_path,
                'content_type' => $file->mime_type
            ]);
        }
        
        return view('pengaduan.create', ['error' => 'File tidak ditemukan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_lapor'      => 'required',
            'nama_pelapor'  => 'required',
            'tgl_laporan'   => 'required|date',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'no_telp'       => 'required',
            'id_domain'     => 'required',
            'masalah'       => 'required',
            'solusi'        => 'nullable',
            'status'        => 'nullable',
            'klasifikasi'   => 'nullable',
            'melalui'       => 'nullable',
            'no_surat'      => 'nullable',
            'tgl_surat'     => 'nullable|date',
            'file_surat'    => 'nullable|mimes:pdf|max:4096' // Validasi file surat
        ]);
       
        $validatedData['no_lapor'] = 'LP-'.$request->input('no_lapor').'/Pusta';
        $cek = Pengaduan::where(['no_lapor' => $request->input('no_lapor')])->first();
        if($cek){
            return response()->json([
                'status' => 500, 
                'message' => 'Laporan Pengaduan sudah ada'
            ]);
        } else {
            $validatedData['kd_ktm'] = $request->kotama;
            $validatedData['kd_smkl'] = $request->satuan;
            $validatedData['user_id'] = Auth::user()->id;
            $validatedData['tgl_laporan'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_laporan)));
            $validatedData['tgl_surat'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_surat)));

            if ($request->file('file_surat') && $request->file('file_surat')->isValid()) {
            
                // try {
                    $file = $request->file('file_surat');
                    $fileName = $file->getClientOriginalName();
                    $path = $request->file('file_surat')->storeAs('files', $fileName);
                    $validatedData['file_surat'] = $fileName;    
                    // Log atau tindakan lainnya sesuai dengan kebutuhan
                    \Log::info("File uploaded successfully: " . $path);
    
            } else {
                $validatedData['file_surat'] = '';
            }

            $simpan = Pengaduan::create($validatedData); 
             
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Laporan Pengaduan berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Laporan Pengaduan gagal ditambahkan'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $dataRak = DB::table('tb_whms')
                   ->leftJoin('rakservers', 'tb_whms.kodeRak', '=', 'rakservers.kodeRak')
                   ->select('tb_whms.*', 
                    'rakservers.namaRak'
                    );      
        
        $dataDom = DB::table('domains')
                   ->joinSub($dataRak, 'data_rak', function ($join) {
                    $join->on('domains.id_whm', '=', 'data_rak.id');
                     })
                   ->select('domains.*', 
                    'data_rak.id as idwhm',
                    'data_rak.ip_address',
                    'data_rak.nama_whm',
                    'data_rak.namaRak'
                    );
        
        $alat       = DB::table('pengaduans')
                    ->joinSub($dataDom, 'data_dom', function ($join) {
                    $join->on('pengaduans.id_domain', '=', 'data_dom.id');
                     })
                    ->leftJoin('tbkotamas', 'pengaduans.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('pengaduans.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('pengaduans.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->where('pengaduans.id','=',$id)
                    ->select('pengaduans.*', 
                    'tbkotamas.ur_ktm', 
                    'tbsatminkals.ur_smkl',
                    'data_dom.*'
                    )                    
                    ->get();
        
        return response()->json( $alat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validatedData = $request->validate([
            'no_lapor'      => 'required',
            'nama_pelapor'  => 'required',
            'tgl_laporan'   => 'required|date',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'no_telp'       => 'required',
            'id_domain'     => 'required',
            'masalah'       => 'required',
            'solusi'        => 'nullable',
            'status'        => 'nullable',
            'klasifikasi'   => 'nullable',
            'melalui'       => 'nullable',
            'no_surat'      => 'nullable',
            'tgl_surat'     => 'nullable|date',
            'file_surat'    => 'nullable|mimes:pdf|max:4096' // Validasi file surat
        ]);

        $validatedData['user_id'] = Auth::user()->id;
        // $validatedData['kd_ktm'] = $request->kotama;
        // $validatedData['kd_smkl'] = $request->satuan;
        // $validatedData['tgl_laporan'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_laporan)));
        // $validatedData['tgl_surat'] = date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_surat)));

        $simpan = Pengaduan::where('no_lapor', $request->no_lapor)->update([
                'nama_pelapor'  => $request->nama_pelapor,
                'tgl_laporan'   => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_laporan))),
                'kd_ktm'        => $request->kotama,
                'kd_smkl'       => $request->satuan,
                'no_telp'       => $request->no_telp,
                'id_domain'     => $request->id_domain,
                'masalah'       => $request->masalah,
                'solusi'        => $request->solusi,
                'status'        => $request->status,
                'klasifikasi'   => $request->klasifikasi,
                'melalui'       => $request->melalui,
                'no_surat'      => $request->no_surat,
                'tgl_surat'     => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_surat))),
                'file_surat'    => $request->file_surat ? $request->file_surat : null, // Jika file_surat tidak diubah, tetap simpan null
        ]);

        // if ($request->file('file_surat') && $request->file('file_surat')->isValid()) {
            
        //             $file = $request->file('file_surat');
        //             $fileName = $file->getClientOriginalName();
        //             $path = $request->file('file_surat')->storeAs('files', $fileName);
        //             $validatedData['file_surat'] = $fileName;    
        //             // Log atau tindakan lainnya sesuai dengan kebutuhan
        //             \Log::info("File uploaded successfully: " . $path);
    
        // } else {
        //     $validatedData['file_surat'] = '';
        // }

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->no_lapor.' berhasil di Update'
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
        $daftar = Pengaduan::findOrFail($id);
        // Cek apakah file_surat ada dan dapat dihapus
        if ($daftar->file_surat && Storage::disk('public')->exists('files/' . $daftar->file_surat)) {
            Storage::disk('public')->delete('files/' . $daftar->file_surat);
            $daftar->file_surat = null;
            $daftar->save();
        }
        $daftar->delete();
        // Redirect atau tampilkan pesan sukses
        return redirect('pengaduan')->with('success', 'Data berhasil dihapus.');
    }

    public function handleFileUpload(Request $request)
    {
        // Validasi input file
        if ($request->file('file') && $request->file('file')->isValid()) {
            try {
                // Simpan file ke penyimpanan
                $path = $request->file('file')->store('uploads');

                // Log atau tindakan lainnya sesuai dengan kebutuhan
                \Log::info("File uploaded successfully: " . $path);

                return response()->json(['message' => 'File uploaded successfully', 'path' => $path]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to upload file'], 500);
            }
        } else {
            return response()->json(['error' => 'Invalid file'], 422);
        }
    }

}
