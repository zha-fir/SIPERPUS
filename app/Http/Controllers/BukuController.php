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
            'jumlah_total' => 'required|numeric|min:1',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_buku')) {
            $coverPath = $request->file('cover_buku')->store('covers', 'public');
        }

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
            'jumlah_tersedia' => $request->jumlah_total,
            'cover_buku' => $coverPath
        ]);

        return redirect()->back()->with('success', 'Buku bibliografi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'klasifikasi_ddc' => 'nullable',
            'lokasi_rak' => 'nullable',
            'jumlah_total' => 'required|numeric|min:1',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = [
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
            // Sesuaikan jumlah tersedia: (Total Baru - Total Lama) + Tersedia Lama
            'jumlah_tersedia' => ($request->jumlah_total - $buku->jumlah_total) + $buku->jumlah_tersedia
        ];

        if ($request->hasFile('cover_buku')) {
            // Hapus gambar lama jika ada
            if ($buku->cover_buku && \Illuminate\Support\Facades\Storage::disk('public')->exists($buku->cover_buku)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($buku->cover_buku);
            }
            $data['cover_buku'] = $request->file('cover_buku')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->back()->with('success', 'Katalog buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Validasi SLiMS: Cek apakah buku sedang dipinjam
        $sedangDipinjam = \App\Models\DetailPeminjaman::where('id_buku', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangDipinjam) {
            return redirect()->back()->with('error', 'Gagal menghapus! Buku ini masih ada yang meminjam (eksemplar belum kembali semua).');
        }

        // Hapus cover buku dari storage
        if ($buku->cover_buku && \Illuminate\Support\Facades\Storage::disk('public')->exists($buku->cover_buku)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($buku->cover_buku);
        }

        $buku->delete();

        return redirect()->back()->with('success', 'Katalog buku beserta gambar cover berhasil dihapus secara permanen.');
    }

    public function cetakBarcode(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return redirect()->back()->with('error', 'Tidak ada buku yang dipilih untuk dicetak.');
        }

        $idArray = explode(',', $ids);
        $bukus = Buku::whereIn('id_buku', $idArray)->get();

        return view('buku.cetak-barcode', compact('bukus'));
    }
}
