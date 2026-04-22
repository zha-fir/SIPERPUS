<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'detailPeminjamans.buku'])->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        return view('peminjaman.create');
    }

    public function cekAnggota(Request $request)
    {
        $barcode = $request->query('barcode');
        $anggota = Anggota::where('barcode', $barcode)->first();

        if (!$anggota) {
            return response()->json(['success' => false, 'message' => 'Anggota tidak ditemukan']);
        }

        if ($anggota->status_anggota != 'aktif') {
            return response()->json(['success' => false, 'message' => 'Status anggota tidak aktif']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $anggota->nama_lengkap,
                'kelas' => $anggota->kelas_atau_jabatan,
                'status' => $anggota->status_anggota,
                'barcode' => $anggota->barcode
            ]
        ]);
    }

    public function cekBuku(Request $request)
    {
        $barcode = $request->query('barcode');
        $buku = Buku::where('kode_buku', $barcode)->first();

        if (!$buku) {
            return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan']);
        }

        if ($buku->jumlah_tersedia <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok buku habis']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode_buku' => $buku->kode_buku,
                'judul' => $buku->judul_buku,
                'penulis' => $buku->penulis,
                'klasifikasi' => $buku->klasifikasi_ddc
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode_anggota' => 'required|string',
            'kode_buku' => 'required|array',
            'kode_buku.*' => 'string'
        ]);

        $anggota = Anggota::where('barcode', $request->barcode_anggota)->first();
        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }

        if ($anggota->status_anggota != 'aktif') {
            return redirect()->back()->with('error', 'Status anggota tidak aktif, tidak bisa meminjam buku.');
        }

        DB::beginTransaction();
        try {
            // Hitung jatuh tempo (misal: 7 hari dari sekarang)
            $tanggalPinjam = Carbon::now('Asia/Makassar');
            $jatuhTempo = $tanggalPinjam->copy()->addDays(7);

            $peminjaman = Peminjaman::create([
                'id_anggota' => $anggota->id_anggota,
                'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
                'tanggal_jatuh_tempo' => $jatuhTempo->format('Y-m-d'),
                'status' => 'dipinjam'
            ]);

            foreach ($request->kode_buku as $kodeBuku) {
                if (!$kodeBuku) continue;

                $buku = Buku::where('kode_buku', $kodeBuku)->first();
                if ($buku && $buku->jumlah_tersedia > 0) {
                    DetailPeminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_buku' => $buku->id_buku,
                        'status' => 'dipinjam'
                    ]);

                    $buku->decrement('jumlah_tersedia');
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Buku dengan kode {$kodeBuku} tidak tersedia atau stok habis.");
                }
            }

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
