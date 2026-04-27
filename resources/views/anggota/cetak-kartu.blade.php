<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota - SIPERPUS</title>
    <!-- JsBarcode and html2pdf -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0f3a5a; /* Deep Blue */
            --secondary: #fdb913; /* Yellow */
            --text-dark: #1e293b;
            --text-light: #64748b;
            --font-main: 'Inter', sans-serif;
            --font-display: 'Poppins', sans-serif;
        }

        body {
            background-color: #e2e8f0;
            margin: 0;
            padding: 20px;
            font-family: var(--font-main);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            background: transparent;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10mm;
            align-content: flex-start;
        }

        /* CR80 Standard Size */
        .id-card {
            width: 86mm;
            height: 54mm;
            position: relative;
            background-color: #ffffff;
            box-sizing: border-box;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 3mm;
            page-break-inside: avoid;
        }

        /* ================= DEPAN ================= */
        /* Header Background with curve */
        .card-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 16mm;
            background: var(--primary);
            z-index: 1;
            /* Subtle curved bottom */
            border-bottom: 1.5mm solid var(--secondary);
        }

        /* Header Content */
        .header-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 16mm;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 3mm;
            box-sizing: border-box;
        }

        .logo-box {
            width: 15mm;
            height: 15mm;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .header-text {
            flex: 1;
            text-align: center;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .h-provinsi {
            font-size: 4pt;
            font-weight: 500;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }
        .h-school {
            font-family: var(--font-display);
            font-size: 7.5pt;
            font-weight: 700;
            margin: 0.5mm 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .h-address {
            font-size: 3.5pt;
            font-weight: 400;
            opacity: 0.8;
        }

        /* Main Body */
        .card-body {
            position: absolute;
            top: 17mm;
            left: 0;
            width: 100%;
            height: 37mm; /* 54 - 17 */
            z-index: 2;
            display: flex;
            padding: 2mm 3mm;
            box-sizing: border-box;
            background: radial-gradient(circle at right bottom, #f8fafc, #ffffff);
        }

        /* Left Side: Photo */
        .photo-section {
            width: 22mm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-frame {
            width: 20mm;
            height: 26mm;
            border-radius: 2mm;
            overflow: hidden;
            background-color: #cbd5e1;
            border: 0.5mm solid var(--secondary);
            box-shadow: 0 4px 6px rgba(15, 58, 90, 0.15);
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            background: #e2e8f0;
        }

        /* Right Side: Data */
        .data-section {
            flex: 1;
            padding-left: 4mm;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 11pt;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 1px;
            margin-bottom: 2mm;
            text-transform: uppercase;
            border-bottom: 0.5mm solid #e2e8f0;
            padding-bottom: 1mm;
            display: inline-block;
        }

        .biodata-table {
            width: 100%;
            border-collapse: collapse;
        }

        .biodata-table td {
            padding: 0.5mm 0;
            vertical-align: top;
            line-height: 1.2;
        }

        .label-col {
            width: 15mm;
            font-size: 5.5pt;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
        }
        .colon-col {
            width: 1.5mm;
            font-size: 5.5pt;
            color: var(--text-light);
        }
        .value-col {
            font-size: 6.5pt;
            font-weight: 700;
            color: var(--text-dark);
        }

        .bottom-bar {
            position: absolute;
            bottom: 3mm;
            left: 26mm;
            width: calc(100% - 29mm);
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            z-index: 3;
        }

        .barcode-container {
            height: 9mm;
            background: white;
            /* Using flex to properly size SVG */
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .barcode-container svg {
            height: 100%;
        }

        /* Signature (Now on Back Card) */
        .back-signature {
            width: 25mm;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 1mm;
            flex-shrink: 0;
        }

        .sig-date {
            font-size: 4pt;
            color: var(--text-light);
            margin-bottom: 0.5mm;
        }
        .sig-role {
            font-size: 4.5pt;
            font-weight: 700;
            color: var(--primary);
        }
        .sig-img {
            height: 13mm;
            width: auto;
            max-width: 100%;
            margin: 0.5mm auto;
            display: block;
        }
        .sig-name {
            font-size: 4.5pt;
            font-weight: 800;
            color: var(--text-dark);
            text-decoration: underline;
            white-space: nowrap;
        }

        /* Abstract shapes */
        .shape-1 {
            position: absolute;
            bottom: -5mm;
            right: -5mm;
            width: 25mm;
            height: 25mm;
            border-radius: 50%;
            background: var(--secondary);
            opacity: 0.1;
            z-index: 1;
        }
        .shape-2 {
            position: absolute;
            top: 10mm;
            left: -10mm;
            width: 30mm;
            height: 30mm;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.05;
            z-index: 1;
        }

        .back-body {
            position: absolute;
            top: 17mm;
            left: 0;
            width: 100%;
            height: 32mm; /* 54 - 17 - 5 */
            z-index: 2;
            padding: 2mm 4mm;
            box-sizing: border-box;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: stretch;
        }

        .rules-container {
            flex: 1;
            padding-right: 2mm;
        }

        .rules-title {
            font-family: var(--font-display);
            font-size: 7pt;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5mm;
            text-transform: uppercase;
        }

        .rules-list {
            margin: 0;
            padding-left: 3mm;
            font-size: 5pt;
            color: var(--text-dark);
            line-height: 1.4;
            text-align: left;
        }
        .rules-list li {
            margin-bottom: 1mm;
            padding-left: 0.5mm;
        }

        .back-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5mm;
            background: var(--primary);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4pt;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Helpers */
        .fallback-box {
            width: 100%; height: 100%; background: rgba(255,255,255,0.2); 
            border-radius: 2mm; border: 1px dashed rgba(255,255,255,0.5);
            display: flex; align-items: center; justify-content: center;
            font-size: 3pt; color: white; text-align: center;
        }

        /* Buttons */
        .action-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: opacity 0.2s;
            font-family: inherit;
        }
        .btn:hover { opacity: 0.9; }
        .btn-alt { background: var(--secondary); color: var(--text-dark); }

        @media print {
            body { background: none; padding: 0; }
            .action-buttons { display: none; }
            .page { box-shadow: none; margin: 0; width: auto; min-height: auto; gap: 4mm; }
            .id-card { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                box-shadow: none; 
                border: 0.1mm solid #cbd5e1; 
            }
            @page { size: A4; margin: 5mm; }
        }
    </style>
</head>
<body>
    <div class="action-buttons" data-html2canvas-ignore="true">
        <button class="btn btn-alt" onclick="downloadPDF()">📥 Download PDF</button>
        <button class="btn" onclick="window.print()">🖨️ Cetak Langsung</button>
    </div>

    <div class="page">
        @foreach($anggotas as $a)
        
        <!-- ======================= KARTU DEPAN ======================= -->
        <div class="id-card">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            
            <!-- HEADER -->
            <div class="card-header-bg"></div>
            <div class="header-content">
                <div class="logo-box">
                    <img src="{{ asset('images/logo-sma.png') }}" class="logo" alt="SMA" onerror="this.outerHTML='<div class=\'fallback-box\'>Logo Kiri</div>'">
                </div>
                
                <div class="header-text">
                    <div class="h-provinsi">PEMERINTAH PROVINSI GORONTALO</div>
                    <div class="h-school">PERPUSTAKAAN SMAN 1 SUWAWA</div>
                    <div class="h-address">Jl. Pasar Minggu, Kec. Suwawa, Kab. Bone Bolango</div>
                </div>
                
                <div class="logo-box">
                    <img src="{{ asset('images/logo-provinsi.png') }}" class="logo" alt="Provinsi" onerror="this.outerHTML='<div class=\'fallback-box\'>Logo Kanan</div>'">
                </div>
            </div>

            <!-- BODY -->
            <div class="card-body">
                <!-- Foto -->
                <div class="photo-section">
                    <div class="photo-frame">
                        @if($a->foto)
                            <img src="{{ asset('storage/' . $a->foto) }}" alt="Foto {{ $a->nama_lengkap }}" crossorigin="anonymous">
                        @else
                            <div class="photo-placeholder">
                                <svg style="width: 10mm; height: 10mm;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Biodata -->
                <div class="data-section">
                    <div class="card-title">KARTU ANGGOTA</div>
                    <table class="biodata-table">
                        <tr>
                            <td class="label-col">Nama</td>
                            <td class="colon-col">:</td>
                            <td class="value-col">{{ $a->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">ID Anggota</td>
                            <td class="colon-col">:</td>
                            <td class="value-col">{{ $a->nomor_identitas }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Status</td>
                            <td class="colon-col">:</td>
                            <td class="value-col">{{ $a->tipe_anggota }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- BOTTOM -->
            <div class="bottom-bar">
                <div class="barcode-container">
                    <svg id="barcode-{{ $a->id_anggota }}"
                         jsbarcode-value="{{ $a->barcode }}"
                         jsbarcode-displayvalue="true"
                         jsbarcode-fontSize="11"
                         jsbarcode-height="25"
                         jsbarcode-width="1.2"
                         jsbarcode-margin="0"
                         jsbarcode-lineColor="#0f3a5a">
                    </svg>
                </div>
            </div>
        </div>

        <!-- ======================= KARTU BELAKANG ======================= -->
        <div class="id-card">
            <!-- HEADER -->
            <div class="card-header-bg"></div>
            <div class="header-content">
                <div class="logo-box">
                    <img src="{{ asset('images/logo-sma.png') }}" class="logo" alt="SMA" onerror="this.outerHTML='<div class=\'fallback-box\'>Logo Kiri</div>'">
                </div>
                <div class="header-text">
                    <div class="h-provinsi">PEMERINTAH PROVINSI GORONTALO</div>
                    <div class="h-school">PERPUSTAKAAN SMAN 1 SUWAWA</div>
                    <div class="h-address">Jl. Pasar Minggu, Kec. Suwawa, Kab. Bone Bolango</div>
                </div>
                <div class="logo-box">
                    <img src="{{ asset('images/logo-provinsi.png') }}" class="logo" alt="Provinsi" onerror="this.outerHTML='<div class=\'fallback-box\'>Logo Kanan</div>'">
                </div>
            </div>

            <!-- BODY RULES -->
            <div class="back-body">
                <div class="rules-container">
                    <div class="rules-title">Ketentuan Umum</div>
                    <ul class="rules-list">
                        <li><b>Masa Berlaku: Selama Menjadi Anggota.</b></li>
                        <li>Kartu identitas resmi anggota perpustakaan.</li>
                        <li>Wajib dibawa saat meminjam & mengembalikan buku.</li>
                        <li>Tidak dapat dipindahtangankan ke orang lain.</li>
                        <li>Bila hilang/rusak, segera lapor ke petugas.</li>
                    </ul>
                </div>
                
                <!-- SIGNATURE (Pindah ke Belakang) -->
                <div class="back-signature">
                    <div class="sig-date">Gorontalo, {{ date('d M Y') }}</div>
                    <div class="sig-role">Kepala Perpustakaan</div>
                    <img src="{{ asset('images/ttd-kepala.png') }}" class="sig-img" alt="TTD" onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '<div style=\'height:6.5mm;\'></div>');">
                    <div class="sig-name">SYAFRIYANTI MADINA, M.PD</div>
                </div>
            </div>

            <div class="back-footer">
                SMAN 1 SUWAWA - UNGGUL, BERKARAKTER, BERPRESTASI
            </div>
        </div>

        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi barcode secara individual untuk memastikan rendering yang baik
            document.querySelectorAll('svg[id^="barcode-"]').forEach(function(svg) {
                JsBarcode(svg).init();
            });
        });

        function downloadPDF() {
            const element = document.querySelector('.page');
            const opt = {
                margin:       0,
                filename:     'kartu_anggota_siperpus.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { scale: 6, useCORS: true, allowTaint: false, letterRendering: true, logging: false },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            const dlBtn = document.querySelector('.btn-alt');
            const originalText = dlBtn.innerHTML;
            dlBtn.innerHTML = '⏳ Memproses...';
            
            html2pdf().set(opt).from(element).save().then(() => {
                dlBtn.innerHTML = originalText;
            });
        }
    </script>
</body>
</html>
