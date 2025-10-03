<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TracerController extends Controller
{
    public function index()
    {
        $title      = 'Pelacakan Ip/Domain';
        $subtitle   = 'Alat Penelusuran';
        return view('admin.tracer.index', compact('title','subtitle'));
    }
    public function trace(Request $request)
    {
        // $request->validate([
        //     'target' => 'required|string'
        // ]);

        // $target = escapeshellarg($request->target);

        // // Untuk Windows gunakan 'tracert', untuk Linux gunakan 'traceroute'
        // $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        // $command = $isWindows
        //     ? "tracert -d -h 10 $target"
        //     : "traceroute -n -m 10 $target";

        // $output = [];
        // $result = null;
        // exec($command, $output, $result);

        // return response()->json([
        //     'success' => $result === 0,
        //     'output' => implode("\n", $output)
        // ]);

        $request->validate([
            'target' => 'required|string'
        ]);

        $target = escapeshellarg($request->target);
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $command = $isWindows
            ? "tracert -d -h 10 $target"
            : "traceroute -n -m 10 $target";

        $output = [];
        $result = null;
        exec($command, $output, $result);

        if ($result !== 0) {
            return response()->json([
                'success' => false,
                'output' => implode("\n", $output),
                'error' => 'Perintah gagal dijalankan atau tidak ditemukan'
            ]);
        }

        // Ambil IP dari hasil traceroute
        $ipList = [];
        foreach ($output as $line) {
            if (preg_match_all('/\b\d{1,3}(?:\.\d{1,3}){3}\b/', $line, $matches)) {
                foreach ($matches[0] as $ip) {
                    if (!in_array($ip, $ipList) && $ip !== '0.0.0.0') {
                        $ipList[] = $ip;
                    }
                }
            }
        }

        // Ambil lokasi untuk setiap IP (gunakan ip-api.com, gratis tanpa API key)
        $geoData = [];
        foreach ($ipList as $ip) {
            $geo = @file_get_contents("http://ip-api.com/json/$ip?fields=country,regionName,isp,org,city,query,status");
            $geo = $geo ? json_decode($geo, true) : null;
            $geoData[$ip] = $geo && $geo['status'] === 'success'
                ? "{$geo['country']}, {$geo['regionName']}, {$geo['city']}, {$geo['isp']}, {$geo['org']}"
                : 'Lokasi tidak ditemukan';
        }

        return response()->json([
            'success' => $result === 0,
            'output' => implode("\n", $output),
            'geo' => $geoData
        ]);
    }
}
