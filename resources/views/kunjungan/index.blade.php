@extends('layouts.app')

@section('title', 'Buku Tamu')
@section('page_title', 'Buku Tamu (Kunjungan)')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left: Scanner section -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
            
            <h3 class="text-lg font-bold text-slate-800 mb-1">Scan Barcode Anggota</h3>
            <p class="text-sm text-slate-500 mb-6">Arahkan kursor ke dalam form dan scan kartu siswa.</p>

            <form action="{{ route('kunjungan.storeScan') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <input type="text" name="barcode" id="barcodeScan" autofocus autocomplete="off" class="pl-10 w-full rounded-xl border-slate-200 shadow-sm focus:border-primary focus:ring-primary sm:text-lg p-3 bg-slate-50 transition-all border" placeholder="ANG-0000...">
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-medium py-3 px-4 rounded-xl shadow-lg shadow-primary/30 transition-all">Submit Scan</button>
            </form>
            <script>
                // Auto focus logic for scanner (only if not clicking another input)
                document.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                        document.getElementById('barcodeScan').focus();
                    }
                });
            </script>
        </div>

        <!-- Input Manual (Non-Anggota) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Pengunjung Umum</h3>
            <p class="text-sm text-slate-500 mb-6">Input manual untuk tamu atau non-anggota.</p>

            <form action="{{ route('kunjungan.storeUmum') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pengunjung" required class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-secondary focus:ring-secondary transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Asal Instansi (Opsional)</label>
                        <input type="text" name="instansi" class="w-full rounded-xl border border-slate-200 p-2.5 bg-slate-50 focus:border-secondary focus:ring-secondary transition-all">
                    </div>
                </div>
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-3 px-4 rounded-xl shadow-md transition-all">Simpan Data Tamu</button>
            </form>
        </div>
    </div>

    <!-- Right: Kunjungan Hari ini -->
    <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Kunjungan Hari Ini</h3>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('d F Y') }}</p>
            </div>
            <div class="px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-full">
                {{ $kunjungans->count() }} Orang
            </div>
        </div>
        <div class="flex-1 overflow-auto p-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold border-b border-slate-200">Waktu</th>
                        <th class="p-4 font-semibold border-b border-slate-200">Nama Pengunjung</th>
                        <th class="p-4 font-semibold border-b border-slate-200">Tipe / Info</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 relative">
                    @forelse($kunjungans as $k)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 text-sm font-medium text-slate-600 whitespace-nowrap">
                            {{ $k->jam_masuk }}
                        </td>
                        <td class="p-4">
                            @if($k->tipe == 'anggota')
                                <div class="font-bold text-slate-800">{{ $k->anggota->nama ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $k->anggota->kelas ?? '-' }} • {{ $k->anggota->barcode ?? '-' }}</div>
                            @else
                                <div class="font-bold text-slate-800">{{ $k->nama_pengunjung }}</div>
                                <div class="text-xs text-slate-500">{{ $k->instansi ?: '-' }}</div>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($k->tipe == 'anggota')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-100 text-blue-700">Anggota</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-orange-100 text-orange-700">Umum</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p>Belum ada kunjungan hari ini.</p>
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
