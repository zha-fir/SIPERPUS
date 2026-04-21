@extends('layouts.app')

@section('title', 'Peminjaman Buku')
@section('page_title', 'Data Peminjaman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Riwayat Peminjaman</h3>
            <p class="text-sm text-slate-500">Transkrip peminjaman buku oleh anggota.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Peminjaman Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">ID / Waktu</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Peminjam</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Buku yang Dipinjam</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Jatuh Tempo</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($peminjamans as $p)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="p-4">
                        <div class="font-bold text-slate-800">#TRX-{{ str_pad($p->id_peminjaman, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $p->anggota->nama }}</div>
                        <div class="text-xs text-slate-500">{{ $p->anggota->kelas }}</div>
                    </td>
                    <td class="p-4">
                        <ul class="text-sm text-slate-600 list-disc list-inside">
                            @foreach($p->detailPeminjamans as $detail)
                                <li>{{ $detail->buku->judul }} 
                                    @if($detail->status == 'dikembalikan')
                                        <span class="text-[10px] text-emerald-500 font-bold ml-1">✓</span>
                                    @endif
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
                <tr><td colspan="5" class="p-8 text-center text-slate-500">Belum ada transaksi peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
