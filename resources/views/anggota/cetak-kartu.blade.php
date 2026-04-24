<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota - SIPERPUS</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <!-- Add html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            margin: 0 auto;
            background: white;
            box-sizing: border-box; /* Fix overflow */
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15mm 10mm;
            align-content: flex-start;
        }
        /* CR80 Standard ID Card Size: 85.6mm x 53.98mm */
        .id-card {
            width: 86mm;
            height: 54mm;
            border: 1px solid #ccc;
            border-radius: 4mm;
            box-sizing: border-box;
            background: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            page-break-inside: avoid;
        }
        .id-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 12mm;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            z-index: 1;
        }
        .card-header {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 2mm 0;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .card-title {
            font-size: 10px;
        }
        .card-body {
            padding: 2mm 3mm;
            display: flex;
            gap: 3mm;
            height: calc(100% - 12mm);
            box-sizing: border-box;
        }
        .photo-area {
            width: 18mm;
            height: 24mm;
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .photo-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .biodata-area {
            flex: 1;
            font-size: 7px;
            line-height: 1.3;
            color: #333;
        }
        .bio-row {
            display: flex;
            margin-bottom: 1.5mm;
        }
        .bio-label {
            width: 15mm;
            font-weight: bold;
        }
        .bio-colon {
            width: 2mm;
        }
        .bio-value {
            flex: 1;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
        }
        .barcode-area {
            position: absolute;
            bottom: 2mm;
            right: 3mm;
            left: 24mm; /* offset photo area */
            text-align: center;
        }
        .barcode-area svg {
            max-width: 100%;
            height: 12mm;
        }
        .card-type {
            position: absolute;
            bottom: 2mm;
            left: 3mm;
            font-size: 6px;
            font-weight: bold;
            background: #f1f5f9;
            padding: 1mm 2mm;
            border-radius: 2mm;
            text-transform: uppercase;
            color: #475569;
        }
        
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .page {
                box-shadow: none;
                margin: 0;
                width: auto;
                min-height: auto;
            }
            .id-card {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: A4;
                margin: 10mm;
            }
        }
        .action-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        .btn {
            background: #16a34a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: opacity 0.2s;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn-alt {
            background: #ea580c;
        }
        @media print {
            .action-buttons {
                display: none;
            }
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
        <div class="id-card">
            <div class="card-header">
                <div>PERPUSTAKAAN SEKOLAH</div>
                <div class="card-title">KARTU ANGGOTA SIPERPUS</div>
            </div>
            <div class="card-body">
                <div class="photo-area">
                    @if($a->foto_profil)
                        <img src="{{ Storage::url($a->foto_profil) }}" alt="Foto">
                    @else
                        <svg style="width: 12mm; height: 12mm; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    @endif
                </div>
                <div class="biodata-area">
                    <div class="bio-row">
                        <div class="bio-label">Nama</div><div class="bio-colon">:</div><div class="bio-value">{{ $a->nama_lengkap }}</div>
                    </div>
                    <div class="bio-row">
                        <div class="bio-label">ID / NIS</div><div class="bio-colon">:</div><div class="bio-value">{{ $a->nomor_identitas }}</div>
                    </div>
                    <div class="bio-row">
                        <div class="bio-label">Kelas/Dept</div><div class="bio-colon">:</div><div class="bio-value">{{ $a->kelas_atau_jabatan ?? '-' }}</div>
                    </div>
                    <div class="bio-row">
                        <div class="bio-label">Berlaku s/d</div><div class="bio-colon">:</div><div class="bio-value">SELAMA MENJADI ANGGOTA</div>
                    </div>
                </div>
            </div>
            <div class="card-type">{{ $a->tipe_anggota }}</div>
            <div class="barcode-area">
                <svg class="barcode" 
                    jsbarcode-value="{{ $a->barcode }}" 
                    jsbarcode-displayvalue="true" 
                    jsbarcode-height="25" 
                    jsbarcode-width="1.2" 
                    jsbarcode-fontSize="10" 
                    jsbarcode-margin="0">
                </svg>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            JsBarcode(".barcode").init();
        });

        function downloadPDF() {
            const element = document.querySelector('.page');
            const opt = {
                margin:       0,
                filename:     'kartu_anggota_siperpus.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { scale: 4, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            // Mengubah teks tombol agar user tahu sedang diproses
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
