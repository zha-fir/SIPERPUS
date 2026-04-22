@extends('layouts.app')

@section('title', 'Laporan & Statistik')
@section('page_title', 'Laporan & Statistik')

@section('content')
<div class="mb-6 flex items-center justify-end">
    <div class="flex gap-2">
        <button onclick="window.print()" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Laporan
        </button>
    </div>
</div>

<!-- Kartu Ringkasan -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-500">Total Peminjaman</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_peminjaman']) }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-500">Sedang Dipinjam</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['sedang_dipinjam']) }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-500">Selesai Dikembalikan</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_pengembalian']) }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-500">Total Denda</p>
            <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 sm:gap-8">

    <!-- Tabel Peminjaman Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Peminjaman Aktif</h3>
            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-lg">Berjalan</span>
        </div>
        <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="sticky top-0 bg-white shadow-sm">
                    <tr class="text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-b border-slate-100">Peminjam & Buku</th>
                        <th class="p-4 font-semibold border-b border-slate-100">Tgl Pinjam</th>
                        <th class="p-4 font-semibold border-b border-slate-100">Tenggat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjamanAktif as $p)
                    @php
                        $tenggat = \Carbon\Carbon::parse($p->tanggal_jatuh_tempo);
                        $isTerlambat = \Carbon\Carbon::now()->startOfDay()->gt($tenggat->copy()->startOfDay());
                    @endphp
                    <tr class="hover:bg-slate-50/80">
                        <td class="p-4">
                            <div class="font-bold text-slate-800">{{ $p->anggota->nama_lengkap ?? '-' }}</div>
                            <div class="text-xs text-slate-500">
                                @foreach($p->detailPeminjamans as $d)
                                    {{ $d->buku->judul_buku ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </div>
                        </td>
                        <td class="p-4 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="p-4 whitespace-nowrap">
                            @if($isTerlambat)
                                <span class="text-rose-600 font-bold text-xs">{{ $tenggat->format('d M Y') }}<br><span class="bg-rose-100 px-1.5 py-0.5 rounded">Terlambat</span></span>
                            @else
                                <span class="text-slate-600 text-xs">{{ $tenggat->format('d M Y') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-8 text-center text-slate-400 text-sm">Tidak ada peminjaman aktif saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Riwayat Pengembalian -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Riwayat Pengembalian & Denda</h3>
            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-lg">Selesai</span>
        </div>
        <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="sticky top-0 bg-white shadow-sm">
                    <tr class="text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-b border-slate-100">Peminjam & Buku</th>
                        <th class="p-4 font-semibold border-b border-slate-100">Tgl Kembali</th>
                        <th class="p-4 font-semibold border-b border-slate-100">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayatPengembalian as $r)
                    <tr class="hover:bg-slate-50/80">
                        <td class="p-4">
                            <div class="font-bold text-slate-800">{{ $r->peminjaman->anggota->nama_lengkap ?? '-' }}</div>
                            <div class="text-xs text-slate-500">
                                @foreach($r->peminjaman->detailPeminjamans ?? [] as $d)
                                    {{ $d->buku->judul_buku ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </div>
                        </td>
                        <td class="p-4 text-slate-600 whitespace-nowrap text-xs">{{ \Carbon\Carbon::parse($r->tanggal_kembali)->format('d M Y') }}</td>
                        <td class="p-4">
                            @if($r->denda > 0)
                                <span class="font-bold text-rose-600">Rp {{ number_format($r->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-8 text-center text-slate-400 text-sm">Belum ada riwayat pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Tabel Log Kunjungan -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800">Log Kunjungan Terbaru</h3>
        <span class="text-xs text-slate-400 font-medium">20 data terakhir</span>
    </div>
    <div class="overflow-x-auto max-h-[300px] overflow-y-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="sticky top-0 bg-white shadow-sm">
                <tr class="text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-100">Waktu</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Nama Pengunjung</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Tipe</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Keperluan / Instansi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pengunjungTerbaru as $k)
                <tr class="hover:bg-slate-50/80">
                    <td class="p-4 text-slate-600 whitespace-nowrap text-xs">
                        {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}, {{ $k->jam_masuk }}
                    </td>
                    <td class="p-4 font-bold text-slate-800">{{ $k->nama_pengunjung }}</td>
                    <td class="p-4">
                        @if($k->tipe == 'anggota')
                            <span class="bg-purple-100 text-purple-700 px-2.5 py-1 rounded-full text-xs font-semibold">Anggota</span>
                        @else
                            <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full text-xs font-semibold">Tamu Umum</span>
                        @endif
                    </td>
                    <td class="p-4 text-slate-600 text-sm">{{ $k->instansi ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-400 text-sm">Belum ada data kunjungan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
