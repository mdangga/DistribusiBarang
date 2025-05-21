<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Detail Pesanan - Materialin</title>
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <div class="max-w-6xl mx-auto px-4 mt-10">
        <div class="text-center mb-10">
            <div class="flex justify-center items-center text-3xl font-bold text-orange-600">
                <i class="bi bi-grid-3x3-gap-fill mr-2"></i> Materialin
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h5 class="text-xl font-semibold">Detail Pesanan #{{ $pesanan->id_pesanan }}</h5>
                <a href="{{ route('pesanan.list') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <div class="font-semibold mb-1">Tanggal</div>
                        <div class="bg-gray-100 px-4 py-2 rounded">{{ $pesanan->created_at->format('d/m/Y') }}</div>
                    </div>
                    {{-- <div>
                        <div class="font-semibold mb-1">ID Karyawan</div>
                        <div class="bg-gray-100 px-4 py-2 rounded">{{ $pesanan->id_karyawan ?? 'Tidak ada' }}</div>
                    </div> --}}
                    <div>
                        <div class="font-semibold mb-1">ID Pelanggan</div>
                        <div class="bg-gray-100 px-4 py-2 rounded">{{ $pesanan->id_pelanggan ?? 'Tidak ada' }}</div>
                    </div>

                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-s-lg">No</th>
                                <th scope="col" class="px-6 py-3 ">Nama Barang</th>
                                <th scope="col" class="px-6 py-3 ">Jumlah</th>
                                <th scope="col" class="px-6 py-3 ">Harga Satuan</th>
                                <th scope="col" class="px-6 py-3 rounded-e-lg">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pesanan->detailPesanan as $index => $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                    </td>
                                    <td class="px-4 py-2">{{ $detail->jumlah }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->harga, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp
                                        {{ number_format($detail->jumlah * $detail->harga, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-4 py-4 text-gray-500">Tidak ada detail
                                        pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="1" class="text-left px-4 py-2">Total:</th>
                                <th colspan="5" class="px-4 py-2 text-right">Rp
                                    <span
                                        class="text-2xl ">{{ number_format($pesanan->total_harga, 2, ',', '.') }}</span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
