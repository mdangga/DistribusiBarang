<!DOCTYPE html>
<html>
    
    <head>
        <title>Laporan Barang</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #ff9f1c;
            margin-bottom: 0;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .info h4 {
            margin: 4px 0;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #33333327;
            padding: 8px;
            font-size: 11px;
        }

        th {
            background-color: #ff9f1c;
            color: white;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h1>LAPORAN DATA BARANG</h1>

    <div class="info">
        <h4>Total Data Barang: {{ $barang->count() }}</h4>
        <h4>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h4>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ 'BRG' . str_pad($item->id_barang, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>Rp {{ number_format($item->harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
