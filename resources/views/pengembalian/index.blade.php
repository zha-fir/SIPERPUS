@extends('layouts.app')

@section('title', 'Pengembalian Buku')
@section('page_title', 'Data Pengembalian')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Riwayat Pengembalian</h3>
            <p class="text-sm text-slate-500">Transkrip pengembalian buku dan kalkulasi denda.</p>
        </div>
        <a href="{{ route('pengembalian.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-emerald-600/30 flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            Proses Pengembalian Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Waktu Kembali</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Data Peminjaman</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Status</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengembalians as $p)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="p-4">
                        <div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</div>
                        <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('H:i') }} WITA</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">Trx #{{ str_pad($p->id_peminjaman, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-sm text-slate-600 mt-1">{{ optional($p->peminjaman->anggota)->nama }} ({{ optional($p->peminjaman->anggota)->kelas }})</div>
                    </td>
                    <td class="p-4">
                        @if($p->status == 'tepat_waktu')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Tepat Waktu</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm">
                        @if($p->denda > 0)
                            <span class="font-bold text-rose-600">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-slate-400 font-semibold">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-500">Belum ada riwayat pengembalian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
