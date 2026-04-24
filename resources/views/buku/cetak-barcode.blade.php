<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Barcode - SIPERPUS</title>
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
            grid-template-columns: repeat(3, 1fr);
            gap: 5mm;
            align-content: flex-start;
        }
        /* Typical Book Label Size */
        .barcode-label {
            width: 100%;
            height: 40mm;
            border: 1px solid #ccc;
            border-radius: 2mm;
            box-sizing: border-box;
            background: #fff;
            padding: 2mm 3mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .header {
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 2mm;
            margin-bottom: 1mm;
        }
        .book-title {
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
        }
        .call-number {
            font-size: 8px;
            text-align: center;
            color: #555;
            font-family: monospace;
            font-weight: bold;
        }
        .barcode-area {
            text-align: center;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2mm;
        }
        .barcode-area svg {
            max-width: 100%;
            height: 15mm;
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
            .barcode-label {
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
        @foreach($bukus as $b)
        <div class="barcode-label">
            <div class="header">PERPUSTAKAAN SEKOLAH</div>
            <div class="book-title">{{ $b->judul_buku }}</div>
            <div class="call-number">{{ $b->klasifikasi_ddc ?? '-' }} | RAK: {{ $b->lokasi_rak ?? '-' }}</div>
            <div class="barcode-area">
                <svg class="barcode" 
                    jsbarcode-value="{{ $b->kode_buku }}" 
                    jsbarcode-displayvalue="true" 
                    jsbarcode-height="30" 
                    jsbarcode-width="1.5" 
                    jsbarcode-fontSize="11" 
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
                filename:     'label_barcode_buku_siperpus.pdf',
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
