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

    <!-- Main Content -->
    <main class="flex-1 max-w-3xl w-full mx-auto px-4 sm:px-6 py-10">
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

    <footer class="py-6 text-center text-sm text-slate-400">
        &copy; {{ date('Y') }} SIPERPUS SMA Negeri 1 Suwawa
    </footer>

</body>
</html>
