@extends('layouts.app')

@section('title', 'Pengembalian Buku (Interaktif)')
@section('page_title', 'Sistem Kasir Pengembalian')

@section('content')
<div x-data="pengembalianInteraktif()" x-init="$watch('step', value => { if(value===1) setTimeout(() => $refs.memberInput.focus(), 100); if(value===2) setTimeout(() => $refs.bookInput.focus(), 100); })" class="max-w-6xl mx-auto">

    <!-- Error Alert -->
    <template x-if="errorMsg">
        <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-sm animate-pulse">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="font-medium text-sm" x-text="errorMsg"></span>
            </div>
            <button @click="errorMsg = ''" class="text-rose-400 hover:text-rose-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>

    <!-- FASE 1: Scan Member -->
    <div x-show="step === 1" x-transition.opacity.duration.300ms class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden text-center p-10 mt-8">
        <div class="w-20 h-20 bg-emerald-500/10 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-slate-800 mb-2">Scan Kartu Anggota (Pengembalian)</h2>
        <p class="text-slate-500 mb-8">Silakan scan barcode anggota untuk melihat daftar buku yang sedang dipinjam.</p>

        <form @submit.prevent="checkMember" class="max-w-md mx-auto relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </div>
            <input type="text" x-model="memberBarcode" x-ref="memberInput" :disabled="isLoading" autofocus required autocomplete="off" class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 font-mono text-xl text-center transition-all shadow-inner" placeholder="Scan Barcode Anggota...">
            
            <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <svg class="animate-spin h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        </form>
    </div>

    <!-- FASE 2: Interaktif Pengembalian -->
    <div x-show="step === 2" style="display: none;" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Member & Scanner -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Member Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
                <div class="px-6 pb-6 relative">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-md border-4 border-white mx-auto -mt-10 flex items-center justify-center text-emerald-600 text-2xl font-black mb-3 overflow-hidden">
                        <span x-text="memberData ? memberData.nama.charAt(0).toUpperCase() : ''"></span>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-lg font-black text-slate-800" x-text="memberData ? memberData.nama : '-'"></h3>
                        <div class="text-sm font-bold text-slate-500 mt-1" x-text="memberData ? memberData.kelas : '-'"></div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400">Barcode / ID</p>
                            <p class="font-mono font-medium text-slate-700 text-sm" x-text="memberData ? memberData.barcode : '-'"></p>
                        </div>
                        <button type="button" @click="resetPOS()" class="text-xs font-bold text-rose-500 hover:text-rose-700 bg-rose-50 px-3 py-1.5 rounded-lg transition-colors">
                            Ganti Anggota
                        </button>
                    </div>
                </div>
            </div>

            <!-- Book Scanner Input -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Scan Buku Yang Dikembalikan</h3>
                
                <form @submit.prevent="processReturn" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <input type="text" x-model="bookBarcode" x-ref="bookInput" autocomplete="off" class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-emerald-100 bg-emerald-50/30 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 font-mono text-xl transition-all" placeholder="Tembak Barcode Buku...">
                </form>
            </div>

            <!-- Checkout Summary Form -->
            <form action="{{ route('pengembalian.store') }}" method="POST" id="returnForm">
                @csrf
                <template x-for="book in returnedBooks" :key="book.kode_buku">
                    <input type="hidden" name="kode_buku[]" :value="book.kode_buku">
                </template>

                <div class="bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-700 text-white">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-sm font-medium text-slate-400">Siap Dikembalikan</p>
                            <h2 class="text-4xl font-black text-white"><span x-text="returnedBooks.length"></span> <span class="text-xl font-medium text-slate-400">Buku</span></h2>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-slate-400">Estimasi Denda</p>
                            <p class="font-bold text-rose-400 text-xl" x-text="'Rp ' + totalDenda.toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                    
                    <button type="submit" :disabled="returnedBooks.length === 0" :class="{'opacity-50 cursor-not-allowed': returnedBooks.length === 0}" class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-900 py-4 rounded-xl font-bold text-lg shadow-xl shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Proses Pengembalian
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Tables -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            <!-- Tanggungan Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col flex-1">
                <div class="p-4 border-b border-slate-100 bg-rose-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-rose-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tanggungan Buku (Belum Kembali)
                    </h3>
                    <span class="bg-rose-100 text-rose-700 font-bold px-3 py-1 rounded-full text-xs" x-text="borrowedBooks.length + ' Buku'"></span>
                </div>
                
                <div class="flex-1 overflow-auto max-h-[300px]">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-xs uppercase tracking-wider sticky top-0">
                                <th class="p-3 pl-6 font-semibold">Buku</th>
                                <th class="p-3 font-semibold">Tgl Pinjam</th>
                                <th class="p-3 font-semibold">Jatuh Tempo</th>
                                <th class="p-3 font-semibold text-right">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="book in borrowedBooks" :key="book.kode_buku">
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-3 pl-6">
                                        <div class="font-bold text-slate-800 text-sm" x-text="book.judul"></div>
                                        <div class="font-mono text-xs text-slate-500 mt-0.5" x-text="book.kode_buku"></div>
                                    </td>
                                    <td class="p-3 text-sm text-slate-600" x-text="book.tanggal_pinjam"></td>
                                    <td class="p-3">
                                        <span :class="{'text-rose-600 font-bold': book.is_terlambat, 'text-slate-600': !book.is_terlambat}" class="text-sm" x-text="book.jatuh_tempo"></span>
                                        <template x-if="book.is_terlambat">
                                            <div class="text-[10px] text-rose-500 mt-0.5">Telat <span x-text="book.hari_telat"></span> hari</div>
                                        </template>
                                    </td>
                                    <td class="p-3 text-right">
                                        <span x-show="book.denda_estimasi > 0" class="font-bold text-rose-600 text-sm" x-text="'Rp' + book.denda_estimasi.toLocaleString('id-ID')"></span>
                                        <span x-show="book.denda_estimasi === 0" class="text-slate-400 text-sm">-</span>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="borrowedBooks.length === 0">
                                <td colspan="4" class="p-8 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <p>Anggota ini tidak memiliki tanggungan buku.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Returned Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col flex-1">
                <div class="p-4 border-b border-slate-100 bg-emerald-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-emerald-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Telah Di-scan (Siap Dikembalikan)
                    </h3>
                </div>
                
                <div class="flex-1 overflow-auto max-h-[300px]">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-xs uppercase tracking-wider sticky top-0">
                                <th class="p-3 pl-6 font-semibold">Buku</th>
                                <th class="p-3 font-semibold text-right">Denda</th>
                                <th class="p-3 font-semibold w-20 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(book, index) in returnedBooks" :key="book.kode_buku">
                                <tr class="bg-emerald-50/30 transition-colors">
                                    <td class="p-3 pl-6">
                                        <div class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                            <span class="text-emerald-500">✓</span> <span x-text="book.judul"></span>
                                        </div>
                                        <div class="font-mono text-xs text-slate-500 mt-0.5 ml-5" x-text="book.kode_buku"></div>
                                    </td>
                                    <td class="p-3 text-right">
                                        <span x-show="book.denda_estimasi > 0" class="font-bold text-rose-600 text-sm" x-text="'Rp' + book.denda_estimasi.toLocaleString('id-ID')"></span>
                                        <span x-show="book.denda_estimasi === 0" class="text-slate-400 text-sm">-</span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button @click="cancelReturn(index, book)" type="button" class="text-slate-400 hover:text-rose-500 transition-colors p-1" title="Batal kembalikan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="returnedBooks.length === 0">
                                <td colspan="3" class="p-6 text-center text-slate-400 text-sm">
                                    Belum ada buku yang di-scan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pengembalianInteraktif', () => ({
        step: 1, 
        memberBarcode: '',
        memberData: null,
        bookBarcode: '',
        
        borrowedBooks: [], // Daftar tanggungan
        returnedBooks: [], // Daftar yang sudah di-scan
        
        errorMsg: '',
        isLoading: false,

        get totalDenda() {
            return this.returnedBooks.reduce((sum, book) => sum + book.denda_estimasi, 0);
        },

        async checkMember() {
            if(!this.memberBarcode) return;
            this.isLoading = true;
            this.errorMsg = '';
            
            try {
                const response = await fetch(`/api/anggota/pinjaman-aktif?barcode=${this.memberBarcode}`);
                const result = await response.json();
                
                if(result.success) {
                    this.memberData = result.data.anggota;
                    this.borrowedBooks = result.data.tanggungan_buku;
                    this.returnedBooks = [];
                    this.step = 2; // Pindah ke fase 2
                } else {
                    this.errorMsg = result.message;
                    this.memberBarcode = ''; 
                }
            } catch (e) {
                this.errorMsg = "Terjadi kesalahan koneksi server.";
            } finally {
                this.isLoading = false;
            }
        },

        processReturn() {
            if(!this.bookBarcode) return;
            this.errorMsg = '';
            
            const barcodeToSearch = this.bookBarcode.trim();
            this.bookBarcode = ''; // Reset input langsung

            // 1. Cek apakah buku ada di daftar tanggungan
            const indexInBorrowed = this.borrowedBooks.findIndex(b => b.kode_buku === barcodeToSearch);
            
            if (indexInBorrowed !== -1) {
                // Buku ditemukan! Pindahkan dari borrowed ke returned
                const book = this.borrowedBooks[indexInBorrowed];
                this.borrowedBooks.splice(indexInBorrowed, 1);
                this.returnedBooks.unshift(book); // Taruh di atas
            } else {
                // 2. Cek apakah sudah di-scan sebelumnya
                const alreadyScanned = this.returnedBooks.find(b => b.kode_buku === barcodeToSearch);
                if (alreadyScanned) {
                    this.errorMsg = 'Buku ini sudah di-scan dan siap dikembalikan.';
                } else {
                    this.errorMsg = `Buku dengan barcode ${barcodeToSearch} tidak ditemukan dalam daftar tanggungan anggota ini.`;
                }
            }

            setTimeout(() => this.$refs.bookInput.focus(), 50);
        },

        cancelReturn(index, book) {
            // Pindahkan kembali dari returned ke borrowed
            this.returnedBooks.splice(index, 1);
            this.borrowedBooks.push(book);
            setTimeout(() => this.$refs.bookInput.focus(), 50);
        },

        resetPOS() {
            this.step = 1;
            this.memberBarcode = '';
            this.memberData = null;
            this.borrowedBooks = [];
            this.returnedBooks = [];
            this.errorMsg = '';
        }
    }));
});
</script>
@endsection
