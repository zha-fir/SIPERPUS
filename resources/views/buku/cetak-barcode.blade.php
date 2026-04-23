<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Barcode - SIPERPUS</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
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
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 100;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Cetak Barcode</button>

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
            // Auto print after a short delay to allow barcodes to render
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
