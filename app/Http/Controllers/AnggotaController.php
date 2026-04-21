<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();
        return view('anggota.index', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:anggota',
            'nama' => 'required',
            'kelas' => 'required'
        ]);

        $newIdNumber = str_pad(Anggota::count() + 1, 4, '0', STR_PAD_LEFT);
        
        Anggota::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'barcode' => 'ANG-' . $newIdNumber . '-' . rand(100, 999),
            'status' => 'aktif',
            'tanggal_daftar' => now('Asia/Makassar')->format('Y-m-d')
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
    }
}
