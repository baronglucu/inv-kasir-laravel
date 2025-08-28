<?php

namespace App\Http\Controllers;

use App\Models\Iptest;
use Illuminate\Http\Request;
use Auth;
use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

class IptestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Utility IP Check';
        $subtitle   = 'Pemeriksaan IP Address';
        return view('admin.iptest.index', compact('title','subtitle'));
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

    /**
     * Display the specified resource.
     */
    public function show(Iptest $iptest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Iptest $iptest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Iptest $iptest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Iptest $iptest)
    {
        //
    }
}
