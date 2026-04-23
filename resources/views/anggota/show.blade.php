@extends('layouts.app')

@section('title', 'Detail Anggota')
@section('page_title', 'Profil Anggota')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('anggota.index') }}" class="p-2 bg-white text-slate-500 hover:text-slate-800 rounded-xl shadow-sm border border-slate-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Profil</h2>
                <p class="text-sm text-slate-500">Informasi biodata, riwayat peminjaman, dan kunjungan.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Sisi Kiri: Biodata -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="h-32 bg-gradient-to-br from-primary to-orange-600"></div>
                <div class="px-6 pb-6 relative">
                    <!-- Avatar -->
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border-4 border-white mx-auto -mt-12 flex items-center justify-center text-primary text-4xl font-black mb-4 overflow-hidden relative group">
                        @if($anggota->foto_profil)
                            <img src="{{ asset('storage/' . $anggota->foto_profil) }}" alt="Foto" class="w-full h-full object-cover">
                        @else
                            {{ substr($anggota->nama_lengkap, 0, 1) }}
                        @endif
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-black text-slate-800">{{ $anggota->nama_lengkap }}</h3>
                        <div class="text-sm font-bold text-slate-500 mt-1">{{ $anggota->kelas_atau_jabatan ?? 'Tidak ada data kelas/jabatan' }}</div>
                        
                        <div class="mt-3 flex items-center justify-center gap-2">
                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-600">
                                {{ $anggota->tipe_anggota }}
                            </span>
                            @if($anggota->status_anggota == 'aktif')
                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-700 uppercase">
                                    {{ str_replace('_', ' ', $anggota->status_anggota) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <p class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Barcode Perpustakaan</p>
                            <div class="flex flex-col items-center justify-center bg-white p-3 rounded-xl border border-slate-200">
                                <svg class="barcode w-full h-16" jsbarcode-value="{{ $anggota->barcode }}" jsbarcode-displayvalue="true" jsbarcode-height="40" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-xs text-slate-400 font-medium">Nomor Identitas</p>
                                    <p class="font-bold text-slate-700 mt-0.5">{{ $anggota->nomor_identitas }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-medium">Jenis Kelamin</p>
                                    <p class="font-bold text-slate-700 mt-0.5">{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-medium">No. Telepon</p>
                                    <p class="font-bold text-slate-700 mt-0.5">{{ $anggota->no_telepon ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-medium">Tanggal Daftar</p>
                                    <p class="font-bold text-slate-700 mt-0.5">{{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 text-center">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Peminjaman</div>
                    <div class="text-2xl font-black text-primary">{{ $peminjamans->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 text-center">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Kunjungan</div>
                    <div class="text-2xl font-black text-orange-500">{{ $kunjungans->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Tab Histori -->
        <div class="lg:col-span-8" x-data="{ tab: 'peminjaman' }">
            <!-- Tab Navigation -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex gap-2 mb-6">
                <button @click="tab = 'peminjaman'" :class="{'bg-primary text-white shadow-md': tab === 'peminjaman', 'text-slate-600 hover:bg-slate-50': tab !== 'peminjaman'}" class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all">
                    Riwayat Peminjaman ({{ $peminjamans->count() }})
                </button>
                <button @click="tab = 'kunjungan'" :class="{'bg-orange-500 text-white shadow-md': tab === 'kunjungan', 'text-slate-600 hover:bg-slate-50': tab !== 'kunjungan'}" class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all">
                    Riwayat Kunjungan ({{ $kunjungans->count() }})
                </button>
            </div>

            <!-- Tab Content: Peminjaman -->
            <div x-show="tab === 'peminjaman'" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Daftar Transaksi Peminjaman</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold border-b border-slate-100">Waktu</th>
                                <th class="p-4 font-semibold border-b border-slate-100">Buku</th>
                                <th class="p-4 font-semibold border-b border-slate-100">Jatuh Tempo</th>
                                <th class="p-4 font-semibold border-b border-slate-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($peminjamans as $p)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 text-sm">
                                    <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-400">Trx: #{{ str_pad($p->id_peminjaman, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="p-4">
                                    <ul class="space-y-1">
                                        @foreach($p->detailPeminjamans as $detail)
                                            <li class="flex items-start gap-1.5 text-sm text-slate-700">
                                                <span>{{ $detail->buku->judul_buku ?? '-' }}</span>
                                                @if($detail->status == 'dikembalikan')
                                                    <span class="text-[10px] text-emerald-500 font-bold" title="Sudah dikembalikan">✓</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>
                                <td class="p-4">
                                    @if($p->status == 'dipinjam')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Dipinjam</span>
                                    @elseif($p->status == 'selesai')
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada riwayat peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Content: Kunjungan -->
            <div x-show="tab === 'kunjungan'" style="display: none;" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Riwayat Kunjungan Perpustakaan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold border-b border-slate-100">Tanggal</th>
                                <th class="p-4 font-semibold border-b border-slate-100">Waktu Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($kunjungans as $k)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 font-medium text-slate-700">{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('l, d F Y') }}</td>
                                <td class="p-4 text-slate-600 font-mono">{{ $k->jam_masuk }} WITA</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-8 text-center text-slate-400">Belum ada riwayat kunjungan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        JsBarcode(".barcode").init();
    });
</script>
@endsection
