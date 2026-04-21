@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Statistik')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
        <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Total Anggota</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalAnggota) }}</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
        <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Total Buku</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalBuku) }}</h3>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
        <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Buku Sedang Dipinjam</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalPeminjaman) }}</h3>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex items-center gap-5 hover:-translate-y-1 transition-transform duration-300">
        <div class="w-14 h-14 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Kunjungan Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalKunjunganHariIni) }}</h3>
        </div>
    </div>
</div>

<!-- Extra modern aesthetic section -->
<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 bg-gradient-to-br from-indigo-50 to-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
    <div class="relative z-10">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang di SIPERPUS!</h2>
        <p class="text-slate-600 max-w-2xl leading-relaxed mb-6">
            Sistem Informasi Perpustakaan berbasis modern. Anda dapat memantau aktivitas transaksi peminjaman, pengembalian, serta pencatatan buku tamu secara otomatis menggunakan fasilitas <i>Barcode Scanner</i>.
        </p>
        <div class="flex gap-4">
            <a href="{{ route('peminjaman.create') }}" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white font-medium rounded-xl shadow-lg shadow-primary/30 transition-all">Peminjaman Baru</a>
            <a href="{{ route('kunjungan.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-xl shadow-sm transition-all">Buka Buku Tamu</a>
        </div>
    </div>
</div>
@endsection
