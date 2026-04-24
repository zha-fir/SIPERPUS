@extends('layouts.app')

@section('title', 'Detail Insiden')
@section('page_title', 'Tanggapi Tiket ' . $insiden->kode_tiket)

@section('content')
<div class="max-w-7xl mx-auto mb-6">
    <a href="{{ route('insiden.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Tiket
    </a>
</div>

<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Detail Laporan Kiri -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-start justify-between bg-slate-50/50">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 leading-tight mb-2">{{ $insiden->judul_insiden }}</h2>
                    <div class="flex items-center gap-3 text-sm text-slate-500 font-medium">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $insiden->pelapor_nama }} ({{ $insiden->pelapor_tipe }})
                        </span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $insiden->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Deskripsi Masalah</h4>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $insiden->deskripsi }}</div>
                
                @if($insiden->lampiran)
                <div class="mt-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Lampiran Bukti</h4>
                    <a href="{{ asset('storage/' . $insiden->lampiran) }}" target="_blank" class="block max-w-sm rounded-2xl overflow-hidden border border-slate-200 hover:border-primary transition-colors group relative">
                        <img src="{{ asset('storage/' . $insiden->lampiran) }}" alt="Lampiran" class="w-full h-auto object-cover group-hover:opacity-90 transition-opacity">
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="px-4 py-2 bg-white text-slate-900 font-bold rounded-lg text-sm">Lihat Penuh</span>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Kanan: Aksi & Tanggapan -->
    <div class="space-y-6">
        
        <!-- Info Panel -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Informasi Tiket</h3>
            <ul class="space-y-3">
                <li class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-medium">Kode Tiket</span>
                    <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ $insiden->kode_tiket }}</span>
                </li>
                <li class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-medium">Kategori</span>
                    <span class="font-semibold text-slate-700">{{ $insiden->kategori }}</span>
                </li>
                <li class="flex justify-between items-center text-sm pt-3 border-t border-slate-100">
                    <span class="text-slate-500 font-medium">Status Saat Ini</span>
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-{{ $insiden->status_color }}-100 text-{{ $insiden->status_color }}-700 border border-{{ $insiden->status_color }}-200 uppercase tracking-wider">{{ $insiden->status }}</span>
                </li>
                <li class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-medium">Prioritas</span>
                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-md bg-{{ $insiden->prioritas_color }}-50 text-{{ $insiden->prioritas_color }}-600 border border-{{ $insiden->prioritas_color }}-100 uppercase tracking-wider">{{ $insiden->prioritas }}</span>
                </li>
            </ul>
        </div>

        <!-- Form Tindakan -->
        <div class="bg-white rounded-3xl shadow-sm border border-primary-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
            <div class="p-6">
                <h3 class="font-bold text-slate-800 mb-4">Tanggapi & Perbarui</h3>
                
                <form action="{{ route('insiden.update', $insiden->id_insiden) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ubah Status</label>
                        <select name="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-sm font-semibold text-slate-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="Menunggu" {{ $insiden->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses" {{ $insiden->status == 'Diproses' ? 'selected' : '' }}>Diproses (Sedang Ditangani)</option>
                            <option value="Selesai" {{ $insiden->status == 'Selesai' ? 'selected' : '' }}>Selesai (Sudah Terpecahkan)</option>
                            <option value="Ditolak" {{ $insiden->status == 'Ditolak' ? 'selected' : '' }}>Ditolak / Batal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ubah Prioritas</label>
                        <select name="prioritas" class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-sm font-semibold text-slate-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="Rendah" {{ $insiden->prioritas == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="Sedang" {{ $insiden->prioritas == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tinggi" {{ $insiden->prioritas == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="Kritis" {{ $insiden->prioritas == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pesan Balasan / Solusi</label>
                        <textarea name="tanggapan_admin" rows="4" class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary resize-none placeholder-slate-400" placeholder="Ketik balasan untuk pelapor...">{{ $insiden->tanggapan_admin }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-600 text-white rounded-xl font-bold transition-all shadow-md shadow-primary/30 mt-2">
                        Simpan Pembaruan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
