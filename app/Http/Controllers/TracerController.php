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

        // function getGeo($ip) {
        //     $url = "http://ip-api.com/json/$ip?fields=country,regionName,isp,org,city,query,status";
        //     $ch = curl_init($url);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $response = curl_exec($ch);
        //     curl_close($ch);
        //     return $response ? json_decode($response, true) : null;
        // }
        // Ambil lokasi untuk setiap IP (gunakan ip-api.com, gratis tanpa API key)
        function getGeoMyIpMs($ip) {
            /**********************/
            $query 	= $ip;
            /*  Your API Details  */
            /**********************/
            $api_id = "id117642";
            $api_key = "2005104228-376632250-67050169";
            $api_url = "https://api.myip.ms";
            
            /*  Whois Result  */
            /******************/
            $url  = create_api_url($query, $api_id, $api_key, $api_url);
            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $ch, CURLOPT_TIMEOUT, 90);
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 90);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response, true): null;
        }

        function create_api_url($query, $api_id, $api_key, $api_url, $timestamp = '')
{
            $url = "";
            if (!$timestamp) $timestamp = gmdate("Y-m-d_H:i:s");
            if (trim($query) != '') {
                $url = $api_url."/".$query.'/api_id/'.$api_id.'/api_key/'.$api_key;  
                $signature = md5($url.'/timestamp/'.$timestamp);
                $url .= '/signature/'.$signature.'/timestamp/'.$timestamp;
            }
            return $url;
        }
        // dd($output, $ipList);
        $geoData = [];
        foreach ($ipList as $ip) {
            $geo = getGeoMyIpMs($ip);
            // \Log::info($geo);
            // dd($geo); 
            // if ($geo && isset($geo['info']['country_name'])) {
            //     $info = $geo['info'];
            //     $geoData[$ip] = "{$info['country_name']}, {$info['city_name']}, ASN: {$info['asn']}, ISP: {$info['isp_name']}";
            if ($geo && isset($geo['owners']['owner']['countryName'])) {
                $location = $geo['owners']['owner'];
                $geoData[$ip] = "{$location['countryName']} ({$location['countryID']})";
            } else {
                $geoData[$ip] = 'Lokasi tidak ditemukan';
            }
        }
        // dd($geoData); 
        return response()->json([
            'success' => $result === 0,
            'output' => implode("\n", $output),
            'geo' => $geoData
        ]);
    }   

}
