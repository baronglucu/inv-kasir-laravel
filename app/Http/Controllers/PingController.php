<?php

namespace App\Http\Controllers;

use App\Models\Ping;
use Illuminate\Http\Request;
// use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;


class PingController extends Controller
{

    public function index()
    {
        $title      = 'Utility IP Check';
        $subtitle   = 'Pemeriksaan IP Address';
        return view('admin.iptest.index', compact('title','subtitle'));
    }

    public function ping(Request $request)
    {
        $command = (new PingCommandBuilder('https://google.com'))->count(10)->packetSize(200)->ttl(128);

        // Sample output from Windows based server
        $ping = (new Ping($command))->run();

        dd($ping);
    }
}
