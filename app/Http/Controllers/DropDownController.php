<?php

namespace App\Http\Controllers;

use App\Models\Tbkotama;
use App\Models\tbmodelraks;
use App\Models\Tbsatminkal;
use App\Models\Domain;

use Illuminate\Http\Request;

class DropDownController extends Controller
{
    public function index()
    {
        $data['kotama'] = Tbkotama::get(["ur_ktm", "kd_ktm"]);
        return view('dropdown', $data);
    }

    /**
     * Write code on Method
     */
     public function fetchSatuan(Request $request)
     { 
         $data['satuan'] = Tbsatminkal::where("kd_ktm", $request->kd_ktm) ->get(["ur_smkl", "kd_smkl"]);   
         return response()->json($data); 
     }

     public function fetchDomain(Request $request)
     { 
         $data['domain'] = Domain::where("idsmkl", $request->kd_smkl) ->get(["id", "nama_domain"]);   
         return response()->json($data); 
     }

     public function fetchModel(Request $request)
     { 
         $data['modelrak'] = tbmodelraks::where("kdjenis", $request->kdjenis) ->get(["kdmodel", "namaModel"]);   
         return response()->json($data); 
     }
}
