<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'kategori' => 'required',
            'jumlah_total' => 'required|numeric|min:1'
        ]);

        $newIdNumber = str_pad(Buku::count() + 1, 4, '0', STR_PAD_LEFT);

        Buku::create([
            'kode_buku' => 'BK-' . $newIdNumber . '-' . rand(100, 999),
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'jumlah_total' => $request->jumlah_total,
            'jumlah_tersedia' => $request->jumlah_total
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan.');
    }
}
