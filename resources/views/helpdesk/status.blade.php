<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Tiket - SIPERPUS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Outfit', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#f0fdf4', 100: '#dcfce7', 500: '#22c55e', 600: '#16a34a', 900: '#14532d' },
                        accent: { 500: '#f97316', 600: '#ea580c' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-slate-600 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="font-semibold text-sm">Kembali ke Beranda</span>
            </a>
            <div class="font-display font-bold text-lg text-slate-900">SIPERPUS Helpdesk</div>
        </div>
    </header>

    <main class="flex-1 max-w-2xl w-full mx-auto px-4 sm:px-6 py-10">
        
        @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl mb-8 border border-emerald-200 shadow-sm text-center">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="font-bold text-lg mb-1">{{ session('success') }}</h3>
            <p class="text-emerald-600/80 text-sm">Gunakan form di bawah ini untuk melacak tanggapan Pustakawan kapan saja.</p>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8 mb-8">
            <h2 class="text-xl font-display font-bold text-slate-900 mb-2">Cek Status Laporan Anda</h2>
            <p class="text-slate-500 text-sm mb-6">Masukkan Kode Tiket yang Anda dapatkan setelah mengirim laporan.</p>
            
            <form action="{{ route('helpdesk.status.view') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="kode" value="{{ $kode ?? '' }}" required placeholder="Contoh: TKT-20231015-XYZ12" class="flex-1 rounded-xl border border-slate-200 p-3.5 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none font-mono uppercase">
                <button type="submit" class="px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold transition-colors">
                    Lacak Tiket
                </button>
            </form>

            @if(session('error'))
            <p class="text-rose-500 text-sm font-semibold mt-3">{{ session('error') }}</p>
            @endif
        </div>

        @if(isset($insiden) && $insiden)
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div>
                    <div class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold font-mono tracking-widest mb-3">
                        {{ $insiden->kode_tiket }}
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 leading-snug">{{ $insiden->judul_insiden }}</h1>
                    <div class="text-sm text-slate-500 mt-2 flex items-center gap-2">
                        <span class="font-medium text-slate-700">{{ $insiden->pelapor_nama }}</span>
                        <span>&middot;</span>
                        <span>{{ $insiden->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="shrink-0">
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-{{ $insiden->status_color }}-100 text-{{ $insiden->status_color }}-700 border border-{{ $insiden->status_color }}-200 inline-block uppercase tracking-wider">
                        {{ $insiden->status }}
                    </span>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-slate-50/50">
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Laporan</h3>
                    <p class="text-slate-700 whitespace-pre-wrap">{{ $insiden->deskripsi }}</p>
                </div>

                @if($insiden->tanggapan_admin)
                <div class="bg-primary-50 rounded-2xl p-6 border border-primary-100 relative">
                    <div class="absolute -top-3 -left-3 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white border-4 border-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-primary-700 uppercase tracking-wider mb-2 ml-4">Tanggapan Pustakawan</h3>
                    <p class="text-primary-900 whitespace-pre-wrap ml-4">{{ $insiden->tanggapan_admin }}</p>
                    <p class="text-primary-600/60 text-xs font-semibold ml-4 mt-3">Diperbarui pada: {{ $insiden->updated_at->format('d M Y, H:i') }}</p>
                </div>
                @else
                <div class="bg-slate-100 rounded-2xl p-6 text-center border border-slate-200 border-dashed">
                    <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-slate-500 font-medium">Belum ada tanggapan dari Pustakawan.</p>
                </div>
                @endif
            </div>
            
            <div class="p-6 border-t border-slate-100 text-center">
                <a href="{{ route('helpdesk.create') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">Buat Laporan Baru</a>
            </div>
        </div>
        @endif
    </main>

    <footer class="py-6 text-center text-sm text-slate-400 mt-auto">
        &copy; {{ date('Y') }} SIPERPUS SMA Negeri 1 Suwawa
    </footer>

</body>
</html>
