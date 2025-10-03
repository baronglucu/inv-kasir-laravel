<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\TbWhm;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $jmlPengaduan = DB::table('pengaduans')->count();
        // dd($jumlahPengaduan); // Untuk memastikan nilainya
        $jmlwhm = TbWhm::all(); // Mendapatkan semua produk
        $totalWhm = $jmlwhm->sum('kapasitas'); 
        $jmlDomain = DB::table('domains')->count();

        $dtAduPerBln = Pengaduan::select(
            DB::raw('DATE_FORMAT(tgl_laporan, "%Y-%m") as bulan'), // Format tanggal ke YYYY-MM
            DB::raw('COUNT(*) as jumlah') // Hitung jumlah data
        )
        ->groupBy('bulan') // Kelompokkan berdasarkan bulan
        ->orderBy('bulan', 'asc') // Urutkan berdasarkan bulan (opsional)
        ->get(); // Eksekusi query
        
        // dd($dtAduPerBln);


        return view('admin.dashboard', compact('jmlPengaduan', 'totalWhm', 'jmlDomain', 'dtAduPerBln'));
    }
}
