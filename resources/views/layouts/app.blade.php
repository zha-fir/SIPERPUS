<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPERPUS') - Sistem Informasi Perpustakaan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#16a34a', secondary: '#ea580c' }
                }
            }
        }
    </script>
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        #sidebar { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        #main-wrapper { transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        nav::-webkit-scrollbar { width: 4px; }
        nav::-webkit-scrollbar-track { background: transparent; }
        nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <!-- Overlay (mobile only — not shown on desktop) -->
    <div
        id="sidebar-overlay"
        x-show="sidebarOpen && window.innerWidth < 1024"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden"
        style="display: none;"
    ></div>

    <!-- ====== SIDEBAR ====== -->
    <aside
        id="sidebar"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-40 w-64 bg-slate-900 text-white flex flex-col h-full shadow-2xl"
    >
        <!-- Logo -->
        <div class="h-16 flex items-center px-4 border-b border-slate-700 bg-slate-950/50 shrink-0">
            <div class="flex items-center gap-3 flex-1">
                <img src="{{ asset('logo.png') }}" alt="Logo SMA Negeri 1 Suwawa" class="w-10 h-10 object-contain drop-shadow-md">
                <div class="flex flex-col">
                    <span class="font-bold text-base tracking-wide leading-none text-white">SMA NEGERI 1</span>
                    <span class="text-[11px] text-slate-400 font-medium tracking-widest mt-1">SUWAWA</span>
                </div>
            </div>
            <!-- Close button (all screens) -->
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white transition-colors p-1 rounded-lg hover:bg-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-2 px-2">Main Menu</div>

            <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('kunjungan.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('kunjungan.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span class="font-medium">Manajemen Kunjungan</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 mt-6 px-2">Transaksi</div>

            <a href="{{ route('peminjaman.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('peminjaman.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span class="font-medium">Transaksi Peminjaman</span>
            </a>

            <a href="{{ route('pengembalian.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('pengembalian.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span class="font-medium">Transaksi Pengembalian</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 mt-6 px-2">Master Data</div>

            <a href="{{ route('anggota.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('anggota.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Data Anggota</span>
            </a>

            <a href="{{ route('buku.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('buku.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-medium">Data Buku</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 mt-6 px-2">Laporan & Statistik</div>

            <a href="{{ route('insiden.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('insiden.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Manajemen Insiden</span>
            </a>

            <a href="{{ route('laporan.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Laporan & Statistik</span>
            </a>
        </nav>

        <!-- User info + logout (sidebar footer) -->
        <div class="px-4 py-4 border-t border-slate-700 bg-slate-950/50 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-sm font-bold shrink-0">
                    A
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold truncate">Administrator</h4>
                    <span class="text-xs text-emerald-400 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span> Online
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" title="Logout" class="w-8 h-8 rounded-lg bg-rose-500/20 hover:bg-rose-500/40 text-rose-400 hover:text-rose-300 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ====== MAIN WRAPPER ====== -->
    <div id="main-wrapper" :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'" class="flex-1 flex flex-col min-h-screen overflow-hidden w-full">

        <!-- ====== HEADER ====== -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-20 shrink-0 sticky top-0">
            <!-- Left: Hamburger + Title -->
            <div class="flex items-center gap-3">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-base sm:text-lg font-bold text-slate-800 truncate">@yield('page_title', 'Dashboard')</h1>
            </div>

            <!-- Right: Date + Logout -->
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="text-xs sm:text-sm text-slate-500 bg-slate-100 px-2.5 sm:px-3 py-1.5 rounded-full font-medium hidden md:block">
                    {{ \Carbon\Carbon::now('Asia/Makassar')->translatedFormat('l, d F Y · H:i') }} WITA
                </div>
                <!-- Mobile: only icon logout -->
                <form action="{{ route('logout') }}" method="POST" class="m-0 hidden sm:block">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-3 sm:px-4 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-full font-medium transition-colors border border-rose-100 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- ====== FLASH MESSAGES ====== -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-20 right-4 sm:right-8 left-4 sm:left-auto bg-emerald-500/95 backdrop-blur-sm text-white px-4 sm:px-6 py-3 rounded-xl shadow-lg border border-emerald-400 flex items-center gap-3 z-50 sm:max-w-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show"
             class="fixed top-20 right-4 sm:right-8 left-4 sm:left-auto bg-rose-500/95 backdrop-blur-sm text-white px-4 sm:px-6 py-3 rounded-xl shadow-lg border border-rose-400 flex items-start gap-3 z-50 sm:max-w-sm">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="flex-1 text-sm">
                @if(session('error'))
                    <span class="font-medium block">{{ session('error') }}</span>
                @endif
                @if($errors->any())
                    <ul class="mt-1 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button @click="show = false" class="hover:bg-rose-600 p-1 rounded-lg transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        <!-- ====== MAIN CONTENT ====== -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- ====== BOTTOM NAV (Mobile only) ====== -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 flex items-center z-30 shadow-lg shadow-slate-900/10">
            <a href="{{ route('dashboard') }}" class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-[10px] font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('kunjungan.index') }}" class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('kunjungan.*') ? 'text-primary' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span class="text-[10px] font-semibold">Kunjungan</span>
            </a>
            <a href="{{ route('peminjaman.index') }}" class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('peminjaman.*') ? 'text-primary' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span class="text-[10px] font-semibold">Peminjaman</span>
            </a>
            <a href="{{ route('pengembalian.index') }}" class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('pengembalian.*') ? 'text-primary' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span class="text-[10px] font-semibold">Kembali</span>
            </a>
            <button @click="sidebarOpen = true" class="flex-1 flex flex-col items-center py-2.5 gap-1 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span class="text-[10px] font-semibold">Menu</span>
            </button>
        </nav>

    </div><!-- end main wrapper -->

</div><!-- end flex container -->

</body>
</html>
