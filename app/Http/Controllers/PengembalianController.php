<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use App\Models\Anggota;
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

    public function pinjamanAktif(Request $request)
    {
        $barcode = $request->query('barcode');
        $anggota = Anggota::where('barcode', $barcode)->first();

        if (!$anggota) {
            return response()->json(['success' => false, 'message' => 'Anggota tidak ditemukan']);
        }

        // Cari peminjaman aktif
        $peminjamans = Peminjaman::where('id_anggota', $anggota->id_anggota)
                        ->where('status', 'dipinjam')
                        ->with(['detailPeminjamans' => function($q) {
                            $q->where('status', 'dipinjam')->with('buku');
                        }])
                        ->get();

        $tanggungan_buku = [];
        $sekarang = Carbon::now('Asia/Makassar')->startOfDay();

        foreach ($peminjamans as $p) {
            $jatuhTempo = Carbon::parse($p->tanggal_jatuh_tempo, 'Asia/Makassar')->startOfDay();
            $dendaPerBuku = 0;
            $hariTelat = 0;
            
            if ($sekarang->gt($jatuhTempo)) {
                $hariTelat = $sekarang->diffInDays($jatuhTempo);
                $dendaPerBuku = 1000 * $hariTelat;
            }

            foreach ($p->detailPeminjamans as $detail) {
                if ($detail->buku) {
                    $tanggungan_buku[] = [
                        'id_peminjaman' => $p->id_peminjaman,
                        'kode_buku' => $detail->buku->kode_buku,
                        'judul' => $detail->buku->judul_buku,
                        'penulis' => $detail->buku->penulis,
                        'tanggal_pinjam' => \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y'),
                        'jatuh_tempo' => \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y'),
                        'is_terlambat' => $hariTelat > 0,
                        'hari_telat' => $hariTelat,
                        'denda_estimasi' => $dendaPerBuku
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'anggota' => [
                    'nama' => $anggota->nama_lengkap,
                    'kelas' => $anggota->kelas_atau_jabatan,
                    'status' => $anggota->status_anggota,
                    'barcode' => $anggota->barcode
                ],
                'tanggungan_buku' => $tanggungan_buku
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|array',
            'kode_buku.*' => 'string'
        ]);

        DB::beginTransaction();
        try {
            $tanggalKembali = Carbon::now('Asia/Makassar');
            $pengembalianData = []; // To track fines and status per id_peminjaman
            $bukuDikembalikanCount = 0;
            $bukuNotFound = [];

            foreach ($request->kode_buku as $kodeBuku) {
                if (!$kodeBuku) continue;

                // 1. Cari buku berdasarkan kode
                $buku = \App\Models\Buku::where('kode_buku', $kodeBuku)->first();
                if (!$buku) {
                    $bukuNotFound[] = $kodeBuku;
                    continue;
                }

                // 2. Cari peminjaman aktif untuk buku ini
                $detail = DetailPeminjaman::where('id_buku', $buku->id_buku)
                            ->where('status', 'dipinjam')
                            ->first();

                if ($detail) {
                    $peminjaman = Peminjaman::find($detail->id_peminjaman);
                    $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo, 'Asia/Makassar');
                    
                    $dendaBukuIni = 0;
                    if ($tanggalKembali->startOfDay()->gt($tanggalJatuhTempo->startOfDay())) {
                        $selisihHari = $tanggalKembali->startOfDay()->diffInDays($tanggalJatuhTempo->startOfDay());
                        $dendaBukuIni = 1000 * $selisihHari; // Denda Rp1.000 per hari per buku
                    }

                    // Kumpulkan data berdasarkan ID Peminjaman (jika ada beberapa buku dari 1 transaksi)
                    if (!isset($pengembalianData[$peminjaman->id_peminjaman])) {
                        $pengembalianData[$peminjaman->id_peminjaman] = [
                            'denda' => 0,
                            'peminjaman' => $peminjaman
                        ];
                    }
                    $pengembalianData[$peminjaman->id_peminjaman]['denda'] += $dendaBukuIni;

                    // Update detail peminjaman
                    $detail->update(['status' => 'dikembalikan']);
                    
                    // Kembalikan stok buku
                    $buku->increment('jumlah_tersedia');
                    $bukuDikembalikanCount++;
                } else {
                    // Buku ditemukan tapi tidak dalam status dipinjam
                    $bukuNotFound[] = $kodeBuku . " (Tidak dipinjam)";
                }
            }

            if ($bukuDikembalikanCount == 0) {
                DB::rollBack();
                $msg = 'Tidak ada buku valid yang bisa dikembalikan.';
                if (count($bukuNotFound) > 0) {
                    $msg .= ' Barcode tidak dikenali/tidak dipinjam: ' . implode(', ', $bukuNotFound);
                }
                return redirect()->back()->with('error', $msg);
            }

            $totalDenda = 0;
            // 3. Update tabel Pengembalian & Peminjaman (Induk)
            foreach ($pengembalianData as $id_peminjaman => $data) {
                $peminjaman = $data['peminjaman'];
                $denda = $data['denda'];
                $totalDenda += $denda;

                $pengembalian = Pengembalian::where('id_peminjaman', $id_peminjaman)->first();
                $statusKembali = $denda > 0 ? 'terlambat' : 'tepat_waktu';

                if ($pengembalian) {
                    // Update jika anggota mengembalikan buku secara mencicil/parsial (denda diakumulasi)
                    $pengembalian->denda += $denda;
                    if ($statusKembali == 'terlambat') {
                        $pengembalian->status = 'terlambat';
                    }
                    $pengembalian->save();
                } else {
                    // Buat record baru jika ini pengembalian pertama dari transaksi ini
                    Pengembalian::create([
                        'id_peminjaman' => $id_peminjaman,
                        'tanggal_kembali' => $tanggalKembali->format('Y-m-d H:i:s'),
                        'denda' => $denda,
                        'status' => $statusKembali
                    ]);
                }

                // Cek apakah semua buku dalam transaksi ini sudah kembali
                $sisaDipinjam = DetailPeminjaman::where('id_peminjaman', $id_peminjaman)
                                ->where('status', 'dipinjam')
                                ->count();
                
                if ($sisaDipinjam == 0) {
                    $peminjaman->update(['status' => 'selesai']);
                }
            }

            DB::commit();

            $successMsg = "Berhasil mengembalikan $bukuDikembalikanCount buku.";
            if ($totalDenda > 0) {
                $successMsg .= " Total denda: Rp" . number_format($totalDenda, 0, ',', '.');
            }
            if (count($bukuNotFound) > 0) {
                $successMsg .= " (Catatan: " . count($bukuNotFound) . " barcode diabaikan)";
            }

            return redirect()->route('pengembalian.index')->with('success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
