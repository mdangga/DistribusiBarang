<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pesanan</title>
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
        <h4>Total Data pesanan: {{ $pesanan->count() }}</h4>
        <h4>
            Filter Tanggal:
            @if ($dateFrom && $dateTo)
                {{ \Carbon\Carbon::parse($dateFrom)->format('d F Y') }} -
                {{ \Carbon\Carbon::parse($dateTo)->format('d F Y') }}
            @else
                Semua
            @endif
        </h4>
        <h4>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}</h4>
    </div>


    <table>
        <thead>
            <tr>
                <th>Kode Pesanan</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $item)
                <tr>
                    <td>{{ $item->kode_pesanan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                    <td>Rp {{ number_format($item->total_harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
