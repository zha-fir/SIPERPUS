<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->get();
        return view('buku.index', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'klasifikasi_ddc' => 'nullable',
            'lokasi_rak' => 'nullable',
            'jumlah_total' => 'required|numeric|min:1'
        ]);

        $newIdNumber = str_pad(Buku::count() + 1, 4, '0', STR_PAD_LEFT);

        Buku::create([
            'kode_buku' => 'BK-' . $newIdNumber . '-' . rand(100, 999),
            'isbn_issn' => $request->isbn_issn,
            'judul_buku' => $request->judul_buku,
            'edisi' => $request->edisi,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'tempat_terbit' => $request->tempat_terbit,
            'klasifikasi_ddc' => $request->klasifikasi_ddc,
            'deskripsi_fisik' => $request->deskripsi_fisik,
            'lokasi_rak' => $request->lokasi_rak,
            'jumlah_total' => $request->jumlah_total,
            'jumlah_tersedia' => $request->jumlah_total
        ]);

        return redirect()->back()->with('success', 'Buku bibliografi berhasil ditambahkan.');
    }
}
