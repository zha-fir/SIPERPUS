<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPERPUS') - Sistem Informasi Perpustakaan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via CDN for instant preview without npm run dev for now, but configured for real usage) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#4f46e5', secondary: '#0ea5e9' }
                }
            }
        }
    </script>
    <!-- AlpineJS for interactive UI -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind CSS (compiled via Vite in production, commented out for now since CDN is used) -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- JsBarcode for rendering physical barcodes -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased overflow-hidden flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col h-full shadow-2xl z-20">
        <div class="h-16 flex items-center px-6 border-b border-slate-700 bg-slate-950/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-secondary flex items-center justify-center font-bold text-lg shadow-lg">
                    S
                </div>
                <span class="font-bold text-xl tracking-wide">SIPERPUS</span>
            </div>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto w-full">
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4 px-2">Main Menu</div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('kunjungan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('kunjungan.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span class="font-medium">Buku Tamu (Scan)</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-2">Transaksi</div>
            <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('peminjaman.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span class="font-medium">Peminjaman Buku</span>
            </a>
            <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('pengembalian.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span class="font-medium">Pengembalian Buku</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-8 px-2">Master Data</div>
            <a href="{{ route('anggota.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('anggota.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Data Anggota</span>
            </a>
            <a href="{{ route('buku.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('buku.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-medium">Katalog Buku</span>
            </a>
        </nav>
        
        <div class="px-6 py-4 border-t border-slate-700 bg-slate-950/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-sm font-bold">
                    A
                </div>
                <div>
                    <h4 class="text-sm font-semibold">Admin</h4>
                    <span class="text-xs text-green-400">Online</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main ContentWrapper -->
    <div class="flex-1 flex flex-col h-full bg-slate-50 relative">
        <!-- Header -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 z-10 sticky top-0">
            <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <div class="text-sm text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full font-medium">
                    {{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('l, d F Y - H:i') }} WITA
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="absolute top-20 right-8 bg-emerald-500/90 backdrop-blur-sm text-white px-6 py-3 rounded-xl shadow-lg border border-emerald-400 flex items-center gap-3 z-50 transform transition-all" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0" x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show" class="absolute top-20 right-8 bg-rose-500/90 backdrop-blur-sm text-white px-6 py-3 rounded-xl shadow-lg border border-rose-400 flex items-center gap-3 z-50">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                @if(session('error'))
                    <span class="font-medium block">{{ session('error') }}</span>
                @endif
                @if($errors->any())
                    <ul class="text-sm mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button @click="show = false" class="ml-4 hover:bg-rose-600 p-1 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
