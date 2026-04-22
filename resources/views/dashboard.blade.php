@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Statistik')

@section('content')


<!-- Unified Stat & Shortcut Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    
    <!-- 1. Buku Tamu -->
    <a href="{{ route('kunjungan.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-blue-300 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kunjungan Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalKunjunganHariIni) }}</h3>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <h4 class="font-bold text-slate-700 text-lg group-hover:text-blue-600 transition-colors">Manajemen Kunjungan</h4>
            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

    <!-- 2. Peminjaman -->
    <a href="{{ route('peminjaman.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Buku Dipinjam</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalPeminjaman) }}</h3>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <h4 class="font-bold text-slate-700 text-lg group-hover:text-emerald-600 transition-colors">Transaksi Peminjaman</h4>
            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

    <!-- 3. Pengembalian -->
    <a href="{{ route('pengembalian.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-amber-300 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status Transaksi</p>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100 mt-1">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div> Aktif
                </div>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <h4 class="font-bold text-slate-700 text-lg group-hover:text-amber-600 transition-colors">Transaksi Pengembalian</h4>
            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

    <!-- 4. Data Anggota -->
    <a href="{{ route('anggota.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-purple-300 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-fuchsia-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Anggota</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalAnggota) }}</h3>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <div>
                <h4 class="font-bold text-slate-700 text-lg group-hover:text-purple-600 transition-colors">Data Anggota</h4>
            </div>
            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

    <!-- 5. Katalog Buku -->
    <a href="{{ route('buku.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-pink-300 hover:shadow-xl hover:shadow-pink-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-pink-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-white flex items-center justify-center shadow-lg shadow-pink-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Bibliografi</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalBuku) }}</h3>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <div>
                <h4 class="font-bold text-slate-700 text-lg group-hover:text-pink-600 transition-colors">Data Buku</h4>
            </div>
            <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

    <!-- 6. Laporan -->
    <a href="{{ route('laporan.index') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-500/10 transition-all duration-300 relative overflow-hidden flex flex-col justify-between min-h-[160px]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-slate-100 rounded-full blur-3xl -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-600 to-slate-800 text-white flex items-center justify-center shadow-lg shadow-slate-500/30 group-hover:-translate-y-1 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pusat Data</p>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200 mt-1">
                    Export Ready
                </div>
            </div>
        </div>
        <div class="relative z-10 mt-6 flex items-center justify-between border-t border-slate-50 pt-4">
            <div>
                <h4 class="font-bold text-slate-700 text-lg group-hover:text-slate-800 transition-colors">Laporan Perpustakaan</h4>
            </div>
            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 group-hover:bg-slate-700 group-hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </a>

</div>
@endsection
