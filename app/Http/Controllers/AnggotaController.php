<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('anggota.index', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_anggota' => 'required|in:Siswa,Guru,Staf',
            'nomor_identitas' => 'required|unique:anggota',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_atau_jabatan' => 'nullable',
            'no_telepon' => 'nullable'
        ]);

        $newIdNumber = str_pad(Anggota::count() + 1, 4, '0', STR_PAD_LEFT);
        
        Anggota::create([
            'tipe_anggota' => $request->tipe_anggota,
            'nomor_identitas' => $request->nomor_identitas,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_atau_jabatan' => $request->kelas_atau_jabatan,
            'no_telepon' => $request->no_telepon,
            'barcode' => 'ANG-' . $newIdNumber . '-' . rand(100, 999),
            'status_anggota' => 'aktif',
            'tanggal_daftar' => now('Asia/Makassar')->format('Y-m-d')
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        
        // Ambil histori peminjaman
        $peminjamans = \App\Models\Peminjaman::where('id_anggota', $id)
            ->with('detailPeminjamans.buku')
            ->latest('tanggal_pinjam')
            ->get();
            
        // Ambil histori kunjungan
        $kunjungans = \App\Models\Pengunjung::where('id_anggota', $id)
            ->latest('tanggal_kunjungan')
            ->latest('jam_masuk')
            ->get();

        return view('anggota.show', compact('anggota', 'peminjamans', 'kunjungans'));
    }
}
