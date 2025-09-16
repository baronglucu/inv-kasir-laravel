<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Permohonan;
use App\Models\Tbkotama;
use App\Models\Tbsatminkal;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Storage;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Data Laporan Permohonan';
        $subtitle   = 'Nominatif Permohonan';
        $kotama     = Tbkotama::all();
        $satuan     = Tbsatminkal::all();
        $domain     = Domain::all();
        $alat       = DB::table('permohonans')
                    ->leftJoin('domains', 'domains.id', '=', 'permohonans.id_domain')
                    ->leftJoin('tbkotamas', 'permohonans.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('permohonans.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('permohonans.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->select('permohonans.*', 'domains.nama_domain', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')
                    ->orderBy('permohonans.tgl_surat', 'asc')
                    ->get();

        if($alat){
            return view('admin.Permohonan.index', compact('title','subtitle', 'kotama', 'satuan', 'alat'));
        } else {
            $alat= '';
            return view('admin.Permohonan.index', compact('title','subtitle', 'kotama', 'satuan', 'alat'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $file = Permohonan::findOrNew($id);
        
        if ($file) {
            // Dapatkan path file dari storage
            $path = Storage::disk('files')->path($file->file_surat); 
            // Atau bisa menggunakan full_path untuk mendapatkan nama lengkap file            
            return view('Permohonan.create', [
                'file' => $file,
                'full_path' => $file->full_path,
                'content_type' => $file->mime_type
            ]);
        }
        
        return view('Permohonan.create', ['error' => 'File tidak ditemukan']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_mohon'      => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'no_surat'      => 'nullable',
            'tgl_surat'     => 'nullable|date',
            'perihal'       => 'required',
            'utk_satuan'    => 'required',
            'nm_domain'     => 'required',
            'status'        => 'nullable',
            'klasifikasi'   => 'nullable',
            'melalui'       => 'nullable',
            'id_domain'     => 'nullable',
            'file_surat'    => 'nullable|mimes:pdf|max:4096' // Validasi file surat
        ]);
       
        $validatedData['no_mohon'] = 'LPm-'.$request->input('no_mohon').'/Pusta';
        $cek = Permohonan::where(['no_mohon' => $request->input('no_mohon')])->first();
        if($cek){
            return response()->json([
                'status' => 500, 
                'message' => 'Laporan Permohonan sudah ada'
            ]);
        } else {
            $validatedData['kd_ktm'] = $request->kotama;
            $validatedData['kd_smkl'] = $request->satuan;
            $validatedData['user_id'] = Auth::user()->id;
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

            $simpan = Permohonan::create($validatedData); 
             
            if($simpan){
                return response()->json([
                    'status' => 200, 
                    'message' => 'Laporan Permohonan berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'status' => 500, 
                    'message' => 'Laporan Permohonan gagal ditambahkan'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alat       = DB::table('permohonans')
                    ->leftJoin('domains', 'domains.id', '=', 'permohonans.id_domain')
                    ->leftJoin('tbkotamas', 'permohonans.kd_ktm', '=', 'tbkotamas.kd_ktm')
                    ->leftJoin('tbsatminkals', function($join)
                         {
                             $join->on('permohonans.kd_ktm', '=', 'tbsatminkals.kd_ktm');
                             $join->on('permohonans.kd_smkl','=', 'tbsatminkals.idsmkl');
                         })
                    ->where('permohonans.id','=',$id)
                    ->select('permohonans.*', 'domains.nama_domain', 'tbkotamas.ur_ktm', 'tbsatminkals.ur_smkl')                    
                    ->get();
        
        return response()->json( $alat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $Permohonan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $Permohonan)
    {
        $validatedData = $request->validate([
            'no_mohon'      => 'required',
            'kd_ktm'        => 'nullable',
            'kd_smkl'       => 'nullable',
            'no_surat'      => 'nullable',
            'tgl_surat'     => 'nullable|date',
            'perihal'       => 'required',
            'utk_satuan'    => 'required',
            'nm_domain'     => 'nullable',
            'status'        => 'nullable',
            'klasifikasi'   => 'nullable',
            'melalui'       => 'nullable',
            'id_domain'     => 'nullable',
            'file_surat'    => 'nullable|mimes:pdf|max:4096' // Validasi file surat
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $simpan = Permohonan::where('no_mohon', $request->no_mohon)->update([
                'kd_ktm'        => $request->kotama,
                'kd_smkl'       => $request->satuan,
                'no_surat'      => $request->no_surat,
                'tgl_surat'     => date('Y-m-d', strtotime(str_replace('-', replace: '/', subject: $request->tgl_surat))),               
                'perihal'       => $request->perihal,
                'utk_satuan'    => $request->utk_satuan,
                'nm_domain'     => $request->nm_domain,
                'status'        => $request->status,
                'klasifikasi'   => $request->klasifikasi,
                'melalui'       => $request->melalui,
                'id_domain'     => $request->id_domain,
                'file_surat'    => $request->file_surat ? $request->file_surat : null, // Jika file_surat tidak diubah, tetap simpan null
        ]);

        if($simpan){
            return response()->json([
                'status' => 200, 
                'pesan' => 'Nomor '.$request->no_mohon.' berhasil di Update'
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
    public function destroy($id)
    {
        $daftar = Permohonan::findOrFail($id);
        // Cek apakah file_surat ada dan dapat dihapus
        if ($daftar->file_surat && Storage::disk('public')->exists('files/' . $daftar->file_surat)) {
            Storage::disk('public')->delete('files/' . $daftar->file_surat);
            $daftar->file_surat = null;
            $daftar->save();
        }
        $daftar->delete();
        // Redirect atau tampilkan pesan sukses
        return redirect('Permohonan')->with('success', 'Data berhasil dihapus.');
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
