<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <title>Admin - Transaksi</title>
</head>

<body class="bg-graymain">
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 sm:hidden">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-700 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="flex items-center justify-start rtl:justify-end">
                            <a href="{{ route('admin.show') }}" class="flex ms-2 md:me-24">
                                <img src="{{ asset('img/favicon.svg') }}" class="h-8 me-3" alt="Materialin Logo" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-[60] w-64 h-screen transition-transform -translate-x-full bg-sidebar border-r  sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 pt-2 overflow-y-auto bg-sidebar">
            <a href="{{ route('admin.show') }}" class="flex items-center mb-6 px-2 pt-4">
                <img src="{{ asset('img/favicon.svg') }}" class="h-8 me-3" alt="Materialin Logo" />
                <span class="text-2xl font-semibold whitespace-nowrap text-gray-800">Materialin</span>
            </a>
            <ul class="space-y-2 font-medium">
                <li class="px-2 text-black/25 text-xs font-semibold uppercase tracking-wide">
                    Analytics
                </li>
                <x-button-sidebar route="{{ route('admin.show') }}"
                    icon='<path fill="currentColor" d="M304 240V16.6c0-9 7-16.6 16-16.6c123.7 0 224 100.3 224 224c0 9-7.6 16-16.6 16zM32 272c0-121.3 90.1-221.7 207-237.7c9.2-1.3 17 6.1 17 15.4V288l156.5 156.5c6.7 6.7 6.2 17.7-1.5 23.1c-39.2 28-87.2 44.4-139 44.4c-132.5 0-240-107.4-240-240m526.4 16c9.3 0 16.6 7.8 15.4 17c-7.7 55.9-34.6 105.6-73.9 142.3c-6 5.6-15.4 5.2-21.2-.7L320 288z" />'>
                    Dashboard
                </x-button-sidebar>
                <li class="px-2 mt-4 text-black/25 text-xs font-semibold uppercase tracking-wide">
                    Transactions
                </li>
                <li>
                    <x-button-sidebar route="{{ route('admin.pesanan') }}"
                        icon='<path fill="currentColor" d="M528.12 301.319l47.273-208A16 16 0 0 0 560 64H128l-9.4-44.319A16 16 0 0 0 103 16H16A16 16 0 0 0 0 32v16a16 16 0 0 0 16 16h66.1l61.7 290.319a64 64 0 1 0 76.2 83.681h155.8a64 64 0 1 0 76.2-83.681ZM195.1 416a32 32 0 1 1 32-32 32 32 0 0 1-32 32Zm224 0a32 32 0 1 1 32-32 32 32 0 0 1-32 32Z"/>'>
                        Pesanan
                    </x-button-sidebar>
                    <x-button-sidebar route="{{ route('admin.pembelian') }}"
                        icon='<path fill="currentColor" d="M497.9 225.9L286.1 14.1A48 48 0 0 0 252.1 0H48A48 48 0 0 0 0 48v204.1a48 48 0 0 0 14.1 33.9l211.8 211.8a48 48 0 0 0 67.9 0l204.1-204.1a48 48 0 0 0 0-67.8ZM128 160a32 32 0 1 1 32-32 32 32 0 0 1-32 32Z"/>'>
                        Pembelian
                    </x-button-sidebar>
                </li>
                <li class="px-2 mt-4 text-black/25 text-xs font-semibold uppercase tracking-wide">
                    Master
                </li>
                <x-button-sidebar route="{{ route('admin.barang') }}"
                    icon='<path fill="currentColor"
                                d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64l244.8-30.6c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1l-163.4 46.7c-13.9 4-28.8-1.9-36.2-14.3L320 64l-83.4 139c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6l54.8-91.4z" />'>Barang
                </x-button-sidebar>
                <x-button-sidebar route="{{ route('admin.pemasok') }}"
                    icon='<path fill="currentColor"
                                d="M96 128a128 128 0 1 1 256 0a128 128 0 1 1-256 0M0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3M609.3 512H471.5c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4c89 0 161.2 72.2 161.2 161.3c0 17-13.8 30.7-30.7 30.7M432 256c-31 0-59-12.6-79.3-32.9c19.7-26.6 31.3-59.5 31.3-95.1c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112" />'>Pemasok
                </x-button-sidebar>
                <x-button-sidebar route="{{ route('admin.pelanggan') }}"
                    icon='<path fill="currentColor"
                                d="M224 256a128 128 0 1 0 0-256a128 128 0 1 0 0 256m-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512h388.6c10 0 18.8-4.9 24.2-12.5l-99.2-99.2c-14.9-14.9-23.3-35.1-23.3-56.1v-33c-15.9-4.7-32.8-7.2-50.3-7.2zM384 224c-17.7 0-32 14.3-32 32v82.7c0 17 6.7 33.3 18.7 45.3l107.4 107.3c18.7 18.7 49.1 18.7 67.9 0l73.4-73.4c18.7-18.7 18.7-49.1 0-67.9L512 242.7c-12-12-28.3-18.7-45.3-18.7zm24 80a24 24 0 1 1 48 0a24 24 0 1 1-48 0" />'>Pelanggan
                </x-button-sidebar>
                {{-- <hr class="h-px my-8 bg-black/5 border-0 "> --}}
                <!-- User Card -->
                <div class="absolute bottom-4 left-0 w-full px-3 flex justify-end">
                    <div class="relative w-full">
                        <!-- Trigger Button -->
                        <button type="button"
                            class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-hvrsb focus:outline-none "
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                class="text-gray-700 h-7 w-7">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M12 20a7.97 7.97 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.97 7.97 0 0 1 12 20M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12m10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-700 ">{{ $username }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $email }}</p>
                            </div>
                        </button>

                        <!-- Dropdown Menu (only sign out) -->
                        <div id="dropdown-user"
                            class="z-50 hidden absolute right-0 mt-2 w-40 text-base list-none bg-white divide-y divide-gray-100 rounded-md shadow-lg">
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="/signout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 active:bg-gray-200"
                                        role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 mt-14 sm:mt-0">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h5 class="text-xl font-semibold">Detail Pesanan #{{ $pesanan->kode_pesanan }}</h5>
                <a href="{{ route('admin.pesanan') }}"
                    class="bg-[#2ab6a9] hover:bg-[#1e8379] text-white p-2 rounded-full text-sm font-medium flex items-center gap-2"><svg
                        class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                        <path fill="currentColor"
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H109.3l105.3-105.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </a>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <div class="font-semibold mb-1">Tanggal</div>
                        <div class="bg-gray-100 px-4 py-2">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y') }}</div>
                    </div>
                    <div>
                        <div class="font-semibold mb-1">ID Pelanggan</div>
                        <div class="bg-gray-100 px-4 py-2">{{ $pesanan->id_pelanggan ?? 'Tidak ada' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold mb-1">Nama Pelanggan</div>
                        <div class="bg-gray-100 px-4 py-2">
                            {{ $pesanan->Pelanggan->nama_pelanggan ?? 'Tidak ada' }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-gray-700 uppercase bg-gray-50">
                            <tr class="text-sm">
                                <th scope="col" class="px-6 py-3 ">No</th>
                                <th scope="col" class="px-6 py-3 ">Nama Barang</th>
                                <th scope="col" class="px-6 py-3 ">Jumlah</th>
                                <th scope="col" class="px-6 py-3 ">Harga Satuan</th>
                                <th scope="col" class="px-6 py-3 ">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pesanan->detailPesanan as $index => $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">
                                        {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
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

    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const dateFrom = getQueryParam('dateFrom');
            const dateTo = getQueryParam('dateTo');

            console.log(dateFrom);
            console.log(dateTo);

            if (dateFrom) document.getElementById('dateFrom').value = dateFrom;
            if (dateTo) document.getElementById('dateTo').value = dateTo;
        });
    </script>
</body>

</html>
