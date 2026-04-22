@extends('layouts.app')

@section('title', 'Transaksi Peminjaman')
@section('page_title', 'Transaksi Peminjaman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

    <!-- Header: Search + Tombol Baru -->
    <div class="p-4 sm:p-5 border-b border-slate-100 bg-white flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <!-- Search Bar -->
        <div class="flex-1 max-w-xl relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input
                type="text"
                id="searchPeminjaman"
                placeholder="Cari transaksi (nama, kode anggota, judul, kode buku)..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                oninput="filterPeminjaman()"
            >
        </div>
        <!-- Count + Tombol Baru -->
        <div class="flex items-center gap-3 shrink-0">
            <span id="countBadge" class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full whitespace-nowrap">
                {{ $peminjamans->count() }} transaksi
            </span>
            <a href="{{ route('peminjaman.create') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Peminjaman Baru
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="tabelPeminjaman">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">ID / Waktu</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Peminjam</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Buku yang Dipinjam</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Jatuh Tempo</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" id="bodyPeminjaman">
                @forelse($peminjamans as $p)
                @php
                    $namaAnggota    = strtolower($p->anggota->nama_lengkap ?? '');
                    $barcodeAnggota = strtolower($p->anggota->barcode ?? '');
                    $judulBukus     = strtolower($p->detailPeminjamans->map(fn($d) => optional($d->buku)->judul_buku)->filter()->implode(' '));
                    $kodeBukus      = strtolower($p->detailPeminjamans->map(fn($d) => optional($d->buku)->kode_buku)->filter()->implode(' '));
                @endphp
                <tr class="hover:bg-slate-50/80 transition-colors peminjaman-row"
                    data-nama="{{ $namaAnggota }}"
                    data-barcode="{{ $barcodeAnggota }}"
                    data-judul="{{ $judulBukus }}"
                    data-kode="{{ $kodeBukus }}">
                    <td class="p-4">
                        <div class="font-bold text-slate-800">#TRX-{{ str_pad($p->id_peminjaman, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $p->anggota->nama_lengkap ?? '-' }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">
                            <span class="font-mono bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded text-[10px]">{{ $p->anggota->barcode ?? '-' }}</span>
                            <span class="ml-1">{{ $p->anggota->kelas_atau_jabatan ?? '' }}</span>
                        </div>
                    </td>
                    <td class="p-4">
                        <ul class="space-y-1">
                            @foreach($p->detailPeminjamans as $detail)
                                <li class="flex items-start gap-1.5 text-sm text-slate-700">
                                    <span class="font-mono text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded mt-0.5 shrink-0">{{ $detail->buku->kode_buku ?? '-' }}</span>
                                    <span>{{ $detail->buku->judul_buku ?? '-' }}
                                        @if($detail->status == 'dikembalikan')
                                            <span class="text-[10px] text-emerald-500 font-bold">✓</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="text-[11px] text-slate-400 mt-1">Total: {{ $p->detailPeminjamans->count() }} buku</div>
                    </td>
                    <td class="p-4">
                        <div class="text-sm font-medium {{ \Carbon\Carbon::now('Asia/Makassar')->startOfDay()->gt(\Carbon\Carbon::parse($p->tanggal_jatuh_tempo)) && $p->status == 'dipinjam' ? 'text-rose-600 font-bold' : 'text-slate-700' }}">
                            {{ \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="p-4">
                        @if($p->status == 'dipinjam')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Sedang Dipinjam</span>
                        @elseif($p->status == 'selesai')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Selesai</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada transaksi peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- No result message -->
        <div id="noResultRow" class="hidden p-8 text-center text-slate-500">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-sm">Tidak ada transaksi yang cocok dengan pencarian.</p>
            </div>
        </div>
    </div>
</div>

<script>
function filterPeminjaman() {
    const query = document.getElementById('searchPeminjaman').value.toLowerCase().trim();
    const rows  = document.querySelectorAll('.peminjaman-row');
    const noResult = document.getElementById('noResultRow');
    let visible = 0;

    rows.forEach(function(row) {
        const nama    = row.getAttribute('data-nama')    || '';
        const barcode = row.getAttribute('data-barcode') || '';
        const judul   = row.getAttribute('data-judul')   || '';
        const kode    = row.getAttribute('data-kode')    || '';

        const match = nama.includes(query) || barcode.includes(query)
                   || judul.includes(query) || kode.includes(query);

        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    // Update badge
    document.getElementById('countBadge').textContent = visible + ' transaksi';

    // Show/hide no result message
    if (noResult) {
        noResult.classList.toggle('hidden', visible > 0 || rows.length === 0);
    }
}
</script>
@endsection
