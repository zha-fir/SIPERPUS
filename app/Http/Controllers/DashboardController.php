<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengunjung;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('jumlah_total');
        $totalAnggota = Anggota::count();
        $totalPeminjaman = Peminjaman::where('status', 'dipinjam')->count();
        $totalKunjunganHariIni = Pengunjung::whereDate('tanggal_kunjungan', today()->timezone('Asia/Makassar'))->count();

        return view('dashboard', compact('totalBuku', 'totalAnggota', 'totalPeminjaman', 'totalKunjunganHariIni'));
    }
}
