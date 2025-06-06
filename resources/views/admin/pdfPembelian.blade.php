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
    <h1>LAPORAN PEMBELIAN</h1>

    <div class="info">
        <h4>Total Data pembelian: {{ $pembelian->count() }}</h4>
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
                <th>Kode Pembelian</th>
                <th>Tanggal</th>
                <th>Nama Pemasok</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian as $item)
                <tr>
                    <td>{{ $item->kode_pembelian }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->pembelian->nama_pembelian ?? '-' }}</td>
                    <td>Rp {{ number_format($item->total_harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
