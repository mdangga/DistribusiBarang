<!DOCTYPE html>
<html>
<head>
    <title>Struk Belanja</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 15px;
            max-width: 300px;
            background: white;
            min-height: auto;
            height: auto;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .store-info {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }

        .receipt-info {
            margin-bottom: 12px;
            font-size: 11px;
        }

        .receipt-info div {
            margin-bottom: 2px;
            display: flex;
            justify-content: space-between;
        }

        .items-section {
            border-bottom: 1px dashed #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .item {
            margin-bottom: 6px;
            font-size: 11px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            color: #555;
        }

        .totals {
            margin-top: 8px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 11px;
        }

        .final-total {
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 2px dashed #333;
            font-size: 10px;
            color: #666;
        }

        .thank-you {
            font-weight: bold;
            margin-bottom: 3px;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
                max-width: none;
                width: 80mm;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="store-name">MATERIALIN</div>
        <div class="store-info">
            Jl. Kubu, Bangli No. 123<br>
            Telp: (021) 1234-5678<br>
            Email: materialin@store.com
        </div>
    </div>

    <div class="receipt-info">
        <div>
            <span>No. Pesanan:</span>
            <span>#{{ str_pad($pesanan->kode_pesanan ?? '001', 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div>
            <span>Tanggal:</span>
            <span>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</span>
        </div>
        <div>
            <span>Kasir:</span>
            <span>Admin</span>
        </div>
        <div>
            <span>Pelanggan:</span>
            <span>{{ $pesanan->pelanggan->nama_pelanggan ?? 'Umum' }}</span>
        </div>
    </div>

    <div class="items-section">
        @php
            $subtotal = 0;
        @endphp
        
        @foreach ($pesanan->detailPesanan as $detail)
            @php
                $itemTotal = $detail->jumlah * $detail->harga;
                $subtotal += $itemTotal;
            @endphp
            
            <div class="item">
                <div class="item-name">
                    {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                </div>
                <div class="item-details">
                    <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="totals">
        <div class="total-line">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-line">
            <span>Pajak (0%):</span>
            <span>Rp 0</span>
        </div>
        <div class="total-line final-total">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($pesanan->total_harga ?? $subtotal, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <div class="thank-you">TERIMA KASIH</div>
        <div>Barang yang sudah dibeli tidak dapat dikembalikan</div>
        <div>Simpan struk ini sebagai bukti pembelian</div>
    </div>
</body>
</html>