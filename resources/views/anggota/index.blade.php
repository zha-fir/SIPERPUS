@extends('layouts.app')

@section('title', 'Data Anggota')
@section('page_title', 'Data Anggota')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Search & Filter Area -->
        <div class="flex flex-col sm:flex-row items-center gap-3 flex-1">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchAnggota" onkeyup="filterAnggota()" class="pl-9 w-full rounded-xl border border-slate-200 p-2 text-sm bg-white focus:border-primary focus:ring-primary transition-all" placeholder="Cari nama, barcode, ID...">
            </div>
            
            <div class="flex p-1 bg-slate-200/50 rounded-xl overflow-x-auto w-full sm:w-auto hidden-scrollbar">
                <button type="button" onclick="setFilterType('Semua', this)" class="filter-tab px-4 py-1.5 text-xs font-bold rounded-lg transition-all bg-white text-slate-800 shadow-sm border border-slate-200 whitespace-nowrap">Semua</button>
                <button type="button" onclick="setFilterType('Siswa', this)" class="filter-tab px-4 py-1.5 text-xs font-medium rounded-lg text-slate-500 hover:text-slate-700 transition-all whitespace-nowrap">Siswa</button>
                <button type="button" onclick="setFilterType('Guru', this)" class="filter-tab px-4 py-1.5 text-xs font-medium rounded-lg text-slate-500 hover:text-slate-700 transition-all whitespace-nowrap">Guru</button>
                <button type="button" onclick="setFilterType('Staf', this)" class="filter-tab px-4 py-1.5 text-xs font-medium rounded-lg text-slate-500 hover:text-slate-700 transition-all whitespace-nowrap">Staf</button>
            </div>
            <input type="hidden" id="currentFilterType" value="Semua">
        </div>

        <!-- Action Button -->
        <div class="flex items-center gap-2">
            <span id="countBadge" class="hidden sm:inline-flex px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full border border-slate-200">{{ count($anggotas) }} anggota</span>
            <button x-data @click="$dispatch('open-modal')" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md shadow-primary/30 flex items-center gap-2 transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Anggota
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-200">Barcode</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Identitas</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Nama Anggota</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Tipe / Kelas</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Daftar</th>
                    <th class="p-4 font-semibold border-b border-slate-200">Status</th>
                    <th class="p-4 font-semibold border-b border-slate-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($anggotas as $a)
                <tr class="anggota-row hover:bg-slate-50/80 transition-colors" data-nama="{{ strtolower($a->nama_lengkap) }}" data-barcode="{{ strtolower($a->barcode) }}" data-identitas="{{ strtolower($a->nomor_identitas) }}" data-tipe="{{ $a->tipe_anggota }}">
                    <td class="p-4">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 inline-block text-center shadow-sm">
                            <svg class="barcode w-32 h-12" jsbarcode-value="{{ $a->barcode }}" jsbarcode-displayvalue="true" jsbarcode-height="35" jsbarcode-width="1.5" jsbarcode-fontSize="14" jsbarcode-margin="0"></svg>
                        </div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-800">{{ $a->nomor_identitas }}</td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $a->nama_lengkap }}</div>
                        <div class="text-xs text-slate-500">{{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} &middot; {{ $a->no_telepon ?? '-' }}</div>
                    </td>
                    <td class="p-4 text-sm text-slate-600">
                        <span class="font-semibold text-primary">{{ $a->tipe_anggota }}</span><br>
                        <span class="text-xs">{{ $a->kelas_atau_jabatan ?? '-' }}</span>
                    </td>
                    <td class="p-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($a->tanggal_daftar)->format('d M Y') }}</td>
                    <td class="p-4">
                        @if($a->status_anggota == 'aktif')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700 uppercase">{{ str_replace('_', ' ', $a->status_anggota) }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('anggota.show', $a->id_anggota) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-primary hover:text-white text-slate-600 text-xs font-bold rounded-lg transition-colors border border-slate-200 hover:border-primary shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="7" class="p-8 text-center text-slate-500">Belum ada data anggota.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- No result message -->
        <div id="noResultRow" class="hidden p-8 text-center text-slate-500">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-sm">Tidak ada anggota yang cocok dengan pencarian.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah (Powered by AlpineJS) -->
<div x-data="{ open: false }" @open-modal.window="open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-end sm:items-center justify-center min-h-screen sm:px-4">
        <!-- Backdrop -->
        <div x-show="open" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative w-full sm:max-w-2xl bg-white rounded-t-3xl sm:rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 border border-slate-100">
            <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-bold text-slate-800">Tambah Anggota Baru</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="p-5 sm:p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tipe Anggota <span class="text-red-500">*</span></label>
                            <select name="tipe_anggota" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                                <option value="Siswa">Siswa</option>
                                <option value="Guru">Guru</option>
                                <option value="Staf">Staf</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Identitas (NIS/NIP) <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_identitas" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Kelas / Jabatan</label>
                            <input type="text" name="kelas_atau_jabatan" placeholder="Contoh: XII IPA 1 / Guru Matematika" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">No Telepon / WhatsApp</label>
                            <input type="text" name="no_telepon" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-primary focus:ring-primary transition-all">
                        </div>
                    </div>

                    <div class="bg-indigo-50 text-indigo-700 text-sm p-3 rounded-lg flex items-start gap-2 border border-indigo-100">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Sistem akan meng-generate Barcode unik dan mengatur status otomatis menjadi AKTIF.</span>
                    </div>
                </div>
                <div class="px-5 sm:px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" @click="open = false" class="order-2 sm:order-1 px-4 py-2.5 font-medium text-slate-600 hover:text-slate-800 transition-colors rounded-xl border border-slate-200 text-sm">Batal</button>
                    <button type="submit" class="order-1 sm:order-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md shadow-primary/30 transition-all">Simpan Anggota</button>
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

    function setFilterType(type, btnElement) {
        document.getElementById('currentFilterType').value = type;
        
        // Update styling of tabs
        document.querySelectorAll('.filter-tab').forEach(el => {
            el.classList.remove('bg-white', 'text-slate-800', 'shadow-sm', 'border-slate-200', 'font-bold');
            el.classList.add('text-slate-500', 'font-medium', 'border-transparent');
        });
        
        btnElement.classList.remove('text-slate-500', 'font-medium', 'border-transparent');
        btnElement.classList.add('bg-white', 'text-slate-800', 'shadow-sm', 'border-slate-200', 'font-bold');
        
        filterAnggota();
    }

    function filterAnggota() {
        const query = document.getElementById('searchAnggota').value.toLowerCase().trim();
        const activeType = document.getElementById('currentFilterType').value;
        const rows = document.querySelectorAll('.anggota-row');
        const noResult = document.getElementById('noResultRow');
        const countBadge = document.getElementById('countBadge');
        let visible = 0;

        rows.forEach(function(row) {
            const nama = row.getAttribute('data-nama') || '';
            const barcode = row.getAttribute('data-barcode') || '';
            const identitas = row.getAttribute('data-identitas') || '';
            const tipe = row.getAttribute('data-tipe') || '';

            const matchQuery = nama.includes(query) || barcode.includes(query) || identitas.includes(query);
            const matchType = (activeType === 'Semua') || (tipe === activeType);

            if (matchQuery && matchType) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (countBadge) {
            countBadge.textContent = visible + ' anggota';
        }

        if (noResult) {
            noResult.classList.toggle('hidden', visible > 0 || rows.length === 0);
        }
    }
</script>
@endsection
