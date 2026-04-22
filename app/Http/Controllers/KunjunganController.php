<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Pengunjung;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungans = Pengunjung::with('anggota')
            ->whereDate('tanggal_kunjungan', Carbon::today('Asia/Makassar'))
            ->orderBy('jam_masuk', 'desc')
            ->get();
        return view('kunjungan.index', compact('kunjungans'));
    }

    public function storeScan(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);
        
        $anggota = Anggota::where('barcode', $request->barcode)->first();

        if ($anggota) {
            Pengunjung::create([
                'id_anggota' => $anggota->id_anggota,
                'tipe' => 'anggota',
                'tanggal_kunjungan' => Carbon::now('Asia/Makassar')->format('Y-m-d'),
                'jam_masuk' => Carbon::now('Asia/Makassar')->format('H:i:s'),
            ]);
            return redirect()->back()->with('success', 'Selamat datang, ' . $anggota->nama_lengkap);
        }

        return redirect()->back()->with('error', 'Barcode anggota tidak ditemukan.');
    }

    public function storeUmum(Request $request)
    {
        $request->validate([
            'nama_pengunjung' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255'
        ]);

        Pengunjung::create([
            'nama_pengunjung' => $request->nama_pengunjung,
            'instansi' => $request->instansi,
            'tipe' => 'umum',
            'tanggal_kunjungan' => Carbon::now('Asia/Makassar')->format('Y-m-d'),
            'jam_masuk' => Carbon::now('Asia/Makassar')->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Selamat datang, ' . $request->nama_pengunjung);
    }
}
