@extends('layouts.app')

@section('title', 'Data Buku')
@section('page_title', 'Data Buku')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between bg-slate-50/50">
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Search -->
            <div class="relative w-full sm:w-72">
                <input type="text" id="searchBuku" onkeyup="filterBuku()" placeholder="Cari judul, penulis, ISBN, atau rak..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all placeholder:text-slate-400 shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <!-- Availability Filter -->
            <input type="hidden" id="currentFilterAvailability" value="Semua">
            <div class="flex bg-slate-100/80 p-1 rounded-xl border border-slate-200 w-full sm:w-auto overflow-x-auto hide-scrollbar">
                <button onclick="setFilterAvailability('Semua', this)" class="filter-tab whitespace-nowrap flex-1 sm:flex-none px-4 py-1.5 text-sm rounded-lg bg-white text-slate-800 shadow-sm font-bold border border-slate-200 transition-all">Semua</button>
                <button onclick="setFilterAvailability('Tersedia', this)" class="filter-tab whitespace-nowrap flex-1 sm:flex-none px-4 py-1.5 text-sm rounded-lg text-slate-500 font-medium border border-transparent hover:text-slate-700 transition-all">Tersedia</button>
                <button onclick="setFilterAvailability('Habis', this)" class="filter-tab whitespace-nowrap flex-1 sm:flex-none px-4 py-1.5 text-sm rounded-lg text-slate-500 font-medium border border-transparent hover:text-slate-700 transition-all">Habis / Dipinjam</button>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto justify-end">
            <button onclick="togglePrintMode()" class="hidden sm:inline-flex bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-all items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Mode Cetak
            </button>
            <button onclick="cetakTerpilih()" id="btnCetakTerpilih" class="hidden bg-orange-50 border border-orange-100 hover:bg-orange-100 text-orange-700 px-3 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Terpilih
            </button>
            <span id="countBadge" class="hidden sm:inline-flex px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full border border-slate-200">{{ count($bukus) }} katalog</span>
            <button x-data @click="$dispatch('open-modal')" class="bg-primary hover:bg-primary/90 text-white px-4 py-2.5 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Buku
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="print-col hidden p-4 w-10 text-center border-b border-slate-200 transition-all">
                        <input type="checkbox" id="checkAllBuku" class="rounded text-primary border-slate-300 focus:ring-primary">
                    </th>
                    <th class="p-4 font-semibold border-b border-slate-200">Barcode / ISBN</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Informasi Bibliografi</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Klasifikasi / Rak</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Eksemplar</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bukus as $b)
                <tr class="buku-row hover:bg-slate-50/80 transition-colors" data-judul="{{ strtolower($b->judul_buku) }}" data-penulis="{{ strtolower($b->penulis) }}" data-isbn="{{ strtolower($b->isbn_issn ?? '') }}" data-ddc="{{ strtolower($b->klasifikasi_ddc ?? '') }}" data-rak="{{ strtolower($b->lokasi_rak ?? '') }}" data-tersedia="{{ $b->jumlah_tersedia > 0 ? 'true' : 'false' }}">
                    <td class="print-col hidden p-4 text-center transition-all">
                        <input type="checkbox" class="check-buku rounded text-primary border-slate-300 focus:ring-primary" value="{{ $b->id_buku }}">
                    </td>
                    <td class="p-4">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 inline-block text-center shadow-sm">
                            <svg class="barcode w-32 h-12" jsbarcode-value="{{ $b->kode_buku }}" jsbarcode-displayvalue="true" jsbarcode-height="35" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                        </div>
                        <div class="text-[10px] text-slate-500 text-center mt-1">ISBN: {{ $b->isbn_issn ?? '-' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="flex items-start gap-4">
                            <!-- Thumbnail Cover -->
                            <div class="w-16 h-24 shrink-0 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden flex items-center justify-center shadow-sm">
                                @if($b->cover_buku)
                                    <img src="{{ asset('storage/' . $b->cover_buku) }}" alt="Cover" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4h16v16H4z"></path></svg>
                                @endif
                            </div>
                            
                            <!-- Detail Info -->
                            <div>
                                <div class="font-bold text-slate-800 text-base leading-tight">{{ $b->judul_buku }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    <span class="font-medium text-slate-700">Penulis:</span> {{ $b->penulis }}<br>
                                    <span class="font-medium text-slate-700">Penerbit:</span> {{ $b->penerbit }} &middot; {{ $b->tempat_terbit ?? '-' }} ({{ $b->tahun_terbit }})<br>
                                    <span class="font-medium text-slate-700">Edisi:</span> {{ $b->edisi ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col gap-1.5">
                            <span class="px-2.5 py-1 border border-slate-200 text-xs font-semibold rounded-full bg-slate-50 text-slate-700 inline-flex w-max">DDC: {{ $b->klasifikasi_ddc ?? '-' }}</span>
                            <span class="px-2.5 py-1 border border-orange-100 text-xs font-semibold rounded-full bg-orange-50 text-orange-700 inline-flex w-max">Rak: {{ $b->lokasi_rak ?? '-' }}</span>
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
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('buku.cetak-barcode', ['ids' => $b->id_buku]) }}" target="_blank" title="Cetak Barcode" class="p-1.5 bg-slate-100 hover:bg-orange-500 hover:text-white text-slate-600 rounded-lg transition-colors border border-slate-200 hover:border-orange-500 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                            <button type="button" data-buku="{{ json_encode($b) }}" onclick="window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: JSON.parse(this.dataset.buku) }))" title="Edit Data" class="p-1.5 bg-slate-100 hover:bg-amber-500 hover:text-white text-slate-600 rounded-lg transition-colors border border-slate-200 hover:border-amber-500 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form action="{{ route('buku.destroy', $b->id_buku) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Permanen" class="p-1.5 bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-600 rounded-lg transition-colors border border-slate-200 hover:border-rose-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-slate-500">Belum ada data katalog buku.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- No result message -->
        <div id="noResultRow" class="hidden p-8 text-center text-slate-500">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-sm">Tidak ada katalog buku yang cocok dengan pencarian.</p>
            </div>
        </div>
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
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-5 sm:p-6 space-y-4 max-h-[70vh] overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Cover Buku</label>
                        <input type="file" name="cover_buku" accept="image/*" class="w-full rounded-xl border border-slate-200 p-2 text-sm bg-white focus:border-primary focus:ring-primary transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB. Boleh dikosongkan.</p>
                    </div>

                    <div class="sm:col-span-2">
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

<!-- Modal Edit (Powered by AlpineJS) -->
<div x-data="{ 
        editOpen: false, 
        buku: {},
        updateUrl: ''
    }" 
    @open-edit-modal.window="
        buku = $event.detail; 
        updateUrl = '/buku/' + buku.id_buku;
        editOpen = true;
    " 
    x-show="editOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-end sm:items-center justify-center min-h-screen sm:px-4">
        <div x-show="editOpen" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="editOpen = false"></div>

        <div x-show="editOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative w-full sm:max-w-3xl bg-white rounded-t-3xl sm:rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 border border-slate-100">
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">Edit Katalog Buku</h3>
                <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form :action="updateUrl" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-5 sm:p-6 space-y-4 max-h-[70vh] overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Cover Buku (Opsional)</label>
                        <input type="file" name="cover_buku" accept="image/*" class="w-full rounded-xl border border-slate-200 p-2 text-sm bg-white focus:border-primary focus:ring-primary transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengganti cover. Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_buku" x-model="buku.judul_buku" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-2 sm:col-span-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Penulis (Pengarang) <span class="text-red-500">*</span></label>
                            <input type="text" name="penulis" x-model="buku.penulis" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Edisi / Cetakan</label>
                            <input type="text" name="edisi" x-model="buku.edisi" placeholder="Contoh: Cetakan Ke-3" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" x-model="buku.penerbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_terbit" x-model="buku.tahun_terbit" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Terbit</label>
                            <input type="text" name="tempat_terbit" x-model="buku.tempat_terbit" placeholder="Contoh: Jakarta" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ISBN / ISSN</label>
                        <input type="text" name="isbn_issn" x-model="buku.isbn_issn" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Klasifikasi DDC</label>
                            <input type="text" name="klasifikasi_ddc" x-model="buku.klasifikasi_ddc" placeholder="Contoh: 800" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak" x-model="buku.lokasi_rak" placeholder="Contoh: RAK-01A" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Fisik</label>
                        <input type="text" name="deskripsi_fisik" x-model="buku.deskripsi_fisik" placeholder="Contoh: ix, 200 hlm.; 21 cm" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Eksemplar Total <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_total" x-model="buku.jumlah_total" min="1" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        <p class="text-[10px] text-orange-500 font-medium mt-1">Mengubah total akan otomatis menyesuaikan jumlah tersedia.</p>
                    </div>

                </div>
                <div class="px-5 sm:px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" @click="editOpen = false" class="order-2 sm:order-1 px-4 py-2.5 font-medium text-slate-600 hover:text-slate-800 transition-colors rounded-xl border border-slate-200 text-sm">Batal</button>
                    <button type="submit" class="order-1 sm:order-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md shadow-primary/30 transition-all">Simpan Perubahan</button>
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

    function setFilterAvailability(type, btnElement) {
        document.getElementById('currentFilterAvailability').value = type;
        
        // Update styling of tabs
        document.querySelectorAll('.filter-tab').forEach(el => {
            el.classList.remove('bg-white', 'text-slate-800', 'shadow-sm', 'border-slate-200', 'font-bold');
            el.classList.add('text-slate-500', 'font-medium', 'border-transparent');
        });
        
        btnElement.classList.remove('text-slate-500', 'font-medium', 'border-transparent');
        btnElement.classList.add('bg-white', 'text-slate-800', 'shadow-sm', 'border-slate-200', 'font-bold');
        
        filterBuku();
    }

    function filterBuku() {
        const query = document.getElementById('searchBuku').value.toLowerCase().trim();
        const activeType = document.getElementById('currentFilterAvailability').value;
        const rows = document.querySelectorAll('.buku-row');
        const noResult = document.getElementById('noResultRow');
        const countBadge = document.getElementById('countBadge');
        let visible = 0;

        rows.forEach(function(row) {
            const judul = row.getAttribute('data-judul') || '';
            const penulis = row.getAttribute('data-penulis') || '';
            const isbn = row.getAttribute('data-isbn') || '';
            const ddc = row.getAttribute('data-ddc') || '';
            const rak = row.getAttribute('data-rak') || '';
            const tersedia = row.getAttribute('data-tersedia') === 'true';

            const matchQuery = judul.includes(query) || penulis.includes(query) || isbn.includes(query) || ddc.includes(query) || rak.includes(query);
            
            let matchType = true;
            if (activeType === 'Tersedia') matchType = tersedia;
            if (activeType === 'Habis') matchType = !tersedia;

            if (matchQuery && matchType) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (countBadge) {
            countBadge.textContent = visible + ' katalog';
        }

        if (noResult) {
            noResult.classList.toggle('hidden', visible > 0 || rows.length === 0);
        }
    }

    document.getElementById('checkAllBuku')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.check-buku');
        checkboxes.forEach(cb => {
            if(cb.closest('tr').style.display !== 'none') {
                cb.checked = this.checked;
            }
        });
    });

    function togglePrintMode() {
        const cols = document.querySelectorAll('.print-col');
        cols.forEach(col => col.classList.toggle('hidden'));
        
        const btnCetak = document.getElementById('btnCetakTerpilih');
        if (btnCetak.classList.contains('hidden')) {
            btnCetak.classList.remove('hidden');
            btnCetak.classList.add('sm:inline-flex');
        } else {
            btnCetak.classList.add('hidden');
            btnCetak.classList.remove('sm:inline-flex');
            
            // Uncheck all when closing print mode
            document.getElementById('checkAllBuku').checked = false;
            document.querySelectorAll('.check-buku').forEach(cb => cb.checked = false);
        }
    }

    function cetakTerpilih() {
        const checked = document.querySelectorAll('.check-buku:checked');
        if (checked.length === 0) {
            alert('Pilih minimal satu buku untuk dicetak barcodenya!');
            return;
        }
        const ids = Array.from(checked).map(cb => cb.value).join(',');
        window.open("{{ route('buku.cetak-barcode') }}?ids=" + ids, '_blank');
    }
</script>
@endsection
