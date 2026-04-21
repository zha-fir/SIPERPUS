@extends('layouts.app')

@section('title', 'Data Anggota')
@section('page_title', 'Master Data Anggota')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Anggota</h3>
            <p class="text-sm text-slate-500">Manajemen data siswa perpustakaan</p>
        </div>
        <button x-data @click="$dispatch('open-modal')" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Anggota
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Barcode</th>
                    <th class="p-4 font-semibold border-b border-slate-200">NIS</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Nama Siswa</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Kelas</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Daftar</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($anggotas as $a)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="p-4">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 inline-block text-center shadow-sm">
                            <svg class="barcode w-32 h-12" jsbarcode-value="{{ $a->barcode }}" jsbarcode-displayvalue="true" jsbarcode-height="35" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                        </div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-800">{{ $a->nis }}</td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $a->nama }}</div>
                    </td>
                    <td class="p-4 text-sm text-slate-600">{{ $a->kelas }}</td>
                    <td class="p-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($a->tanggal_daftar)->format('d M Y') }}</td>
                    <td class="p-4">
                        @if($a->status == 'aktif')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700 uppercase">{{ str_replace('_', ' ', $a->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-slate-500">Belum ada data anggota.</td></tr>
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
                <h3 class="text-lg font-bold text-slate-800">Tambah Anggota Baru</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Siswa <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                        <input type="text" name="kelas" required placeholder="Contoh: XII IPA 1" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="bg-indigo-50 text-indigo-700 text-sm p-3 rounded-lg flex items-start gap-2 border border-indigo-100">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Sistem akan meng-generate Barcode unik dan mengatur status otomatis menjadi AKTIF.</span>
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
