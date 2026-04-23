@extends('layouts.app')

@section('title', 'Peminjaman Baru (POS)')
@section('page_title', 'Sistem Kasir Peminjaman')

@section('content')
<div x-data="peminjamanPOS()" x-init="$watch('step', value => { if(value===1) setTimeout(() => $refs.memberInput.focus(), 100); if(value===2) setTimeout(() => $refs.bookInput.focus(), 100); })" class="max-w-4xl mx-auto">

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
    <div x-show="step === 1" x-transition.opacity.duration.300ms class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden text-center p-10 mt-8">
        <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-slate-800 mb-2">Scan Kartu Anggota</h2>
        <p class="text-slate-500 mb-8">Silakan scan barcode pada kartu identitas anggota untuk memulai sesi peminjaman.</p>

        <form @submit.prevent="checkMember" class="max-w-md mx-auto relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <input type="text" x-model="memberBarcode" x-ref="memberInput" :disabled="isLoading" autofocus required autocomplete="off" class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-slate-200 bg-slate-50 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/20 font-mono text-xl text-center transition-all shadow-inner" placeholder="Tembak Barcode Disini...">
            
            <!-- Loading overlay -->
            <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        </form>
    </div>

    <!-- FASE 2: Kasir Peminjaman (Member Identified) -->
    <div x-show="step === 2" style="display: none;" x-transition.opacity.duration.300ms class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: POS Actions -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Book Scanner Input -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-orange-500"></div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Input Barang (Buku)</h3>
                
                <form @submit.prevent="checkBook" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <input type="text" x-model="bookBarcode" x-ref="bookInput" :disabled="isLoading" autocomplete="off" class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-orange-100 bg-orange-50/30 focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 font-mono text-xl transition-all" placeholder="Scan Barcode Buku...">
                    
                    <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <svg class="animate-spin h-5 w-5 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- Cart Table (Checkout) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col min-h-[300px]">
                <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Daftar Buku Dipinjam
                    </h3>
                    <span class="bg-orange-100 text-orange-700 font-bold px-3 py-1 rounded-full text-xs" x-text="books.length + ' Item'"></span>
                </div>
                
                <div class="flex-1 overflow-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-xs uppercase tracking-wider">
                                <th class="p-3 pl-6 font-semibold w-16">No</th>
                                <th class="p-3 font-semibold">Kode Buku</th>
                                <th class="p-3 font-semibold">Judul & Detail</th>
                                <th class="p-3 font-semibold w-20 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(book, index) in books" :key="book.kode_buku">
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="p-3 pl-6 text-sm font-medium text-slate-500" x-text="index + 1"></td>
                                    <td class="p-3">
                                        <span class="font-mono text-xs font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded" x-text="book.kode_buku"></span>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-bold text-slate-800 text-sm" x-text="book.judul"></div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            <span x-text="book.penulis"></span> &bull; <span class="text-orange-500" x-text="book.klasifikasi"></span>
                                        </div>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button @click="removeBook(index)" type="button" class="text-slate-300 hover:text-rose-500 transition-colors p-2 rounded-lg hover:bg-rose-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="books.length === 0">
                                <td colspan="4" class="p-10 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <p>Keranjang kosong. Mulai scan buku.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Member Biodata & Submit -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Member Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-primary to-orange-600"></div>
                <div class="px-6 pb-6 relative">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-md border-4 border-white mx-auto -mt-10 flex items-center justify-center text-primary text-2xl font-black mb-3 overflow-hidden">
                        <!-- Placeholder Foto -->
                        <span x-text="memberData ? memberData.nama.charAt(0).toUpperCase() : ''"></span>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-lg font-black text-slate-800" x-text="memberData ? memberData.nama : '-'"></h3>
                        <div class="text-sm font-bold text-slate-500 mt-1" x-text="memberData ? memberData.kelas : '-'"></div>
                        
                        <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div> Aktif
                        </div>
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

            <!-- Checkout Form -->
            <form action="{{ route('peminjaman.store') }}" method="POST" id="posForm">
                @csrf
                <input type="hidden" name="barcode_anggota" :value="memberData ? memberData.barcode : ''">
                
                <template x-for="book in books" :key="book.kode_buku">
                    <input type="hidden" name="kode_buku[]" :value="book.kode_buku">
                </template>

                <div class="bg-white p-6 rounded-2xl shadow-lg border border-primary/10">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Total Item</p>
                            <h2 class="text-4xl font-black text-slate-800" x-text="books.length"></h2>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-500">Jatuh Tempo</p>
                            <p class="font-bold text-slate-800">{{ \Carbon\Carbon::now('Asia/Makassar')->addDays(7)->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <button type="submit" :disabled="books.length === 0" :class="{'opacity-50 cursor-not-allowed': books.length === 0}" class="w-full bg-primary hover:bg-primary/90 text-white py-4 rounded-xl font-bold text-lg shadow-xl shadow-primary/30 transition-all flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Selesaikan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('peminjamanPOS', () => ({
        step: 1, 
        memberBarcode: '',
        memberData: null,
        bookBarcode: '',
        books: [], 
        errorMsg: '',
        isLoading: false,

        async checkMember() {
            if(!this.memberBarcode) return;
            this.isLoading = true;
            this.errorMsg = '';
            
            try {
                const response = await fetch(`/api/anggota/cek?barcode=${this.memberBarcode}`);
                const result = await response.json();
                
                if(result.success) {
                    this.memberData = result.data;
                    this.step = 2; // Pindah ke fase 2
                } else {
                    this.errorMsg = result.message;
                    this.memberBarcode = ''; // Reset input agar bisa di scan ulang
                }
            } catch (e) {
                this.errorMsg = "Terjadi kesalahan koneksi server.";
            } finally {
                this.isLoading = false;
            }
        },

        async checkBook() {
            if(!this.bookBarcode) return;
            this.isLoading = true;
            this.errorMsg = '';
            
            // Mencegah scan buku yang sama dua kali
            if (this.books.find(b => b.kode_buku === this.bookBarcode)) {
                this.errorMsg = 'Buku ini sudah ada di daftar keranjang.';
                this.bookBarcode = '';
                this.isLoading = false;
                setTimeout(() => this.$refs.bookInput.focus(), 50);
                return;
            }

            try {
                const response = await fetch(`/api/buku/cek?barcode=${this.bookBarcode}`);
                const result = await response.json();
                
                if(result.success) {
                    this.books.unshift(result.data); // Tambah ke urutan paling atas
                    this.bookBarcode = '';
                } else {
                    this.errorMsg = result.message;
                    this.bookBarcode = '';
                }
            } catch (e) {
                this.errorMsg = "Terjadi kesalahan koneksi server.";
            } finally {
                this.isLoading = false;
                // Selalu kembalikan fokus ke input buku agar siap scan berikutnya
                setTimeout(() => this.$refs.bookInput.focus(), 50);
            }
        },

        removeBook(index) {
            this.books.splice(index, 1);
            setTimeout(() => this.$refs.bookInput.focus(), 50);
        },

        resetPOS() {
            this.step = 1;
            this.memberBarcode = '';
            this.memberData = null;
            this.books = [];
            this.errorMsg = '';
        }
    }));
});
</script>
@endsection
