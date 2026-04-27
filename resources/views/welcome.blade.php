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
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            900: '#14532d',
                        },
                        accent: {
                            500: '#f97316',
                            600: '#ea580c',
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
                    <img src="{{ asset('images/logo-perpus.png') }}" alt="Logo Perpustakaan SMA N 1 Suwawa" class="w-12 h-12 object-contain drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="font-display font-bold text-xl tracking-tight text-slate-900 leading-none">SMA NEGERI 1</span>
                        <span class="text-xs text-slate-500 font-semibold tracking-widest mt-1">SUWAWA</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Beranda</a>
                    <a href="#tentang" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Tentang Kami</a>
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Katalog Buku</a>
                    <a href="{{ route('helpdesk.create') }}" class="text-sm font-semibold text-accent-600 hover:text-accent-700 transition-colors">Pusat Bantuan</a>
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
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Tentang Kami</a>
                <a href="{{ route('katalog.index') }}" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Katalog Buku</a>
                <a href="{{ route('helpdesk.create') }}" class="block px-3 py-3 rounded-md text-base font-medium text-accent-600 hover:text-accent-700 hover:bg-slate-50">Pusat Bantuan</a>
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
                Perpustakaan Digital Terpadu
            </div>
            
            <h1 class="text-5xl md:text-7xl font-display font-extrabold text-slate-900 tracking-tight mb-8 leading-tight">
                Selamat Datang di <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-500">Perpustakaan SMA N 1 Suwawa</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-600 mb-10 leading-relaxed">
                Akses ribuan literatur berkualitas, buku pelajaran, dan referensi belajar untuk mendukung kegiatan akademik Anda di SMA Negeri 1 Suwawa.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('katalog.index') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-full font-bold text-lg transition-all shadow-xl shadow-primary-500/30 hover:-translate-y-1">
                    Lihat Katalog Buku
                </a>
                <a href="#tentang" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 hover:border-slate-300 hover:bg-slate-50 rounded-full font-bold text-lg transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section id="visi-misi" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 border border-primary-100 text-primary-600 font-medium text-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-primary-500"></span>
                    Arah & Tujuan
                </div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-6 leading-tight">
                    Visi & Misi <span class="text-primary-600">Perpustakaan</span>
                </h2>
                <p class="text-slate-600 text-lg">Mewujudkan layanan literasi terbaik berbasis teknologi untuk seluruh warga SMA Negeri 1 Suwawa.</p>
            </div>

            <div class="grid lg:grid-cols-5 gap-8 items-stretch">
                <!-- Visi Card -->
                <div class="lg:col-span-2 bg-gradient-to-br from-primary-600 to-emerald-700 rounded-3xl p-8 md:p-10 text-white shadow-xl shadow-primary-900/20 relative overflow-hidden flex flex-col justify-center">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-40 h-40 rounded-full bg-black/10 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-display font-bold mb-4">Visi Kami</h3>
                        <p class="text-lg text-primary-50 leading-relaxed font-medium">
                            Terwujudnya perpustakaan SMA Negeri 1 Suwawa sebagai pusat menjelajah informasi dan layanan pembelajaran literasi yang berbasis ICT (Information and Communication Technology).
                        </p>
                    </div>
                </div>

                <!-- Misi Cards -->
                <div class="lg:col-span-3 grid sm:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-lg hover:border-primary-100 transition-all group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary-600 mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <span class="font-display font-bold text-xl">01</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Pengembangan SDM</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Pengembangan organisasi dan sumber daya manusia secara berkelanjutan.</p>
                    </div>
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-lg hover:border-primary-100 transition-all group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary-600 mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <span class="font-display font-bold text-xl">02</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Layanan Terautomasi</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Melaksanakan layanan perpustakaan yang sepenuhnya terautomasi berbasis teknologi digital.</p>
                    </div>
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-lg hover:border-primary-100 transition-all group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary-600 mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <span class="font-display font-bold text-xl">03</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Layanan Prima</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Melayani semua warga sekolah dengan standar layanan prima dan responsif.</p>
                    </div>
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-lg hover:border-primary-100 transition-all group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary-600 mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <span class="font-display font-bold text-xl">04</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Wadah Literasi</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Menerapkan perpustakaan sebagai wadah berkegiatan siswa dalam memahami literasi.</p>
                    </div>
                </div>
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
                                <div class="h-40 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="text-3xl font-display font-bold text-orange-600 mb-1">10k+</div>
                                    <div class="text-sm font-medium text-orange-900">Koleksi Buku</div>
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
                        Profil Layanan
                    </div>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-6 leading-tight">
                        Fasilitas Perpustakaan <span class="text-primary-600">SMA N 1 Suwawa</span>
                    </h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                        Perpustakaan SMA Negeri 1 Suwawa hadir dengan fasilitas digital modern untuk memberikan kemudahan bagi seluruh siswa dan guru dalam mencari, meminjam, dan mengelola referensi belajar secara efisien.
                    </p>
                    
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Katalog Digital Terlengkap</h4>
                                <p class="text-slate-500 text-sm mt-1">Cari buku paket pelajaran maupun referensi dengan cepat melalui sistem pencarian katalog terintegrasi.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Peminjaman Berbasis Barcode</h4>
                                <p class="text-slate-500 text-sm mt-1">Proses sirkulasi buku (peminjaman & pengembalian) kini lebih cepat dan akurat menggunakan Kartu Pelajar ber-barcode.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">Jam Operasional Teratur</h4>
                                <p class="text-slate-500 text-sm mt-1">Perpustakaan melayani peminjaman setiap hari Senin - Jumat pada jam kerja sekolah (07.30 - 15.00 WITA).</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- SOP Layanan Pembaca Section -->
    <section id="sop-layanan" class="py-24 bg-white relative border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-50 border border-accent-100 text-accent-600 font-medium text-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-accent-500"></span>
                    Panduan
                </div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-6 leading-tight">
                    Alur Layanan <span class="text-accent-600">Pembaca</span>
                </h2>
                <p class="text-slate-600 text-lg">Langkah-langkah mudah memanfaatkan fasilitas perpustakaan SMA Negeri 1 Suwawa.</p>
            </div>

            <div class="relative">
                <!-- Vertical Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-slate-100 rounded-full"></div>
                
                <div class="space-y-12">
                    <!-- Step 1 & 2 -->
                    <div class="grid md:grid-cols-2 gap-8 md:gap-16">
                        <div class="md:text-right relative flex flex-col md:items-end group">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">01</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Simpan Barang Bawaan</h4>
                                <p class="text-slate-600 text-sm">Pemustaka datang menuju loker untuk memasukkan tas, topi, jaket ke loker yang disediakan.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -right-8 transform translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm">01</div>
                        </div>
                        <div class="relative flex flex-col md:items-start group md:pt-16">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">02</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Isi Daftar Hadir</h4>
                                <p class="text-slate-600 text-sm">Pemustaka mengisi kehadiran secara online melalui perangkat yang telah disediakan.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -left-8 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm mt-16">02</div>
                        </div>
                    </div>

                    <!-- Step 3 & 4 -->
                    <div class="grid md:grid-cols-2 gap-8 md:gap-16">
                        <div class="md:text-right relative flex flex-col md:items-end group">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">03</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Penelusuran OPAC</h4>
                                <p class="text-slate-600 text-sm">Pemustaka mencari buku langsung ke rak dengan penelusuran melalui <a href="{{ route('katalog.index') }}" class="text-primary-600 font-semibold hover:underline">Katalog OPAC</a>.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -right-8 transform translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm">03</div>
                        </div>
                        <div class="relative flex flex-col md:items-start group md:pt-16">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">04</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Lapor & Cari Buku</h4>
                                <p class="text-slate-600 text-sm">Pemustaka lapor kepada petugas atau langsung menuju ke rak sesuai nomor klasifikasi DDC.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -left-8 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm mt-16">04</div>
                        </div>
                    </div>

                    <!-- Step 5 & 6 -->
                    <div class="grid md:grid-cols-2 gap-8 md:gap-16">
                        <div class="md:text-right relative flex flex-col md:items-end group">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">05</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Membaca Buku</h4>
                                <p class="text-slate-600 text-sm">Setelah mendapatkan buku, pemustaka bisa membaca di tempat yang sudah disediakan.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -right-8 transform translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm">05</div>
                        </div>
                        <div class="relative flex flex-col md:items-start group md:pt-16">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">06</div>
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group-hover:border-primary-200 group-hover:shadow-lg transition-all w-full max-w-md">
                                <h4 class="font-bold text-slate-900 text-lg mb-2">Pengembalian Bacaan</h4>
                                <p class="text-slate-600 text-sm">Buku yang habis dibaca dikembalikan di tempat semula atau diserahkan ke petugas.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -left-8 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border-4 border-primary-100 text-primary-600 font-display font-bold text-lg items-center justify-center z-10 shadow-sm mt-16">06</div>
                        </div>
                    </div>

                    <!-- Step 7 -->
                    <div class="grid md:grid-cols-2 gap-8 md:gap-16">
                        <div class="md:text-right relative flex flex-col md:items-end group">
                            <div class="md:hidden w-12 h-12 rounded-full bg-primary-100 text-primary-600 font-display font-bold text-xl flex items-center justify-center mb-4">07</div>
                            <div class="bg-primary-600 p-6 rounded-2xl shadow-xl shadow-primary-500/20 text-white w-full max-w-md relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-xl -mr-10 -mt-10"></div>
                                <h4 class="font-bold text-white text-lg mb-2 relative z-10">Peminjaman Buku Keluar</h4>
                                <p class="text-primary-50 text-sm relative z-10">Apabila pemustaka akan meminjam bukunya, pemustaka menuju ke petugas layanan sirkulasi untuk proses peminjaman menggunakan Kartu Anggota.</p>
                            </div>
                            <div class="hidden md:flex absolute top-1/2 -right-8 transform translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-primary-600 text-white font-display font-bold text-lg items-center justify-center z-10 shadow-md border-4 border-white">07</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tata Tertib Section -->
    <section id="tata-tertib" class="py-24 bg-slate-900 relative text-slate-300">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="currentColor" stroke-width="1" fill="none"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"></rect>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-6 leading-tight">
                    Tata Tertib <span class="text-primary-500">Perpustakaan</span>
                </h2>
                <p class="text-slate-400 text-lg">Ketentuan yang harus ditaati demi kenyamanan dan kelancaran layanan perpustakaan bersama.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Keanggotaan -->
                <div class="bg-slate-800 rounded-3xl p-8 border border-slate-700 hover:border-slate-600 transition-colors">
                    <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Keanggotaan</h3>
                    <p class="text-sm mb-4">Yang berhak menjadi anggota perpustakaan adalah:</p>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500"></div> Peserta Didik</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500"></div> Guru</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500"></div> Tenaga Kependidikan</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500"></div> Wali Kelas</li>
                    </ul>
                </div>

                <!-- Ketentuan Peminjaman -->
                <div class="bg-slate-800 rounded-3xl p-8 border border-slate-700 hover:border-slate-600 transition-colors">
                    <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Ketentuan Peminjaman</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div> Jumlah pinjaman maksimal 3 (Tiga) buah.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div> Batas waktu peminjaman paling lambat 3 (Tiga) hari.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div> Bertanggung jawab atas buku yang dipinjam.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div> Buku referensi hanya boleh dibaca di tempat.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div> Harus menggunakan Kartu Perpustakaan/Pelajar.</li>
                    </ul>
                </div>

                <!-- Sanksi & Denda -->
                <div class="bg-slate-800 rounded-3xl p-8 border border-slate-700 hover:border-slate-600 transition-colors">
                    <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center text-rose-500 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Denda & Kerusakan</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-1.5 shrink-0"></div> Keterlambatan pengembalian buku dikenakan denda sebesar <b>Rp 1.000</b> per hari per buku.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-1.5 shrink-0"></div> Buku yang hilang harus diganti dengan buku yang sama.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-1.5 shrink-0"></div> Kerusakan atau coretan yang disengaja dapat mengakibatkan gugurnya keanggotaan.</li>
                        <li class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-rose-500 mt-1.5 shrink-0"></div> Kartu Perpustakaan yang hilang/rusak dikenakan biaya penggantian <b>Rp 25.000</b>.</li>
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
                        <li><a href="#tentang" class="hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('katalog.index') }}" class="hover:text-primary-400 transition-colors">Katalog Buku</a></li>
                        <li><a href="{{ route('helpdesk.create') }}" class="hover:text-accent-400 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-primary-400 transition-colors">Portal Admin</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Kontak Perpustakaan</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Suwawa, Kabupaten Bone Bolango, Provinsi Gorontalo</span>
                        </li>
                        <li class="flex gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>perpus@sman1suwawa.sch.id</span>
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
