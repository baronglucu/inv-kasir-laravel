<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rakserver;

class DropDownController extends Controller
{
    public function index()
    {
        // $data['rakservers'] = Rakserver::get(["namaRak", "kodeRak"]);
        $datarak    = Rakserver::all();
        return view('admin.produk.index', compact('datarak'));
    }

    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    // public function fetchRak(Request $request)
    // {
    //     $data['rakservers'] = Rakserver::where("kodeRak", $request->kodeRak)->get(["namaRak", "kodeRak"]);  

    //     return response()->json($data);
    // }
}
