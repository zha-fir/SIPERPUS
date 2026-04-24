@extends('layouts.app')

@section('title', 'Manajemen Insiden')
@section('page_title', 'Daftar Tiket Helpdesk')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0"></div>
        <div class="relative z-10">
            <h2 class="text-xl font-bold text-slate-800">Tiket Masuk</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau dan tanggapi laporan insiden dari pengguna.</p>
        </div>
        
        <div class="relative z-10">
            <form action="{{ route('insiden.index') }}" method="GET" class="flex items-center gap-3">
                <select name="status" onchange="this.form.submit()" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ $status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ $status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ $status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="p-4 font-semibold w-10">#</th>
                        <th class="p-4 font-semibold">Kode Tiket / Tgl</th>
                        <th class="p-4 font-semibold">Pelapor</th>
                        <th class="p-4 font-semibold">Kategori & Judul</th>
                        <th class="p-4 font-semibold text-center">Prioritas</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($insidens as $index => $ins)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 text-sm text-slate-400 font-medium text-center">{{ $index + 1 }}</td>
                        <td class="p-4">
                            <div class="font-mono text-sm font-bold text-slate-700">{{ $ins->kode_tiket }}</div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-widest mt-1">{{ $ins->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-800 text-sm">{{ $ins->pelapor_nama }}</div>
                            <div class="text-xs font-semibold text-primary mt-0.5">{{ $ins->pelapor_tipe }}</div>
                        </td>
                        <td class="p-4 max-w-xs">
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider mb-1">{{ $ins->kategori }}</span>
                            <div class="font-bold text-slate-800 text-sm truncate" title="{{ $ins->judul_insiden }}">{{ $ins->judul_insiden }}</div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold rounded-md bg-{{ $ins->prioritas_color }}-50 text-{{ $ins->prioritas_color }}-600 border border-{{ $ins->prioritas_color }}-100 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $ins->prioritas_color }}-500"></span>
                                {{ $ins->prioritas }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-{{ $ins->status_color }}-100 text-{{ $ins->status_color }}-700 border border-{{ $ins->status_color }}-200">
                                {{ $ins->status }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('insiden.show', $ins->id_insiden) }}" class="inline-flex p-1.5 bg-slate-100 hover:bg-primary hover:text-white text-slate-600 rounded-lg transition-colors border border-slate-200 hover:border-primary shadow-sm" title="Tanggapi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium text-slate-500">Tidak ada tiket insiden ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
