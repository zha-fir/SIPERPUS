@extends('layouts.app')

@section('title', 'Data Buku')
@section('page_title', 'Data Buku')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 flex items-center justify-end bg-slate-50/50">
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
                    <th class="p-4 font-semibold border-b border-slate-200">Barcode / ISBN</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Informasi Bibliografi</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Klasifikasi / Rak</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Eksemplar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bukus as $b)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="p-4">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 inline-block text-center shadow-sm">
                            <svg class="barcode w-32 h-12" jsbarcode-value="{{ $b->kode_buku }}" jsbarcode-displayvalue="true" jsbarcode-height="35" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                        </div>
                        <div class="text-[10px] text-slate-500 text-center mt-1">ISBN: {{ $b->isbn_issn ?? '-' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800 text-base leading-tight">{{ $b->judul_buku }}</div>
                        <div class="text-xs text-slate-500 mt-1">
                            <span class="font-medium text-slate-700">Penulis:</span> {{ $b->penulis }}<br>
                            <span class="font-medium text-slate-700">Penerbit:</span> {{ $b->penerbit }} &middot; {{ $b->tempat_terbit ?? '-' }} ({{ $b->tahun_terbit }})<br>
                            <span class="font-medium text-slate-700">Edisi:</span> {{ $b->edisi ?? '-' }}
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col gap-1.5">
                            <span class="px-2.5 py-1 border border-slate-200 text-xs font-semibold rounded-full bg-slate-50 text-slate-700 inline-flex w-max">DDC: {{ $b->klasifikasi_ddc ?? '-' }}</span>
                            <span class="px-2.5 py-1 border border-indigo-100 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 inline-flex w-max">Rak: {{ $b->lokasi_rak ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex items-center justify-center space-x-2">
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-bold {{ $b->jumlah_tersedia > 0 ? 'text-emerald-500' : 'text-rose-500' }}">{{ $b->jumlah_tersedia }}</span>
                                <span class="text-[9px] text-slate-400 uppercase tracking-widest font-semibold">Tersedia</span>
                            </div>
                            <span class="text-slate-200 text-2xl font-light">/</span>
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-bold text-slate-400">{{ $b->jumlah_total }}</span>
                                <span class="text-[9px] text-slate-400 uppercase tracking-widest font-semibold">Total</span>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-500">Belum ada data katalog buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (Powered by AlpineJS) -->
<div x-data="{ open: false }" @open-modal.window="open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-end sm:items-center justify-center min-h-screen sm:px-4">
        <div x-show="open" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative w-full sm:max-w-3xl bg-white rounded-t-3xl sm:rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 border border-slate-100">
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">Tambah Katalog Buku</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[70vh] overflow-y-auto">
                    
                    <div class="col-span-full">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_buku" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penulis (Pengarang) <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Edisi / Cetakan</label>
                        <input type="text" name="edisi" placeholder="Contoh: Cetakan Ke-3" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_terbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Terbit</label>
                            <input type="text" name="tempat_terbit" placeholder="Contoh: Jakarta" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ISBN / ISSN</label>
                        <input type="text" name="isbn_issn" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Klasifikasi DDC</label>
                            <input type="text" name="klasifikasi_ddc" placeholder="Contoh: 800" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak" placeholder="Contoh: RAK-01A" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Fisik</label>
                        <input type="text" name="deskripsi_fisik" placeholder="Contoh: ix, 200 hlm.; 21 cm" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Eksemplar Masuk <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_total" min="1" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>

                </div>
                <div class="px-5 sm:px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" @click="open = false" class="order-2 sm:order-1 px-4 py-2.5 font-medium text-slate-600 hover:text-slate-800 transition-colors rounded-xl border border-slate-200 text-sm">Batal</button>
                    <button type="submit" class="order-1 sm:order-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md shadow-primary/30 transition-all">Simpan Buku</button>
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
