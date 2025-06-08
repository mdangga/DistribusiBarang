<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #444;
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
    <h1>LAPORAN PESANAN</h1>

    <div class="info">
        <h4>Pelanggan: {{ $pesanan->pelanggan->nama_pelanggan }}</h4>

        <h4>
            Total Harga: {{ $pesanan->total_harga }}
        </h4>
        <h4>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}</h4>
    </div>


    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->detailPesanan as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                    </td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->harga, 2, ',', '.') }}</td>
                    <td>Rp
                        {{ number_format($detail->jumlah * $detail->harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
