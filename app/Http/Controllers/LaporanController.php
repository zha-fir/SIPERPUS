<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengunjung;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Peminjaman yang sedang berjalan (status = dipinjam)
        $peminjamanAktif = Peminjaman::with(['anggota', 'detailPeminjamans.buku'])
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // 2. Riwayat pengembalian
        $riwayatPengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.detailPeminjamans.buku'])
            ->orderBy('tanggal_kembali', 'desc')
            ->limit(20)
            ->get();

        // 3. Pengunjung terbaru
        $pengunjungTerbaru = Pengunjung::orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->limit(20)
            ->get();

        // 4. Ringkasan statistik
        $stats = [
            'total_peminjaman'   => Peminjaman::count(),
            'sedang_dipinjam'    => Peminjaman::where('status', 'dipinjam')->count(),
            'total_pengembalian' => Pengembalian::count(),
            'total_denda'        => Pengembalian::sum('denda'),
        ];

        return view('laporan.index', compact(
            'peminjamanAktif',
            'riwayatPengembalian',
            'pengunjungTerbaru',
            'stats'
        ));
    }
}
