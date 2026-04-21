@extends('layouts.app')

@section('title', 'Peminjaman Baru')
@section('page_title', 'Transaksi Peminjaman Baru')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-lg font-bold text-slate-800">Form Peminjaman (Sistem Barcode)</h3>
        <p class="text-sm text-slate-500 mt-1">Gunakan scanner untuk mengisi form secara otomatis.</p>
    </div>

    <div class="p-6">
        <form action="{{ route('peminjaman.store') }}" method="POST" x-data="{ books: [''] }">
            @csrf
            
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Barcode Anggota <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <input type="text" name="barcode_anggota" required autofocus autocomplete="off" class="pl-10 w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:border-primary focus:ring-primary font-mono text-lg transition-all" placeholder="Scan Barcode Anggota disini...">
                </div>
                <p class="text-xs text-slate-500 mt-2">Pastikan status anggota aktif.</p>
            </div>

            <div class="mb-8 p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-semibold text-indigo-900">Scan Koleksi Buku <span class="text-red-500">*</span></label>
                    <button type="button" @click="books.push('')" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-100 py-1.5 px-3 rounded-lg transition-colors">
                        + Tambah Buku Lain
                    </button>
                </div>
                
                <template x-for="(book, index) in books" :key="index">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="relative flex-1">
                            <input type="text" x-model="books[index]" name="kode_buku[]" required autocomplete="off" class="w-full rounded-xl border border-indigo-200 p-3 bg-white focus:border-primary focus:ring-primary font-mono transition-all shadow-sm" placeholder="Scan Barcode Buku...">
                        </div>
                        <button type="button" @click="books.length > 1 ? books.splice(index, 1) : null" :class="{'opacity-50 cursor-not-allowed': books.length <= 1}" class="p-3 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 border border-rose-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </template>
                <p class="text-xs text-indigo-500 mt-2">Anda dapat meminjam lebih dari 1 buku sekaligus. Klik "Tambah Buku" lalu scan berurutan.</p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all">Konfirmasi Peminjaman</button>
            </div>
        </form>
    </div>
</div>
@endsection
