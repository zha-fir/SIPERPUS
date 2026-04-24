<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insiden;
use Illuminate\Support\Str;

class HelpdeskController extends Controller
{
    public function create()
    {
        return view('helpdesk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelapor_nama' => 'required|string|max:255',
            'pelapor_tipe' => 'required|in:Siswa,Guru,Staf,Umum',
            'kategori' => 'required|string',
            'judul_insiden' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|image|max:2048'
        ]);

        $kode_tiket = 'TKT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('insiden_lampiran', 'public');
        }

        Insiden::create([
            'kode_tiket' => $kode_tiket,
            'pelapor_nama' => $request->pelapor_nama,
            'pelapor_email' => $request->pelapor_email,
            'pelapor_tipe' => $request->pelapor_tipe,
            'kategori' => $request->kategori,
            'prioritas' => 'Sedang', // Default for public
            'judul_insiden' => $request->judul_insiden,
            'deskripsi' => $request->deskripsi,
            'lampiran' => $lampiranPath,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('helpdesk.status.view', ['kode' => $kode_tiket])
            ->with('success', 'Laporan berhasil dikirim! Silakan simpan Kode Tiket di bawah ini untuk melacak status laporan Anda.');
    }

    public function statusView(Request $request)
    {
        $kode = $request->query('kode');
        $insiden = null;

        if ($kode) {
            $insiden = Insiden::where('kode_tiket', $kode)->first();
            if (!$insiden) {
                return back()->with('error', 'Tiket tidak ditemukan. Pastikan kode tiket benar.');
            }
        }

        return view('helpdesk.status', compact('insiden', 'kode'));
    }
}
