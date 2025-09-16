<?php

namespace App\Http\Controllers;

use App\Models\c;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IpCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title      = 'Utility IP Check';
        $subtitle   = 'Pemeriksaan IP Address';
        $ipAddress  = null;
        return view('admin.ipcheck.index', compact('title','subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showForm()
    {
        return view('ip-checker');
    }

    /**
     * Memeriksa dan memvalidasi IP address yang dimasukkan.
     */
    public function checkIp(Request $request)
    {
        $title      = 'Utility IP Check';
        $subtitle   = 'Pemeriksaan IP Address';
        $ipAddress  = null;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'ip_address' => 'required|ip',
            'ping_count' => 'nullable|integer|min:1|max:100', // Batasi maksimal 100 untuk menghindari DDoS.
        ], [
            'ip_address.required' => 'IP Address wajib diisi.',
            'ip_address.ip'       => 'Format IP Address tidak valid.',
            'ping_count.integer'  => 'Jumlah ping harus berupa angka.',
            'ping_count.min'      => 'Jumlah ping minimal adalah 1.',
            'ping_count.max'      => 'Jumlah ping maksimal adalah 100.',
        ]);

        // Jika validasi gagal, kembali ke halaman form dengan error
        if ($validator->fails()) {
            return redirect()->route('ipcheck.index')
                ->withErrors($validator)
                ->withInput();
        }

        $ipAddress = $request->input('ip_address');
        $pingCount = $request->input('ping_count', 4); // Ambil nilai ping_count, default 4

        $ipVersion = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? 'IPv4' : 'IPv6';
        $pingResult = $this->pingIp($ipAddress, $pingCount);

        // Tampilkan hasil
        return view('admin.ipcheck.index', compact('ipAddress', 'ipVersion', 'pingResult', 'title', 'subtitle'));
    }

    private function pingIp($ip, $count)
    {
        $os = strtoupper(substr(PHP_OS, 0, 3));
        $pingCommand = '';

        if ($os === 'WIN') {
            // Perintah ping untuk Windows, -n (count)
            $pingCommand = "ping -n {$count} {$ip}";
        } else {
            // Perintah ping untuk Linux/Mac, -c (count)
            $pingCommand = "ping -c {$count} {$ip}";
        }
        
        exec($pingCommand, $output, $returnVar);

        $pingOutput = implode("\n", $output);

        if ($returnVar === 0) {
            return "Ping berhasil:\n" . $pingOutput;
        } else {
            return "Ping gagal (timeout atau host tidak dapat dijangkau):\n" . $pingOutput;
        }
    }
}
