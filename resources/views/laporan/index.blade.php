@extends('layouts.app')

@section('title', 'Laporan & Statistik')
@section('page_title', 'Laporan & Statistik')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <!-- Tab Navigation -->
    <div class="flex bg-white p-1.5 rounded-xl border border-slate-200 overflow-x-auto hide-scrollbar shrink-0 shadow-sm">
        <a href="?tab=sirkulasi&start_date={{ $startDate }}&end_date={{ $endDate }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $tab == 'sirkulasi' ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
            Sirkulasi
        </a>
        <a href="?tab=kunjungan&start_date={{ $startDate }}&end_date={{ $endDate }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $tab == 'kunjungan' ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
            Kunjungan
        </a>
        <a href="?tab=statistik&start_date={{ $startDate }}&end_date={{ $endDate }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $tab == 'statistik' ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
            Top Statistik
        </a>
    </div>

    <!-- Date Filter & Print -->
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full sm:w-auto px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            <span class="flex items-center text-slate-400 text-sm">sd</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full sm:w-auto px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-xl text-sm font-medium shadow-sm transition-all flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            </button>
        </form>
        @if($tab != 'statistik')
        <a href="{{ route('laporan.cetak', ['jenis' => $tab, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-orange-50 border border-orange-100 hover:bg-orange-100 text-orange-700 px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak {{ ucfirst($tab) }}
        </a>
        @endif
    </div>
</div>

@if($tab == 'sirkulasi')
<!-- TAB SIRKULASI -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg></div>
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peminjaman Periode Ini</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_peminjaman_periode']) }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengembalian Periode Ini</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_pengembalian_periode']) }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kas Denda</p>
            <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($stats['total_denda_periode'], 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sedang Berjalan (Aktif)</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ count($peminjamanAktif) }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Riwayat Pengembalian & Denda</h3>
        <span class="text-xs text-slate-400 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
    </div>
    <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="sticky top-0 bg-white shadow-sm z-10">
                <tr class="text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-100">Peminjam & Buku</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Tgl Pinjam</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Tgl Kembali</th>
                    <th class="p-4 font-semibold border-b border-slate-100 text-right">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayatSirkulasi as $r)
                <tr class="hover:bg-slate-50/80">
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $r->peminjaman->anggota->nama_lengkap ?? '-' }}</div>
                        <div class="text-xs text-slate-500">
                            @foreach($r->peminjaman->detailPeminjamans ?? [] as $d)
                                {{ $d->buku->judul_buku ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </div>
                    </td>
                    <td class="p-4 text-slate-600 whitespace-nowrap text-xs">{{ \Carbon\Carbon::parse($r->peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="p-4 text-slate-600 whitespace-nowrap text-xs">{{ \Carbon\Carbon::parse($r->tanggal_kembali)->format('d M Y') }}</td>
                    <td class="p-4 text-right">
                        @if($r->denda > 0)
                            <span class="font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded">Rp {{ number_format($r->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-400 text-sm">Tidak ada riwayat sirkulasi pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@elseif($tab == 'kunjungan')
<!-- TAB KUNJUNGAN -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Kunjungan Periode Ini</p>
        <div class="flex items-end gap-3">
            <h3 class="text-4xl font-bold text-slate-800">{{ number_format($stats['total_kunjungan_periode']) }}</h3>
            <span class="text-sm text-slate-500 font-medium mb-1">Pengunjung</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Daftar Buku Tamu</h3>
        <span class="text-xs text-slate-400 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
    </div>
    <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="sticky top-0 bg-white shadow-sm z-10">
                <tr class="text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-slate-100">Waktu Kunjungan</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Nama Pengunjung</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Tipe / Kategori</th>
                    <th class="p-4 font-semibold border-b border-slate-100">Keperluan / Instansi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kunjungan as $k)
                <tr class="hover:bg-slate-50/80">
                    <td class="p-4 text-slate-600 whitespace-nowrap text-xs">
                        <span class="font-bold">{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}</span>, {{ $k->jam_masuk }}
                    </td>
                    <td class="p-4 font-bold text-slate-800">{{ $k->nama_pengunjung }}</td>
                    <td class="p-4">
                        @if($k->tipe == 'anggota')
                            <span class="bg-purple-100 text-purple-700 px-2.5 py-1 rounded-full text-[10px] uppercase font-bold tracking-wider">Anggota</span>
                        @else
                            <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full text-[10px] uppercase font-bold tracking-wider">Tamu Umum</span>
                        @endif
                    </td>
                    <td class="p-4 text-slate-600 text-sm">{{ $k->instansi ?? $k->keperluan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-400 text-sm">Tidak ada catatan buku tamu pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@elseif($tab == 'statistik')
<!-- TAB STATISTIK POPULER -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    
    <!-- Top Buku -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                Top 5 Buku Paling Sering Dipinjam
            </h3>
        </div>
        <div class="p-2">
            @forelse($topBuku as $index => $b)
            <div class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-xl transition-colors">
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center shrink-0">
                    {{ $index + 1 }}
                </div>
                <div class="w-10 h-14 bg-slate-200 rounded border border-slate-200 overflow-hidden shrink-0">
                    @if($b->cover_buku)
                        <img src="{{ Storage::url($b->cover_buku) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $b->judul_buku }}</h4>
                    <p class="text-xs text-slate-500 truncate">{{ $b->penulis }}</p>
                </div>
                <div class="text-right shrink-0">
                    <span class="bg-amber-100 text-amber-700 font-bold px-2.5 py-1 rounded-lg text-xs">{{ $b->total_dipinjam }}x Pinjam</span>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 text-sm">Belum ada statistik peminjaman.</div>
            @endforelse
        </div>
    </div>

    <!-- Top Anggota -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                Top 5 Anggota Teraktif
            </h3>
        </div>
        <div class="p-2">
            @forelse($topAnggota as $index => $a)
            <div class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-xl transition-colors">
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center shrink-0">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $a->nama_lengkap }}</h4>
                    <p class="text-xs text-slate-500 truncate">{{ ucfirst($a->tipe_anggota) }} - {{ $a->nomor_identitas }}</p>
                </div>
                <div class="text-right shrink-0">
                    <span class="bg-emerald-100 text-emerald-700 font-bold px-2.5 py-1 rounded-lg text-xs">{{ $a->total_pinjam }}x Pinjam</span>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 text-sm">Belum ada statistik anggota.</div>
            @endforelse
        </div>
    </div>

    <!-- Ringkasan Koleksi -->
    <div class="bg-orange-600 rounded-2xl shadow-md overflow-hidden lg:col-span-2 text-white relative">
        <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
            <svg class="w-64 h-64 -mt-10 -mr-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
        </div>
        <div class="p-6 sm:p-8 relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-xl font-bold mb-1">Status Koleksi Perpustakaan</h3>
                <p class="text-orange-200 text-sm">Ringkasan total jumlah buku dan ketersediaan saat ini.</p>
            </div>
            <div class="flex gap-4 sm:gap-8">
                <div class="text-center">
                    <p class="text-orange-200 text-[11px] font-bold uppercase tracking-wider mb-1">Total Judul</p>
                    <h4 class="text-3xl font-bold">{{ number_format($stats['total_koleksi_judul']) }}</h4>
                </div>
                <div class="w-px bg-orange-500/50"></div>
                <div class="text-center">
                    <p class="text-orange-200 text-[11px] font-bold uppercase tracking-wider mb-1">Total Eksemplar</p>
                    <h4 class="text-3xl font-bold">{{ number_format($stats['total_koleksi_eksemplar']) }}</h4>
                </div>
                <div class="w-px bg-orange-500/50"></div>
                <div class="text-center">
                    <p class="text-orange-200 text-[11px] font-bold uppercase tracking-wider mb-1">Buku Kosong/Habis</p>
                    <h4 class="text-3xl font-bold text-rose-300">{{ number_format($stats['koleksi_habis']) }}</h4>
                </div>
            </div>
            <a href="{{ route('laporan.cetak', ['jenis' => 'koleksi']) }}" target="_blank" class="bg-white text-orange-700 hover:bg-orange-50 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Koleksi
            </a>
        </div>
    </div>
</div>
@endif

@endsection
