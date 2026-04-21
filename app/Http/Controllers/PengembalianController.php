<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.anggota', 'peminjaman.detailPeminjamans.buku'])->latest()->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        // View for scanning member/books internally to check active borrowing
        return view('pengembalian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman'
        ]);

        $peminjaman = Peminjaman::with('detailPeminjamans.buku')->find($request->id_peminjaman);

        if ($peminjaman->status != 'dipinjam') {
            return redirect()->back()->with('error', 'Status peminjaman ini sudah selesai/dikembalikan.');
        }

        DB::beginTransaction();
        try {
            $tanggalKembali = Carbon::now('Asia/Makassar');
            $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo, 'Asia/Makassar');
            
            $denda = 0;
            $statusKembali = 'tepat_waktu';
            
            if ($tanggalKembali->startOfDay()->gt($tanggalJatuhTempo->startOfDay())) {
                $selisihHari = $tanggalKembali->startOfDay()->diffInDays($tanggalJatuhTempo->startOfDay());
                $jumlahBuku = $peminjaman->detailPeminjamans->count();
                // 1000 per hari keterlambatan / buku
                $denda = 1000 * $selisihHari * $jumlahBuku;
                $statusKembali = 'terlambat';
            }

            // Update status tabel peminjaman
            $peminjaman->update(['status' => 'selesai']);

            // Insert ke tabel pengembalian
            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_kembali' => $tanggalKembali->format('Y-m-d H:i:s'),
                'denda' => $denda,
                'status' => $statusKembali
            ]);

            // Update buku & detail peminjaman
            foreach ($peminjaman->detailPeminjamans as $detail) {
                $detail->update(['status' => 'dikembalikan']);
                $detail->buku->increment('jumlah_tersedia');
            }

            DB::commit();
            return redirect()->route('pengembalian.index')->with('success', "Buku berhasil dikembalikan. Denda: Rp" . number_format($denda, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
