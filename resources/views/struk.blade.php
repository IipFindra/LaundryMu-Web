<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .struk {
            max-width: 350px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            line-height: 1.8;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            font-size: 13px;
            font-weight: bold;
        }
        .header-line {
            text-align: center;
            margin-bottom: 3px;
        }
        .line {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .label {
            flex: 0 0 auto;
        }
        .value {
            flex: 1;
            text-align: right;
            margin-left: 10px;
        }
        .detail-section {
            margin-bottom: 10px;
            font-size: 12px;
        }
        .kategori-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        .kategori-left {
            flex: 1;
            text-align: left;
        }
        .kategori-right {
            text-align: right;
            margin-left: 10px;
        }
        .total-section {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer-text {
            text-align: center;
            font-size: 11px;
            margin: 15px 0;
            font-weight: bold;
        }
        .separator {
            text-align: center;
            font-size: 11px;
            margin: 10px 0;
            letter-spacing: 2px;
        }
        .contact-info {
            text-align: center;
            font-size: 11px;
            margin: 8px 0;
            line-height: 1.6;
        }
        .logo-section {
            text-align: center;
            margin-top: 15px;
        }
        .logo-section img {
            max-width: 60px;
            height: auto;
            margin-bottom: 5px;
        }
        .logo-text {
            font-size: 11px;
            font-weight: bold;
            color: #2d3e90;
        }
    </style>
</head>
<body>
    <div class="struk">
        <!-- HEADER -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ public_path('images/logoLaundryMu (1).png') }}" alt="LaundryMu" style="max-width: 80px; margin-bottom: 10px;">
            </div>
            <div class="header-line">Perum. Mastrip Blok U</div>
            <div class="header-line">Bu Nova</div>
        </div>

        <!-- GARIS PEMISAH 1 -->
        <div class="line"></div>

        @php
            $weight = 0;
            $unit = '';
            $pricePerUnit = $pesanan->harga;
            $priceFormula = null;

            if (preg_match('/([0-9]+(?:\.[0-9]+)?)\s*(kg|KG|Kg)/', $pesanan->berat, $matches)) {
                $weight = floatval($matches[1]);
                $unit = $matches[2];
                if ($weight > 0) {
                    $pricePerUnit = intval($pesanan->harga / $weight);
                    $priceFormula = number_format($pricePerUnit, 0, ',', '.') . ' x ' . rtrim($pesanan->berat) . ' = Rp ' . number_format($pesanan->harga, 0, ',', '.');
                }
            }
        @endphp

        <!-- DETAIL PELANGGAN -->
        {{-- <div class="detail-item">
            <span class="label">ID Pesanan</span>
            <span class="value">{{ $pesanan->id }}</span>
        </div> --}}
        <div class="detail-item">
            <span class="label">Pelanggan</span>
            <span class="value">{{ $pesanan->nama_pelanggan }}</span>
        </div>
        <div class="detail-item">
            <span class="label">Tanggal</span>
            <span class="value">{{ $pesanan->tanggal->format('d-m-Y') }}</span>
        </div>
        {{-- <div class="detail-item">
            <span class="label">Waktu Cetak</span>
            <span class="value">{{ \Carbon\Carbon::now()->format('H:i') }}</span>
        </div> --}}

        <!-- GARIS PEMISAH 2 -->
        <div class="line"></div>

        <!-- DETAIL PESANAN -->
        <div class="detail-item">
            <span class="label">{{ $pesanan->kategori }}</span>
            <span class="value">Rp {{ number_format($pricePerUnit, 0, ',', '.') }}/Kg</span>
        </div>
        <div class="detail-item">
            <span class="label">Berat</span>
            <span class="value">{{ $pesanan->berat }}</span>
        </div>

        <!-- GARIS PEMISAH 3 -->
        <div class="line"></div>

        <!-- HARGA RINCI -->
        <div class="detail-item">
            <span class="label">Harga</span>
            <span class="value">{{ $priceFormula ?? 'Rp ' . number_format($pesanan->harga, 0, ',', '.') }}</span>
        </div>

        <!-- GARIS PEMISAH 3 -->
        <div class="line"></div>

        <!-- TOTAL -->
        <div class="total-section">
            <span>TOTAL</span>
            <span>: Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</span>
        </div>

        <!-- FOOTER TEXT -->
        <div class="footer-text">TERIMA KASIH TELAH MENCUCI DI LAUNDRYMU</div>

        <!-- SEPARATOR -->
        <div class="separator">=========== LAYANAN KONSUMEN ===========</div>

        <!-- CONTACT INFO -->
        <div class="contact-info">
            <div>SMS : 0858-2351-0983</div>
            <div>WA : 0858-2351-0983</div>
            <div>EMAIL : laundrymu@gmail.com</div>
        </div>

        <!-- LOGO -->
        {{-- <div class="logo-section">
            <img src="{{ asset('images/logoLaundryMu (1).png') }}" alt="LaundryMu">
            <div class="logo-text">LaundryMu</div>
        </div> --}}
    </div>
</body>
</html>
