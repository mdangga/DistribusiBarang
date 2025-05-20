<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - Materialin</title>
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
        .btn-tambah {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }
        .table thead {
            background-color: #f8f9fa;
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
        
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pesanan</h5>
                <a href="{{ route('pesanan.index') }}" class="btn btn-tambah text-white">
                    <i class="bi bi-plus"></i> Buat Pesanan
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Karyawan</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesanan as $p)
                                <tr>
                                    <td>{{ $p->id_pesanan }}</td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $p->id_pelanggan ?? '-' }}</td>
                                    <td>{{ $p->id_karyawan ?? '-' }}</td>
                                    <td>Rp {{ number_format($p->total_harga, 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('pesanan.show', $p->id_pesanan) }}" 
                                           class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>