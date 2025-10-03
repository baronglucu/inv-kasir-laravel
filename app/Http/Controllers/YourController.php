<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use DB;

class YourController extends Controller
{
    public function dashboard()
    {
        $jumlahPengaduan = DB::table('pengaduans')->count();
        // Ambil data lain jika perlu
        return view('admin.dashboard', compact('jumlahPengaduan'));
    }
}
