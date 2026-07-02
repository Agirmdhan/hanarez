<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan {{ $bulan ? $bulan : 'Keseluruhan' }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #111827; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .page { padding: 28px; }
        .toolbar { display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 16px; }
        .button { border: 0; border-radius: 6px; background: #1f2937; color: #ffffff; cursor: pointer; font-weight: 700; padding: 9px 14px; }
        .button.secondary { background: #ffffff; border: 1px solid #d1d5db; color: #374151; }
        h1 { margin: 0 0 6px; font-size: 22px; }
        .meta { color: #4b5563; margin-bottom: 18px; }
        .summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 18px; }
        .summary-item { border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; }
        .summary-label { color: #4b5563; font-size: 11px; margin-bottom: 6px; }
        .summary-value { font-size: 17px; font-weight: 700; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; font-weight: 700; }
        .text-center { text-align: center; }
        .status { border-radius: 999px; display: inline-block; font-size: 10px; font-weight: 700; padding: 3px 8px; }
        .status.lunas { background: #dcfce7; color: #166534; }
        .status.menunggu { background: #fef3c7; color: #92400e; }
        @page { margin: 14mm; size: A4 landscape; }
        @media print {
            .toolbar { display: none; }
            .page { padding: 0; }
            body { font-size: 11px; }
            a { color: inherit; text-decoration: none; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="toolbar">
            <button class="button secondary" onclick="window.close()">Tutup</button>
            <button class="button" onclick="window.print()">Cetak / Simpan PDF</button>
        </div>

        <h1>Laporan Keuangan</h1>
        <div class="meta">
            Periode: {{ $bulan ?: 'Keseluruhan' }}<br>
            Dicetak pada: {{ now()->format('d M Y H:i') }}
        </div>

        <div class="summary">
            <div class="summary-item">
                <div class="summary-label">Pemasukan Terverifikasi</div>
                <div class="summary-value">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pembayaran Lunas</div>
                <div class="summary-value">{{ $jumlahLunas }} transaksi</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Menunggu Verifikasi</div>
                <div class="summary-value">Rp {{ number_format($totalMenunggu, 0, ',', '.') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Penghuni</th>
                    <th>Kamar</th>
                    <th>Bulan</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Diverifikasi</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->user?->name ?? 'Pengguna dihapus' }}</td>
                        <td>{{ $record->user?->kamar?->nomor_kamar ?? '-' }}</td>
                        <td>{{ $record->bulan }}</td>
                        <td>Rp {{ number_format($record->nominal, 0, ',', '.') }}</td>
                        <td><span class="status {{ $record->status === 'lunas' ? 'lunas' : 'menunggu' }}">{{ $record->status === 'lunas' ? 'Lunas' : 'Menunggu' }}</span></td>
                        <td>{{ $record->verified_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td>{{ $record->bukti_pembayaran ? 'Ada' : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
