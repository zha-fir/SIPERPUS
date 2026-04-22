<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SIPERPUS</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (CDN for instant UI) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            900: '#312e81',
                        },
                        accent: {
                            500: '#f43f5e',
                            600: '#e11d48',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 2s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .book-gradient-1 { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
        .book-gradient-2 { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
        .book-gradient-3 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
        .book-gradient-4 { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%); }
        .book-gradient-5 { background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); }
        .book-gradient-6 { background: linear-gradient(135deg, #fdcbf1 0%, #fdcbf1 1%, #e6dee9 100%); }
        .book-gradient-7 { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); }
        .book-gradient-8 { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white">

    <!-- Navbar -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'glass-nav shadow-sm': scrolled, 'bg-transparent': !scrolled }"
         class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center font-display font-bold text-xl text-white shadow-lg shadow-primary-500/30">
                        S
                    </div>
                    <span class="font-display font-bold text-2xl tracking-tight text-slate-900">SIPERPUS</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Beranda</a>
                    <a href="#katalog" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Katalog Buku</a>
                    <a href="#tentang" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Tentang Kami</a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all bg-slate-900 rounded-full hover:bg-slate-800 hover:shadow-lg hover:shadow-slate-900/20 hover:-translate-y-0.5">
                        Login Admin
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-slate-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" class="md:hidden glass-nav absolute w-full border-b border-slate-200" style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#beranda" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Beranda</a>
                <a href="#katalog" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Katalog Buku</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Tentang Kami</a>
                <a href="{{ route('dashboard') }}" class="block px-3 py-3 mt-4 text-center rounded-lg text-base font-bold text-white bg-slate-900">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Decorative Elements -->
        <div class="absolute top-0 inset-x-0 h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-primary-100 mix-blend-multiply filter blur-3xl opacity-70 animate-float"></div>
            <div class="absolute top-40 -left-20 w-72 h-72 rounded-full bg-accent-500/10 mix-blend-multiply filter blur-3xl opacity-70 animate-float-delayed"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 border border-primary-100 text-primary-600 font-medium text-sm mb-8">
                <span class="flex h-2 w-2 rounded-full bg-primary-500"></span>
                Sistem Perpustakaan Modern
            </div>
            
            <h1 class="text-5xl md:text-7xl font-display font-extrabold text-slate-900 tracking-tight mb-8 leading-tight">
                Jelajahi Dunia Melalui <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-500">Koleksi Buku Kami</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-600 mb-10 leading-relaxed">
                Akses ribuan literatur berkualitas, buku pelajaran, dan novel inspiratif. Tingkatkan wawasan Anda bersama SIPERPUS.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#katalog" class="w-full sm:w-auto px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-full font-bold text-lg transition-all shadow-xl shadow-primary-500/30 hover:-translate-y-1">
                    Lihat Katalog Buku
                </a>
                <a href="#tentang" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-full font-bold text-lg transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Katalog Buku Section -->
    <section id="katalog" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4">Katalog Buku Terbaru</h2>
                    <p class="text-slate-600 text-lg">Temukan koleksi buku terbaru yang siap menemani waktu membaca Anda hari ini.</p>
                </div>
                <!-- Search bar placeholder -->
                <div class="relative w-full md:w-72">
                    <input type="text" placeholder="Cari buku..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all">
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            @if($bukus->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($bukus as $index => $buku)
                        @php
                            // Generate deterministic gradient class based on iteration
                            $gradientClass = 'book-gradient-' . (($index % 8) + 1);
                        @endphp
                        <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-slate-200 transition-all duration-300 hover:-translate-y-2 overflow-hidden flex flex-col h-full cursor-pointer">
                            <!-- Book Cover Mockup -->
                            <div class="w-full aspect-[3/4] {{ $gradientClass }} relative flex items-center justify-center p-6 overflow-hidden">
                                <!-- Subtle book spine effect -->
                                <div class="absolute left-0 top-0 bottom-0 w-3 bg-black/10"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                
                                <div class="relative z-10 text-center">
                                    <h3 class="text-white font-display font-bold text-xl drop-shadow-md leading-snug line-clamp-3">{{ $buku->judul_buku }}</h3>
                                    <p class="text-white/80 text-sm mt-2 font-medium drop-shadow-sm">{{ $buku->penulis }}</p>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-white text-xs font-semibold tracking-wide border border-white/30">
                                    {{ $buku->klasifikasi_ddc ?? 'Umum' }}
                                </div>
                            </div>
                            
                            <!-- Card Content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="font-bold text-slate-900 text-lg mb-1 line-clamp-2 group-hover:text-primary-600 transition-colors">{{ $buku->judul_buku }}</h4>
                                <p class="text-slate-500 text-sm mb-4">{{ $buku->penulis }} &middot; {{ $buku->tahun_terbit }}</p>
                                
                                <div class="mt-auto flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if($buku->jumlah_tersedia > 0)
                                            <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                            <span class="text-sm font-semibold text-emerald-600">Tersedia ({{ $buku->jumlah_tersedia }})</span>
                                        @else
                                            <span class="flex h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                            <span class="text-sm font-semibold text-rose-600">Dipinjam</span>
                                        @endif
                                    </div>
                                    <button class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Buku</h3>
                    <p class="text-slate-500">Katalog buku saat ini masih kosong.</p>
                </div>
            @endif

            <div class="mt-16 text-center">
                <a href="#" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-slate-200 hover:border-primary-500 text-slate-700 hover:text-primary-600 rounded-full font-bold transition-all bg-white hover:shadow-lg hover:shadow-primary-500/10">
                    Lihat Semua Koleksi
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-24 bg-slate-50 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Image / Graphics -->
                <div class="relative order-2 lg:order-1">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-accent-500 transform rotate-3 rounded-3xl opacity-20 blur-lg"></div>
                    <div class="relative bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="h-40 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="text-3xl font-display font-bold text-indigo-600 mb-1">10k+</div>
                                    <div class="text-sm font-medium text-indigo-900">Koleksi Buku</div>
                                </div>
                                <div class="h-32 rounded-2xl bg-gradient-to-br from-rose-100 to-orange-100 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="text-3xl font-display font-bold text-rose-600 mb-1">5k+</div>
                                    <div class="text-sm font-medium text-rose-900">Anggota Aktif</div>
                                </div>
                            </div>
                            <div class="space-y-4 pt-8">
                                <div class="h-32 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-100 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="text-3xl font-display font-bold text-emerald-600 mb-1">24/7</div>
                                    <div class="text-sm font-medium text-emerald-900">Akses Digital</div>
                                </div>
                                <div class="h-40 rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="text-3xl font-display font-bold text-blue-600 mb-1">100%</div>
                                    <div class="text-sm font-medium text-blue-900">Gratis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-50 border border-accent-100 text-accent-600 font-medium text-sm mb-6">
                        <span class="flex h-2 w-2 rounded-full bg-accent-500"></span>
                        Tentang Kami
                    </div>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-6 leading-tight">
                        Membangun Generasi Cerdas Melalui <span class="text-primary-600">Literasi</span>
                    </h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                        SIPERPUS adalah Sistem Informasi Perpustakaan terpadu yang dirancang untuk memudahkan siswa dan guru dalam mengakses sumber belajar. Kami berkomitmen menyediakan ekosistem perpustakaan yang modern, cepat, dan mudah digunakan.
                    </p>
                    
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Pencarian Cepat</h4>
                                <p class="text-slate-500 text-sm mt-1">Temukan buku yang Anda butuhkan dalam hitungan detik dengan sistem katalog terintegrasi kami.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Sistem Barcode</h4>
                                <p class="text-slate-500 text-sm mt-1">Proses peminjaman dan pengembalian lebih efisien menggunakan integrasi teknologi barcode.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Pantau Secara Real-time</h4>
                                <p class="text-slate-500 text-sm mt-1">Cek ketersediaan buku dan riwayat peminjaman Anda kapan saja dan di mana saja.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 pt-20 pb-10 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center font-display font-bold text-xl text-white">
                            S
                        </div>
                        <span class="font-display font-bold text-2xl tracking-tight text-white">SIPERPUS</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm mb-8">
                        Sistem Informasi Perpustakaan inovatif yang memberikan kemudahan akses literasi dan manajemen koleksi digital.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-primary-500 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-accent-500 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li><a href="#beranda" class="hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="#katalog" class="hover:text-primary-400 transition-colors">Katalog Buku</a></li>
                        <li><a href="#tentang" class="hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-primary-400 transition-colors">Portal Admin</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Kontak</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Pendidikan No. 123, Kota Pelajar, Indonesia</span>
                        </li>
                        <li class="flex gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@siperpus.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} SIPERPUS. Hak Cipta Dilindungi.
                </p>
                <div class="text-sm text-slate-500 flex gap-4">
                    <a href="#" class="hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
