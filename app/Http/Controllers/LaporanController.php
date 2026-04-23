<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengunjung;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01')); // Default 1st of current month
        $endDate = $request->input('end_date', date('Y-m-t')); // Default last day of current month
        $tab = $request->input('tab', 'sirkulasi'); // Default tab

        // 1. Peminjaman yang sedang berjalan (status = dipinjam)
        $peminjamanAktif = Peminjaman::with(['anggota', 'detailPeminjamans.buku'])
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // 2. Laporan Sirkulasi (Peminjaman & Pengembalian within date range)
        $riwayatSirkulasi = Pengembalian::with(['peminjaman.anggota', 'peminjaman.detailPeminjamans.buku'])
            ->whereBetween('tanggal_kembali', [$startDate, $endDate])
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        // 3. Laporan Kunjungan (within date range)
        $kunjungan = Pengunjung::whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->get();

        // 4. Statistik Populer
        // Top 5 Buku
        $topBuku = DB::table('detail_peminjaman')
            ->join('buku', 'detail_peminjaman.id_buku', '=', 'buku.id_buku')
            ->select('buku.judul_buku', 'buku.penulis', 'buku.cover_buku', DB::raw('count(detail_peminjaman.id_buku) as total_dipinjam'))
            ->groupBy('buku.id_buku', 'buku.judul_buku', 'buku.penulis', 'buku.cover_buku')
            ->orderByDesc('total_dipinjam')
            ->limit(5)
            ->get();

        // Top 5 Anggota
        $topAnggota = DB::table('peminjaman')
            ->join('anggota', 'peminjaman.id_anggota', '=', 'anggota.id_anggota')
            ->select('anggota.nama_lengkap', 'anggota.tipe_anggota', 'anggota.nomor_identitas', DB::raw('count(peminjaman.id_anggota) as total_pinjam'))
            ->groupBy('anggota.id_anggota', 'anggota.nama_lengkap', 'anggota.tipe_anggota', 'anggota.nomor_identitas')
            ->orderByDesc('total_pinjam')
            ->limit(5)
            ->get();

        // 5. Ringkasan statistik
        $stats = [
            'total_peminjaman_periode'   => Peminjaman::whereBetween('tanggal_pinjam', [$startDate, $endDate])->count(),
            'total_pengembalian_periode' => Pengembalian::whereBetween('tanggal_kembali', [$startDate, $endDate])->count(),
            'total_denda_periode'        => Pengembalian::whereBetween('tanggal_kembali', [$startDate, $endDate])->sum('denda'),
            'total_kunjungan_periode'    => Pengunjung::whereBetween('tanggal_kunjungan', [$startDate, $endDate])->count(),
            'total_koleksi_judul'        => Buku::count(),
            'total_koleksi_eksemplar'    => Buku::sum('jumlah_total'),
            'koleksi_habis'              => Buku::where('jumlah_tersedia', 0)->count(),
        ];

        return view('laporan.index', compact(
            'peminjamanAktif',
            'riwayatSirkulasi',
            'kunjungan',
            'topBuku',
            'topAnggota',
            'stats',
            'startDate',
            'endDate',
            'tab'
        ));
    }

    public function cetak(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));
        $jenis = $request->input('jenis', 'sirkulasi'); // sirkulasi, kunjungan, koleksi

        if ($jenis == 'sirkulasi') {
            $data = Pengembalian::with(['peminjaman.anggota', 'peminjaman.detailPeminjamans.buku'])
                ->whereBetween('tanggal_kembali', [$startDate, $endDate])
                ->orderBy('tanggal_kembali', 'asc')
                ->get();
        } elseif ($jenis == 'kunjungan') {
            $data = Pengunjung::whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                ->orderBy('tanggal_kunjungan', 'asc')
                ->get();
        } elseif ($jenis == 'koleksi') {
            $data = Buku::orderBy('judul_buku', 'asc')->get();
        } else {
            $data = [];
        }

        return view('laporan.cetak', compact('data', 'startDate', 'endDate', 'jenis'));
    }
}
