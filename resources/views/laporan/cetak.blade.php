<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - SIPERPUS</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .report-period {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px 8px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-space {
            height: 80px;
        }
        @media print {
            body { padding: 0; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h1>PERPUSTAKAAN SEKOLAH</h1>
        <p>Sistem Informasi Manajemen Perpustakaan (SIPERPUS)</p>
    </div>

    <div class="report-title">
        LAPORAN 
        @if($jenis == 'sirkulasi') SIRKULASI (PEMINJAMAN & PENGEMBALIAN)
        @elseif($jenis == 'kunjungan') KUNJUNGAN BUKU TAMU
        @elseif($jenis == 'koleksi') DAFTAR KOLEKSI BUKU
        @endif
    </div>
    
    @if($jenis != 'koleksi')
    <div class="report-period">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
    </div>
    @else
    <div class="report-period">
        Keadaan per tanggal: {{ \Carbon\Carbon::now()->format('d F Y') }}
    </div>
    @endif

    @if($jenis == 'sirkulasi')
        <table>
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="25%">Nama Peminjam</th>
                    <th width="35%">Judul Buku</th>
                    <th width="15%" class="text-center">Tgl Pinjam</th>
                    <th width="15%" class="text-center">Tgl Kembali</th>
                    <th width="5%" class="text-right">Denda</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDenda = 0; @endphp
                @forelse($data as $index => $row)
                @php $totalDenda += $row->denda; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row->peminjaman->anggota->nama_lengkap ?? '-' }}</td>
                    <td>
                        @foreach($row->peminjaman->detailPeminjamans ?? [] as $d)
                            {{ $d->buku->judul_buku ?? '-' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($row->peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td class="text-right">{{ $row->denda > 0 ? number_format($row->denda, 0, ',', '.') : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Tidak ada data sirkulasi pada periode ini.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Kas Denda:</th>
                    <th class="text-right">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

    @elseif($jenis == 'kunjungan')
        <table>
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="30%">Nama Pengunjung</th>
                    <th width="15%" class="text-center">Kategori</th>
                    <th width="30%">Keperluan / Instansi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_kunjungan)->format('d/m/Y') }}, {{ $row->jam_masuk }}</td>
                    <td>{{ $row->nama_pengunjung }}</td>
                    <td class="text-center">{{ ucfirst($row->tipe) }}</td>
                    <td>{{ $row->instansi ?? $row->keperluan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada data kunjungan pada periode ini.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Total Kunjungan:</th>
                    <th class="text-center">{{ count($data) }} Orang</th>
                </tr>
            </tfoot>
        </table>

    @elseif($jenis == 'koleksi')
        <table>
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="15%" class="text-center">ISBN/Barcode</th>
                    <th width="35%">Judul Buku</th>
                    <th width="20%">Penulis & Penerbit</th>
                    <th width="15%" class="text-center">Klasifikasi/Rak</th>
                    <th width="10%" class="text-center">Tersedia / Total</th>
                </tr>
            </thead>
            <tbody>
                @php $totalKoleksi = 0; $totalTersedia = 0; @endphp
                @forelse($data as $index => $row)
                @php 
                    $totalKoleksi += $row->jumlah_total; 
                    $totalTersedia += $row->jumlah_tersedia;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $row->kode_buku }}<br><small>{{ $row->isbn_issn }}</small></td>
                    <td><strong>{{ $row->judul_buku }}</strong></td>
                    <td>{{ $row->penulis }}<br><small>{{ $row->penerbit }}</small></td>
                    <td class="text-center">{{ $row->klasifikasi_ddc }}<br><small>{{ $row->lokasi_rak }}</small></td>
                    <td class="text-center">{{ $row->jumlah_tersedia }} / {{ $row->jumlah_total }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada data koleksi buku.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Eksemplar Keseluruhan:</th>
                    <th class="text-center">{{ $totalTersedia }} / {{ $totalKoleksi }}</th>
                </tr>
            </tfoot>
        </table>
    @endif

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p><strong>Kepala Perpustakaan</strong></p>
            <div class="signature-space"></div>
            <p>___________________________</p>
            <p>NIP. </p>
        </div>
    </div>

</body>
</html>
