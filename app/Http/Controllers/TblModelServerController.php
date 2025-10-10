<?php

namespace App\Http\Controllers;

use App\Models\TblModelServer;
use App\Models\Tbjenisrak;
use App\Models\tbmodelraks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TblModelServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Pemeliharaan';
        $subtitle   = 'Rak Server';
        $jenisRak   = Tbjenisrak::all();
        $modelRak   = tbmodelraks::all()->groupBy('kdjenis');
        // $jnsrak     = Tbjenisrak::all();
        // $tmodrak    = tbmodelraks::all();

        $data = DB::table('tbmodelraks')
                ->leftJoin('tbjenisraks', 'tbmodelraks.kdjenis', '=', 'tbjenisraks.kdjenis')
                ->select('tbmodelraks.*',
                'tbjenisraks.namaJenis')
                ->get();

        if($data){
                return view('admin.modelrak.index', compact('title','subtitle', 'data','jenisRak', 'modelRak'));
        } else {
                $data= '';
                return view('admin.modelrak.index', compact('title','subtitle', 'data','jenisRak', 'modelRak'));
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
        //
    }

    public function show($id)
    {
        // $data = Tbjenisrak::where('kdjenis', $id)->first();       
        // return response()->json( $data);
    }

    /**
     * Display the specified resource.
     */
    public function getJenis($id)
    {
       $data = Tbjenisrak::where('kdjenis', $id)->first();       
        return response()->json( $data);
    }

    public function getModel($id)
    {
        $data = DB::table('tbmodelraks')
                ->leftJoin('tbjenisraks', 'tbmodelraks.kdjenis', '=', 'tbjenisraks.kdjenis')
                ->select('tbmodelraks.*',
                'tbjenisraks.namaJenis')
                ->where('kdmodel', $id)
                ->first();
        // $data = tbmodelraks::where('kdmodel', $id)->first();         
        return response()->json( $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblModelServer $tblModelServer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblModelServer $tblModelServer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblModelServer $tblModelServer)
    {
        //
    }
}
