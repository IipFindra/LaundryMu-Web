<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan LaundryMu</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4151a6; padding-bottom: 20px; }
        .header h1 { color: #2d3e90; margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        .summary-box { border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 20px; background: #f9fafb; }
        .summary-title { font-weight: bold; color: #2d3e90; font-size: 16px; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .flex-container { width: 100%; margin-bottom: 15px; }
        .flex-item { display: inline-block; width: 48%; vertical-align: top; }
        .label { font-size: 12px; color: #666; }
        .value { font-size: 20px; font-weight: bold; color: #4151a6; margin-top: 5px; }
        table { w-full; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th { background-color: #4151a6; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; }
        .text-right { text-align: right; }
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pendapatan LaundryMu</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Pendapatan</div>
        <div class="flex-container">
            <div class="flex-item">
                <div class="label">Pendapatan Hari Ini</div>
                <div class="value">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            </div>
            <div class="flex-item">
                <div class="label">Pendapatan Bulan Ini</div>
                <div class="value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="flex-container">
            <div class="flex-item">
                <div class="label">Total Keseluruhan</div>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="flex-item">
                <div class="label">Rata-rata Per Transaksi ({{ $totalTransaksi }} pesanan)</div>
                <div class="value">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <h3 style="color: #2d3e90; margin-top: 30px;">Detail Pendapatan {{ $range }} Hari Terakhir</h3>
    <table width="100%">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="50%">Tanggal</th>
                <th width="40%" class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanHarian as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['tanggal'] }}</td>
                <td class="text-right">Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} LaundryMu - Laporan dibuat secara otomatis oleh sistem.
    </div>
</body>
</html>
