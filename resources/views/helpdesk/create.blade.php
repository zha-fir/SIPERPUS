<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - SIPERPUS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'glass-nav shadow-sm': scrolled, 'bg-white border-b border-slate-200': !scrolled }"
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
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Beranda</a>
                    <a href="{{ route('home') }}#tentang" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Tentang Kami</a>
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Katalog Buku</a>
                    <a href="{{ route('helpdesk.create') }}" class="text-sm font-semibold text-accent-600 border-b-2 border-accent-600 pb-1">Pusat Bantuan</a>
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
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Beranda</a>
                <a href="{{ route('home') }}#tentang" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Tentang Kami</a>
                <a href="{{ route('katalog.index') }}" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-primary-600 hover:bg-slate-50">Katalog Buku</a>
                <a href="{{ route('helpdesk.create') }}" @click="mobileMenuOpen = false" class="block px-3 py-3 rounded-md text-base font-medium text-accent-600 bg-accent-50">Pusat Bantuan</a>
                <a href="{{ route('dashboard') }}" class="block px-3 py-3 mt-4 text-center rounded-lg text-base font-bold text-white bg-slate-900">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-3xl w-full mx-auto px-4 sm:px-6 pt-32 pb-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-3">Pusat Bantuan & Pelaporan</h1>
            <p class="text-slate-500 text-lg">Sampaikan kendala, kerusakan fasilitas, atau usulan Anda di sini.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary-500 to-accent-500"></div>
            
            <div class="p-6 md:p-10">
                <form action="{{ route('helpdesk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="pelapor_nama" required class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email (Opsional)</label>
                            <input type="email" name="pelapor_email" class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none" placeholder="Untuk notifikasi balasan">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Pelapor <span class="text-rose-500">*</span></label>
                            <select name="pelapor_tipe" required class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none appearance-none">
                                <option value="Siswa">Siswa</option>
                                <option value="Guru">Guru</option>
                                <option value="Staf">Staf Sekolah</option>
                                <option value="Umum">Umum / Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori Laporan <span class="text-rose-500">*</span></label>
                            <select name="kategori" required class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none appearance-none">
                                <option value="Kerusakan Fasilitas">Kerusakan Fasilitas / Buku</option>
                                <option value="Kendala Sistem">Kendala Sistem / Aplikasi</option>
                                <option value="Usulan Buku">Usulan Judul Buku Baru</option>
                                <option value="Kehilangan Buku">Lapor Kehilangan Buku</option>
                                <option value="Kehilangan Kartu">Lapor Kehilangan Kartu Anggota</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Laporan <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_insiden" required class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none" placeholder="Ringkasan singkat masalah Anda (misal: Buku Matematika Kelas 10 Hal 20 Robek)">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="deskripsi" rows="5" required class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none resize-none" placeholder="Ceritakan detail kendala atau usulan Anda di sini..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lampiran Foto/Screenshot (Opsional)</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition-colors">
                            <input type="file" name="lampiran" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer">
                            <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG. Maksimal 2MB. Sangat membantu kami jika ada bukti foto.</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('helpdesk.status.view') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors">Cek Status Tiket Saya</a>
                        <button type="submit" class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-md shadow-primary-500/30 hover:-translate-y-0.5">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

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
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#tentang" class="hover:text-primary-400 transition-colors">Tentang Kami</a></li>
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
