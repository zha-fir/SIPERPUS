@extends('layouts.app')

@section('title', 'Katalog Buku')
@section('page_title', 'Master Data Buku')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Katalog Buku</h3>
            <p class="text-sm text-slate-500">Kelola stok dan data buku referensi</p>
        </div>
        <button x-data @click="$dispatch('open-modal')" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Buku
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Kode Buku (Scan)</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Informasi Buku</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Kategori</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bukus as $b)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="p-4">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 inline-block text-center shadow-sm">
                            <svg class="barcode w-32 h-12" jsbarcode-value="{{ $b->kode_buku }}" jsbarcode-displayvalue="true" jsbarcode-height="35" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $b->judul }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">Penulis: {{ $b->penulis }} • {{ $b->tahun_terbit }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $b->penerbit }}</div>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 border border-slate-200 text-xs font-semibold rounded-full bg-white text-slate-600">{{ $b->kategori }}</span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex items-center justify-center space-x-1.5">
                            <div class="flex flex-col items-center">
                                <span class="text-lg font-bold {{ $b->jumlah_tersedia > 0 ? 'text-emerald-500' : 'text-rose-500' }}">{{ $b->jumlah_tersedia }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wide">Tersedia</span>
                            </div>
                            <span class="text-slate-300">/</span>
                            <div class="flex flex-col items-center">
                                <span class="text-lg font-bold text-slate-600">{{ $b->jumlah_total }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wide">Total</span>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-500">Belum ada data buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (Powered by AlpineJS) -->
<div x-data="{ open: false }" @open-modal.window="open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div x-show="open" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">Tambah Buku Baru</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_terbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="kategori" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Eksemplar Masuk <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_total" min="1" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="open = false" class="px-4 py-2 font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof JsBarcode !== 'undefined') {
            JsBarcode(".barcode").init();
        }
    });
</script>
@endsection
