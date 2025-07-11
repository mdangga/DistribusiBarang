@php
    use App\Helpers\SortHelper;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <title>Admin - Barang</title>
</head>

<body class="bg-graymain">
    <nav class="fixed top-0 z-20 w-full bg-white border-b border-gray-200 sm:hidden">
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
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-sidebar border-r  sm:translate-x-0"
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
                                <p class="text-sm font-semibold text-gray-700">{{ $username }}</p>
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
        {{-- validasi modal --}}
        <x-toast-info :fields="['nama_barang', 'stok', 'harga']" type="error" />
        @if (session('success'))
            <x-toast-info type="success" :message="session('success')" />
        @endif

        <div class="flex items-center justify-between ml-2 mb-2">
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                <!-- Ikon & Judul -->
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 640 512"
                    class="text-gray-700">
                    <path fill="currentColor"
                        d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64l244.8-30.6c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1l-163.4 46.7c-13.9 4-28.8-1.9-36.2-14.3L320 64l-83.4 139c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6l54.8-91.4z" />
                </svg>
                Manajemen Barang
            </h1>

            <!-- Tombol kanan -->
            <div class="flex items-center mr-3">
                <x-buttons.cetak-export :cetak="route('barang.cetak', request()->query())" :export="route('barang.export', request()->query())" />

                <!-- Tambah Barang -->
                <button data-modal-target="addModalBarang" data-modal-toggle="addModalBarang" type="button"
                    class="inline-flex items-center justify-center text-white bg-[#2ab6a9] hover:bg-[#1e8379] focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 font-medium rounded-full text-sm px-3 md:px-3.5 py-3 text-center transition">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        fill="currentColor">
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256z" />
                    </svg>
                    <span class="hidden sm:inline ml-2">Tambah</span>
                </button>
            </div>
        </div>

        <form action="" method="GET"
            class="block p-6 mb-5 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="nama" class="block mb-1 text-sm font-medium text-gray-700">Filter by
                        Nama</label>
                    <input type="text" name="nama" value="{{ request('nama') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5"
                        placeholder="Cari barang..." />
                </div>

                <div>
                    <label for="kategori" class="block mb-1 text-sm font-medium text-gray-700">Filter by
                        Kategori</label>
                    <select name="kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5">
                        <option value="">ALL</option>
                        @foreach ($kategori as $ktg)
                            <option value="{{ $ktg }}" {{ request('kategori') == $ktg ? 'selected' : '' }}>
                                {{ $ktg }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="filter_stok" class="block mb-1 text-sm font-medium text-gray-700">Stok</label>
                    <select name="filter_stok"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5">
                        <option value="">Seluruh</option>
                        <option value="minimum" {{ request('filter_stok') == 'minimum' ? 'selected' : '' }}>Minimum
                            (&lt; 20)</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="bg-orange hover:bg-orangehover border border-orange focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 text-white text-sm rounded-lg font-medium focus:border-primary-600 block w-full p-2.5 transition">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="relative overflow-x-auto">
                <table id="tabelBarang" class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-50">
                        <tr class="text-sm">
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('id_barang') }}">ID
                                    {{ SortHelper::sortArrow('id_barang') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('nama_barang') }}">Nama Barang
                                    {{ SortHelper::sortArrow('nama_barang') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('kategori') }}">Kategori
                                    {{ SortHelper::sortArrow('kategori') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('stok') }}">Stok
                                    {{ SortHelper::sortArrow('stok') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('satuan') }}">Satuan
                                    {{ SortHelper::sortArrow('satuan') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                <a href="{{ SortHelper::sortUrl('harga') }}">Harga
                                    {{ SortHelper::sortArrow('harga') }}</a>
                            </th>
                            <th class="px-6 py-3">
                                aksi
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse($barang as $item)
                            <tr class="bg-white border-b border-gray-200">
                                <td class="px-6 py-4">{{ 'BRG' . str_pad($item->id_barang, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->nama_barang }}
                                </td>
                                <td class="px-6 py-4">{{ $item->kategori }}</td>
                                <td class="px-6 py-4">{{ $item->stok }}</td>
                                <td class="px-6 py-4">{{ $item->satuan }}</td>
                                <td class="px-6 py-4">{{ 'Rp ' . number_format($item->harga, 2) }}</td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
                                        <!-- Tombol Edit -->
                                        <a data-modal-target="editModal{{ $item->id_barang }}"
                                            data-modal-toggle="editModal{{ $item->id_barang }}"
                                            class="cursor-pointer flex items-center justify-center w-full sm:w-auto bg-[#ff9f1c] hover:bg-[#cc7f16] text-white text-xs font-medium px-3 py-2 rounded-lg shadow transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 512 512" class="mr-2">
                                                <path fill="currentColor"
                                                    d="m410.3 231l11.3-11.3l-33.9-33.9l-62.1-62.1l-33.9-33.9l-11.3 11.3l-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2l199.2-199.2zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9l-78.2 23l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7l-14.4 14.5l-22.6 22.6l-11.4 11.3l33.9 33.9l62.1 62.1l33.9 33.9l11.3-11.3l22.6-22.6l14.5-14.5c25-25 25-65.5 0-90.5l-39.3-39.4c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Tombol Stok -->
                                        <a data-modal-target="addModalStok{{ $item->id_barang }}"
                                            data-modal-toggle="addModalStok{{ $item->id_barang }}"
                                            class="cursor-pointer flex items-center justify-center w-full sm:w-auto bg-[#2ab6a9] hover:bg-[#1e8379] text-white text-xs font-medium px-3 py-2 rounded-lg shadow transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                viewBox="0 0 448 512" class="mr-2">
                                                <path fill="currentColor"
                                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256z" />
                                            </svg>
                                            Stok
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="bg-white text-center text-gray-500 py-6">Data barang tidak
                                    ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($barang->total() > 10)
                <div class="bg-[#cbf3f07a] py-2 px-6">
                    {{ $barang->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modals untuk menambahkan barang -->
    <x-modal id="addModalBarang" header="Tambah Barang" button="Tambah" :actionRoute="route('barang.add')" methodOverride="POST">
        <div class="grid gap-4 mb-4
            grid-cols-2">
            {{-- svg icon di header --}}
            <x-slot:iconheader>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"
                    class="text-gray-700 mr-3 overflow-visible">
                    <path fill="currentColor"
                        d="M50.7 58.5L0 160h208V32H93.7c-18.2 0-34.8 10.3-43 26.5M240 160h208L397.3 58.5c-8.2-16.2-24.8-26.5-43-26.5H240zm208 32H0v224c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64z" />
                </svg>
            </x-slot:iconheader>
            {{-- svg icon sebelah kiri btn --}}
            <x-slot:iconbtn>
                <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 512 512" class="text-gray-700 mr-3">
                    <path fill="currentColor"
                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256z" />
                </svg>
            </x-slot:iconbtn>
            <div class="col-span-2">
                <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5 ">
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                <input type="number" name="stok" id="stok"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan</label>
                <select name="satuan" id="satuan"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                    <option value="pcs">PCS</option>
                    <option value="kg">KG</option>
                    <option value="liter">Liter</option>
                </select>
            </div>

            <div class="col-span-2">
                <label for="harga" class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                <input type="number" name="harga" id="harga"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
            </div>

            <div class="col-span-2">
                <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                <select name="kategori" id="kategori"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5">
                    @foreach ($kategori as $ktg)
                        <option value="{{ $ktg }}">{{ $ktg }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-modal>

    <!-- Modals untuk setiap barang -->
    @foreach ($barang as $item)
        <x-modal id="editModal{{ $item->id_barang }}" header="Edit {{ $item->nama_barang }}" button="Update"
            :actionRoute="route('barang.update', $item->id_barang)" methodOverride="put">
            <div class="grid gap-4 mb-4
            grid-cols-2">
                {{-- svg icon di header --}}
                <x-slot:iconheader>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"
                        class="text-gray-700 mr-3">
                        <path fill="currentColor"
                            d="m410.3 231l11.3-11.3l-33.9-33.9l-62.1-62.1l-33.9-33.9l-11.3 11.3l-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2l199.2-199.2zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9l-78.2 23l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7l-14.4 14.5l-22.6 22.6l-11.4 11.3l33.9 33.9l62.1 62.1l33.9 33.9l11.3-11.3l22.6-22.6l14.5-14.5c25-25 25-65.5 0-90.5l-39.3-39.4c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6" />
                    </svg>
                </x-slot:iconheader>
                {{-- svg icon sebelah kiri btn --}}
                <x-slot:iconbtn>
                    <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h11.175q.4 0 .763.15t.637.425l2.85 2.85q.275.275.425.638t.15.762V19q0 .825-.587 1.413T19 21zm7-3q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-5-8h7q.425 0 .713-.288T15 9V7q0-.425-.288-.712T14 6H7q-.425 0-.712.288T6 7v2q0 .425.288.713T7 10" />
                </x-slot:iconbtn>
                <div class="col-span-2">
                    <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ $item->nama_barang }}"
                        readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5 ">
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ $item->stok }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label for="satuan" class="block mb-2 text-sm font-medium text-gray-900">Satuan</label>
                    <select name="satuan" id="satuan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                        <option value="pcs" {{ $item->satuan == 'pcs' ? 'selected' : '' }}>PCS</option>
                        <option value="kg" {{ $item->satuan == 'kg' ? 'selected' : '' }}>KG</option>
                        <option value="liter" {{ $item->satuan == 'liter' ? 'selected' : '' }}>Liter</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label for="harga" class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                    <input type="number" name="harga" id="harga" value="{{ $item->harga }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                </div>

                <div class="col-span-2">
                    <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5">
                        @foreach ($kategori as $ktg)
                            <option value="{{ $ktg }}" @selected($item->kategori === $ktg)>{{ $ktg }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-modal>
    @endforeach

    <!-- Modals untuk setiap barang -->
    @foreach ($barang as $item)
        <x-modal id="addModalStok{{ $item->id_barang }}" header="Tambah Stok {{ $item->nama_barang }}"
            button="Tambah" :actionRoute="route('stok.add', $item->id_barang)" methodOverride="put">
            <div class="grid gap-4 mb-4
            grid-cols-2">
                {{-- svg icon di header --}}
                <x-slot:iconheader>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"
                        class="text-gray-700 mr-3">
                        <path fill="currentColor"
                            d="m410.3 231l11.3-11.3l-33.9-33.9l-62.1-62.1l-33.9-33.9l-11.3 11.3l-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2l199.2-199.2zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9l-78.2 23l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7l-14.4 14.5l-22.6 22.6l-11.4 11.3l33.9 33.9l62.1 62.1l33.9 33.9l11.3-11.3l22.6-22.6l14.5-14.5c25-25 25-65.5 0-90.5l-39.3-39.4c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6" />
                    </svg>
                </x-slot:iconheader>
                {{-- svg icon sebelah kiri btn --}}
                <x-slot:iconbtn>
                    <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h11.175q.4 0 .763.15t.637.425l2.85 2.85q.275.275.425.638t.15.762V19q0 .825-.587 1.413T19 21zm7-3q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-5-8h7q.425 0 .713-.288T15 9V7q0-.425-.288-.712T14 6H7q-.425 0-.712.288T6 7v2q0 .425.288.713T7 10" />
                </x-slot:iconbtn>
                <div class="col-span-2">
                    <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ $item->nama_barang }}"
                        readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5 ">
                </div>

                <div class="col-span-2">
                    <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                    <input type="number" name="stok" id="stok" min="0"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                </div>
            </div>
        </x-modal>
    @endforeach


</body>

</html>
