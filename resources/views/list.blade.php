    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
        <title>Admin - Materialin</title>
    </head>

    <body class="bg-gray-100 font-sans text-gray-800">
        <div class="max-w-6xl mx-auto px-4 mt-10">
            <div class="flex flex-col items-center justify-center mb-10">
                <a href="#" class="flex ms-2 md:me-24 ">
                    <img src="{{ asset('img/favicon.svg') }}" class="h-16 me-3" alt="Materialin Logo" />
                    <span class="self-center text-4xl font-semibold sm:text-4xl whitespace-nowrap ">Materialin</span>
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-gray-200">
                    <h5 class="text-xl font-semibold">Daftar Pesanan</h5>
                    <a href="{{ route('pesanan.index') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <i class="bi bi-plus"></i> Buat Pesanan
                    </a>
                </div>
                <div class="p-6">
                    @if (session('success'))
                        <div
                            class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4 relative">
                            {{ session('success') }}
                            <button type="button"
                                class="absolute top-2 right-3 text-lg font-bold text-green-800 hover:text-green-900"
                                data-bs-dismiss="alert">
                                &times;
                            </button>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 text-left">Kode Pesanan</th>
                                    <th class="px-6 py-3 text-left">Tanggal</th>
                                    <th class="px-6 py-3 text-left">Pelanggan</th>
                                    <th class="px-6 py-3 text-left">Total</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pesanan as $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-2">{{ $p->kode_pesanan }}</td>
                                        <td class="px-6 py-2">{{ $p->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-2">{{ $p->Pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td class="px-6 py-2 font-medium text-black">Rp
                                            {{ number_format($p->total_harga, 2, ',', '.') }}</td>
                                        <td class="px-6 py-2">
                                            <a href="{{ route('pesanan.show', $p->kode_pesanan) }}"
                                                class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium px-3    py-2 rounded-lg shadow">
                                                <svg class="text-white mr-2 overflow-visible"
                                                    xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                    viewBox="0 0 576 512">
                                                    <path fill="currentColor"
                                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32M144 256a144 144 0 1 1 288 0a144 144 0 1 1-288 0m144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3" />
                                                </svg></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center px-6 py-4 text-gray-500">Belum ada data
                                            pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
