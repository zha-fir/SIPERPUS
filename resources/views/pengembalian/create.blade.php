@extends('layouts.app')

@section('title', 'Proses Pengembalian')
@section('page_title', 'Proses Pengembalian Buku')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-emerald-50/50">
        <h3 class="text-lg font-bold text-slate-800">Scan Pengembalian Buku</h3>
        <p class="text-sm text-slate-500 mt-1">Pilih Transaksi ID yang akan dikembalikan secara menyeluruh.</p>
    </div>

    <div class="p-6">
        <form action="{{ route('pengembalian.store') }}" method="POST">
            @csrf
            
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">ID Transaksi Peminjaman <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" name="id_peminjaman" required autofocus class="w-full rounded-xl border border-emerald-200 p-3 bg-white focus:border-emerald-500 focus:ring-emerald-500 font-mono text-lg transition-all shadow-sm" placeholder="Contoh: 1">
                </div>
                <p class="text-xs text-slate-500 mt-2">Denda (Jika ada) akan dihitung otomatis: Rp1.000 / Hari / Buku.</p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('pengembalian.index') }}" class="px-6 py-3 font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition-all">Selesaikan Pengembalian</button>
            </div>
        </form>
    </div>
</div>
@endsection
