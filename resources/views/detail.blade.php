<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Materialin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: none;
        }
        .logo {
            color: #e67e22;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .logo-icon {
            color: #e67e22;
            font-size: 24px;
            margin-right: 5px;
        }
        .table thead {
            background-color: #fff3e0;
        }
        .btn-kembali {
            background-color: #3498db;
            border-color: #3498db;
        }
        .total-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }
        .info-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-value {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <div class="logo">
                    <i class="bi bi-grid-3x3-gap-fill logo-icon"></i> Materialin
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Pesanan #{{ $pesanan->id_pesanan }}</h5>
                <a href="{{ route('pesanan.list') }}" class="btn btn-kembali text-white">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="info-label">Tanggal</div>
                        <div class="info-value">{{ $pesanan->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-label">ID Karyawan</div>
                        <div class="info-value">{{ $pesanan->id_karyawan ?? 'Tidak ada' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-label">ID Pelanggan</div>
                        <div class="info-value">{{ $pesanan->id_pelanggan ?? 'Tidak ada' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-label">Total Pesanan</div>
                        <div class="total-box">
                            <span>Rp</span> <span>{{ number_format($pesanan->total_harga, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Nama Barang</th>
                                <th width="15%">Jumlah</th>
                                <th width="20%">Harga Satuan</th>
                                <th width="20%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesanan->detailPesanan as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp {{ number_format($detail->harga, 2, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->jumlah * $detail->harga, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada detail pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th>Rp {{ number_format($pesanan->total_harga, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>