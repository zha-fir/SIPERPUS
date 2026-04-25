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
        $peminjamans = Peminjaman::with(['anggota', 'detailPeminjamans.eksemplar.buku'])->latest()->get();
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
        $eksemplar = \App\Models\Eksemplar::with('buku')->where('kode_eksemplar', $barcode)->first();

        if (!$eksemplar) {
            return response()->json(['success' => false, 'message' => 'Buku/Eksemplar tidak ditemukan']);
        }

        if ($eksemplar->status !== 'Tersedia') {
            return response()->json(['success' => false, 'message' => 'Status buku ini: ' . $eksemplar->status]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode_buku' => $eksemplar->kode_eksemplar,
                'judul' => $eksemplar->buku->judul_buku,
                'penulis' => $eksemplar->buku->penulis,
                'klasifikasi' => $eksemplar->buku->klasifikasi_ddc
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

            foreach ($request->kode_buku as $kodeEksemplar) {
                if (!$kodeEksemplar) continue;

                $eksemplar = \App\Models\Eksemplar::with('buku')->where('kode_eksemplar', $kodeEksemplar)->first();
                if ($eksemplar && $eksemplar->status === 'Tersedia') {
                    DetailPeminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_eksemplar' => $eksemplar->id_eksemplar,
                        'status' => 'dipinjam'
                    ]);

                    $eksemplar->update(['status' => 'Dipinjam']);
                    
                    if ($eksemplar->buku) {
                        $eksemplar->buku->decrement('jumlah_tersedia');
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Buku dengan kode {$kodeEksemplar} tidak tersedia.");
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
