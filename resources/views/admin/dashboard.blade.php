<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <title>Admin</title>
</head>

<body>
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

    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen">
        <div class="p-4 pb-2 rounded-lg sm:mt-0 mt-14">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Dashboard</h1>
                <p class="text-gray-600">Overview Business Performance</p>
            </div>

            <!-- Top Stats Row - Increased spacing -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 - Simplified design -->
                <div
                    class="bg-gradient-to-bl from-blue-50 to-blue-100 rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
                            <h3 class="font-bold text-2xl text-gray-900 mt-1">{{ $pesanan['total_pesanan'] }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="overflow-visible transition duration-75 text-blue-600" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M7.308 21.116q-.633 0-1.067-.434t-.433-1.066t.433-1.067q.434-.433 1.067-.433t1.066.433t.434 1.067t-.434 1.066t-1.066.434m9.384 0q-.632 0-1.066-.434t-.434-1.066t.434-1.067q.434-.433 1.066-.433t1.067.433q.433.434.433 1.067q0 .632-.433 1.066q-.434.434-1.067.434M5.392 4.5h13.02q.652 0 .98.532q.33.531.035 1.095l-2.858 5.208q-.217.365-.564.573t-.763.208H8.1l-1.215 2.23q-.154.231-.01.5t.433.27h10.884v1H7.308q-.875 0-1.306-.738t-.021-1.482l1.504-2.68L3.808 3.5H2v-1h2.442z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span
                            class="flex items-center {{ $pesanan['persentase'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $pesanan['persentase'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                            </svg>
                            {{ $pesanan['persentase'] }}%
                        </span>
                        <span class="text-gray-500 ml-2">dari bulan lalu</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div
                    class="bg-gradient-to-bl from-yellow-50 to-yellow-100 rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pembelian</p>
                            <h3 class="font-bold text-2xl text-gray-900 mt-1">{{ $pembelian['total_pembelian'] }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="overflow-visible transition duration-75 text-yellow-600" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M11.007 21q-.303 0-.61-.121q-.306-.121-.55-.364l-6.362-6.361q-.25-.248-.365-.548t-.114-.61t.114-.616t.365-.551l8.338-8.345q.223-.222.527-.353T12.98 3h6.387q.69 0 1.162.48T21 4.635v6.386q0 .332-.121.632t-.358.518l-8.363 8.345q-.242.242-.545.363t-.606.121m6.435-13.442q.425 0 .722-.292t.298-.708q0-.425-.295-.722t-.717-.297t-.714.295t-.294.716t.292.715t.708.293" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span
                            class="flex items-center {{ $pembelian['persentase'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $pembelian['persentase'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                            </svg>
                            {{ $pembelian['persentase'] }}%
                        </span>
                        <span class="text-gray-500 ml-2">dari bulan lalu</span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div
                    class="bg-gradient-to-bl from-green-50 to-green-100 rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                            <h3 class="font-bold text-xl text-gray-900 mt-1">Rp.
                                {{ number_format($pendapatan['total'], 2, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="overflow-visible transition duration-75 text-green-600" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 12a3 3 0 1 0 3 3a3 3 0 0 0-3-3m0 4a1 1 0 1 1 1-1a1 1 0 0 1-1 1m-.71-6.29a1 1 0 0 0 .33.21a.94.94 0 0 0 .76 0a1 1 0 0 0 .33-.21L15 7.46A1 1 0 1 0 13.54 6l-.54.59V3a1 1 0 0 0-2 0v3.59L10.46 6A1 1 0 0 0 9 7.46ZM19 15a1 1 0 1 0-1 1a1 1 0 0 0 1-1m1-7h-3a1 1 0 0 0 0 2h3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h3a1 1 0 0 0 0-2H4a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3M5 15a1 1 0 1 0 1-1a1 1 0 0 0-1 1" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span
                            class="flex items-center {{ $pendapatan['persentase'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $pendapatan['persentase'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                            </svg>
                            {{ $pendapatan['persentase'] }}%
                        </span>
                        <span class="text-gray-500 ml-2">dari bulan lalu</span>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div
                    class="bg-gradient-to-bl from-red-50 to-red-100 rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pengeluaran</p>
                            <h3 class="font-bold text-xl text-gray-900 mt-1">Rp.
                                {{ number_format($pengeluaran['total'], 2, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 red-lg bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="overflow-visible transition duration-75 text-yellow-600" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m10.46 6l.54-.59V9a1 1 0 0 0 2 0V5.41l.54.55A1 1 0 0 0 15 6a1 1 0 0 0 0-1.42l-2.29-2.29a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21L9 4.54A1 1 0 0 0 10.46 6M12 12a3 3 0 1 0 3 3a3 3 0 0 0-3-3m0 4a1 1 0 1 1 1-1a1 1 0 0 1-1 1m-7-1a1 1 0 1 0 1-1a1 1 0 0 0-1 1m14 0a1 1 0 1 0-1 1a1 1 0 0 0 1-1m1-7h-4a1 1 0 0 0 0 2h4a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h4a1 1 0 0 0 0-2H4a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span
                            class="flex items-center {{ $pengeluaran['persentase'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $pengeluaran['persentase'] >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                            </svg>
                            {{ $pengeluaran['persentase'] }}%
                        </span>
                        <span class="text-gray-500 ml-2">dari bulan lalu</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
                <!-- Business Performance Chart - Improved Layout -->
                <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Business Performance</h3>
                            <p class="text-gray-500 text-sm mt-1">Monitor your business financial performance</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $business_status['status'] === 'profitable' ? 'bg-green-100 text-green-800' : ($business_status['status'] === 'recovery' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($business_status['status']) }}
                            </span>
                        </div>
                    </div>

                    @php
                        $labels = ['Bulan Ini vs Bulan Lalu', '3 Bulan Terakhir', 'Tahun Ini'];
                        $defaultIndex = 0; // default: Bulan Ini
                    @endphp

                    <!-- Compact Profit Display -->
                    <div x-data="{
                        selectedIndex: 0,
                        profits: {{ Js::from($profit['profit']) }},
                        percentages: {{ Js::from($profit['persentase']) }},
                        labels: {{ Js::from($labels) }}
                    }" class="mb-6">

                        <div class="bg-gradient-to-bl from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-100">
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                                <!-- Left: Profit Info -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                class="overflow-visible transition duration-75 text-blue-600"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M2.385 12.958q-.171-.11-.205-.305t.07-.372l2.839-4.554q.434-.702 1.245-.755q.81-.053 1.345.568l.898 1.04q.212.25.529.222q.317-.029.471-.298l2.048-3.331q.46-.758 1.345-.78q.886-.022 1.37.73l.949 1.458q.192.269.528.269t.51-.288l2.57-4.104q.109-.183.325-.222t.394.1q.151.11.185.286t-.07.353l-2.57 4.104q-.459.752-1.345.752t-1.37-.727l-.929-1.42q-.192-.288-.529-.278q-.336.01-.51.298l-2.047 3.311q-.429.702-1.25.768q-.82.065-1.354-.556l-.904-1.065q-.212-.25-.52-.222q-.307.03-.46.298l-2.84 4.58q-.109.182-.325.231t-.393-.091M14.115 18q1.204 0 2.035-.83t.83-2.036q0-1.203-.83-2.034t-2.034-.83t-2.035.83t-.831 2.035t.83 2.034t2.036.831m0 1q-1.606 0-2.736-1.13t-1.13-2.735t1.13-2.736t2.735-1.13t2.736 1.13t1.13 2.736q0 .669-.214 1.272q-.213.603-.601 1.09l2.461 2.48q.14.14.14.335t-.14.334t-.344.14t-.344-.14l-2.481-2.461q-.487.388-1.08.602T14.116 19" />
                                            </svg>
                                            <span class="text-sm font-medium text-blue-700">Peningkatan </span>
                                        </div>
                                        <!-- Dropdown integrated -->
                                        <select x-model.number="selectedIndex"
                                            class="text-sm px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                            @foreach ($labels as $i => $label)
                                                <option value="{{ $i }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex items-baseline gap-4">
                                        <h4 class="text-2xl lg:text-3xl font-bold"
                                            :class="(profits[selectedIndex] >= 0) ? 'text-green-600' : 'text-red-600'">
                                            <span
                                                x-text="new Intl.NumberFormat('id-ID', { 
                            style: 'currency', 
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(profits[selectedIndex])"></span>
                                        </h4>

                                        <!-- Percentage inline -->
                                        <div class="flex items-center px-2 py-1 rounded-md text-sm font-semibold"
                                            :class="(percentages[selectedIndex] >= 0) ? 'bg-green-100 text-green-700' :
                                            'bg-red-100 text-red-700'">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    :d="(percentages[selectedIndex] >= 0) ?
                                                    'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6'" />
                                            </svg>
                                            <span
                                                x-text="`${percentages[selectedIndex] >= 0 ? '+' : ''}${percentages[selectedIndex]}%`"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simplified Performance Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-8">
                        <!-- YTD Performance -->
                        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-red-700">YTD Performance</span>
                                <div
                                    class="w-8 h-8 rounded-lg {{ $ytd_performance['is_profitable_ytd'] ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $ytd_performance['is_profitable_ytd'] ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="text-2xl font-bold {{ $ytd_performance['is_profitable_ytd'] ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($ytd_performance['net_profit_ytd'], 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">{{ $ytd_performance['periode'] }}</p>
                        </div>

                        <!-- 12-Month Performance -->
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-purple-700">12-Month</span>
                                <div
                                    class="w-8 h-8 rounded-lg {{ $full_year_performance['is_profitable_full_year'] ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $full_year_performance['is_profitable_full_year']? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="text-2xl font-bold {{ $full_year_performance['is_profitable_full_year'] ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($full_year_performance['net_profit_full_year'], 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">{{ $full_year_performance['periode'] }}</p>
                        </div>

                        <!-- Profitable Months -->
                        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-emerald-700">Profitable Months</span>
                                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <p class="text-2xl font-bold text-emerald-600">
                                    {{ $business_status['consecutive_profitable_months'] }}</p>
                                <span class="text-lg font-medium text-emerald-500">months</span>
                            </div>
                            <div class="mt-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-emerald-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300"
                                            style="width: {{ min(($business_status['consecutive_profitable_months'] / 12) * 100, 100) }}%">
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs text-gray-600">{{ min($business_status['consecutive_profitable_months'], 12) }}/12</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <canvas id="profitChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Kategori Terlaris - Simplified -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Kategori Terlaris</h2>
                            <p class="text-gray-500 text-sm mt-1">Top selling categories</p>
                        </div>
                    </div>

                    <!-- Period Buttons - Simplified -->
                    <div class="flex gap-2 mb-6">
                        <button
                            class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                            onclick="changePeriod('month')" id="btn-month" data-period="month">
                            1M
                        </button>
                        <button
                            class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                            onclick="changePeriod('previous')" id="btn-before" data-period="previous">
                            3M
                        </button>
                        <button
                            class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                            onclick="changePeriod('year')" id="btn-year" data-period="year">
                            1Y
                        </button>
                    </div>

                    <!-- Chart -->
                    <div class="h-[280px] mb-6">
                        <canvas id="kategoriChart"></canvas>
                    </div>

                    <!-- Legend -->
                    <div class="mt-4 flex flex-wrap gap-4 justify-center" id="customLegend"></div>

                    <!-- Stats - Simplified -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-xl font-bold text-blue-600" id="topCategory"></div>
                            <div class="text-sm text-gray-600">Top Kategori</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-xl font-bold text-green-600" id="totalSales"></div>
                            <div class="text-sm text-gray-600">Total Sales</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row - Improved spacing -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Pesanan Terbaru</h2>
                            <p class="text-gray-500 text-sm mt-1">Latest orders from customers</p>
                        </div>
                        <a href="{{ route('admin.pesanan') }}"
                            class="text-blue-600 text-sm font-medium hover:text-blue-700">
                            View All →
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 rounded-lg">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-l-lg">
                                        Kode Pesanan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pelanggan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider rounded-r-lg">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($daftar_pesanan as $p)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $p->kode_pesanan }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $p->Pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center px-6 py-8 text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                <p>Belum ada data pesanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Activity Timeline - Simplified -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
                        <p class="text-gray-500 text-sm mt-1">Latest transactions</p>
                    </div>
                    <div class="space-y-4">
                        @foreach ($transaksi as $p)
                            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center {{ $p->jenis == 'pesanan' ? 'bg-green-100' : 'bg-red-100' }}">
                                    @if ($p->jenis == 'pesanan')
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 capitalize">{{ $p->jenis }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $p->kode }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profit Chart
            const profitCtx = document.getElementById('profitChart').getContext('2d');

            // Enhanced gradient untuk Pesanan
            const revenueGradient = profitCtx.createLinearGradient(0, 0, 0, 400);
            revenueGradient.addColorStop(0, 'rgba(34, 197, 94, 0.4)');
            revenueGradient.addColorStop(0.3, 'rgba(34, 197, 94, 0.25)');
            revenueGradient.addColorStop(0.7, 'rgba(34, 197, 94, 0.1)');
            revenueGradient.addColorStop(1, 'rgba(34, 197, 94, 0.02)');

            // Enhanced gradient untuk Pembelian
            const expenseGradient = profitCtx.createLinearGradient(0, 0, 0, 400);
            expenseGradient.addColorStop(0, 'rgba(239, 68, 68, 0.4)');
            expenseGradient.addColorStop(0.3, 'rgba(239, 68, 68, 0.25)');
            expenseGradient.addColorStop(0.7, 'rgba(239, 68, 68, 0.1)');
            expenseGradient.addColorStop(1, 'rgba(239, 68, 68, 0.02)');

            // Gradient untuk glow effect
            const glowGradient = profitCtx.createRadialGradient(0, 0, 0, 0, 0, 20);
            glowGradient.addColorStop(0, 'rgba(34, 197, 94, 0.8)');
            glowGradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

            new Chart(profitCtx, {
                type: 'line',
                data: {
                    labels: @json($grafik_line['labels']),
                    datasets: [{
                            label: 'Pendapatan',
                            data: @json($grafik_line['pendapatan']),
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: revenueGradient,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.5,
                            pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 4,
                            pointRadius: 8,
                            pointHoverRadius: 12,
                            pointHoverBackgroundColor: 'rgba(34, 197, 94, 1)',
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 6,
                            // Enhanced point styling
                            pointStyle: 'circle',
                            pointShadowOffsetX: 3,
                            pointShadowOffsetY: 3,
                            pointShadowBlur: 6,
                            pointShadowColor: 'rgba(34, 197, 94, 0.3)'
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($grafik_line['pengeluaran']),
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: expenseGradient,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.5,
                            pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 4,
                            pointRadius: 8,
                            pointHoverRadius: 12,
                            pointHoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 6,
                            // Enhanced point styling
                            pointStyle: 'circle',
                            pointShadowOffsetX: 3,
                            pointShadowOffsetY: 3,
                            pointShadowBlur: 6,
                            pointShadowColor: 'rgba(239, 68, 68, 0.3)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    // Enhanced animations
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        delay: (context) => {
                            return context.type === 'data' && context.mode === 'default' ?
                                context.dataIndex * 200 :
                                0;
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0.5,
                            loop: false
                        },
                        radius: {
                            duration: 1000,
                            easing: 'linear',
                            from: 12,
                            to: 8,
                            loop: false
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'rectRounded',
                                padding: 25,
                                font: {
                                    size: 16,
                                    weight: '700',
                                    family: 'system-ui, -apple-system, sans-serif'
                                },
                                color: '#1f2937',
                                boxWidth: 15,
                                boxHeight: 15,
                                generateLabels: function(chart) {
                                    const original = Chart.defaults.plugins.legend.labels
                                        .generateLabels;
                                    const labels = original.call(this, chart);

                                    labels.forEach((label, index) => {
                                        // Add glow effect
                                        label.borderRadius = 8;
                                        label.borderWidth = 3;
                                    });

                                    return labels;
                                }
                            },
                            onHover: (event, legendItem, legend) => {
                                legend.chart.canvas.style.cursor = 'pointer';
                            },
                            onLeave: (event, legendItem, legend) => {
                                legend.chart.canvas.style.cursor = 'default';
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.98)',
                            titleColor: '#ffffff',
                            bodyColor: '#e5e7eb',
                            cornerRadius: 16,
                            padding: 16,
                            displayColors: true,
                            borderColor: 'rgba(75, 85, 99, 0.3)',
                            borderWidth: 2,
                            titleFont: {
                                size: 16,
                                weight: '700'
                            },
                            bodyFont: {
                                size: 14,
                                weight: '600'
                            },
                            // Enhanced box styling
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 12,
                            boxHeight: 12,
                            boxPadding: 8,
                            caretSize: 10,
                            caretPadding: 12,
                            // Custom callbacks
                            callbacks: {
                                title: function(context) {
                                    return `${context[0].label}`;
                                },
                                label: function(context) {
                                    const label = context.dataset.label;
                                    const value = context.parsed.y;

                                    return `${label}: ${value}`;
                                },
                                afterBody: function(context) {
                                    // Calculate difference between datasets if both exist
                                    if (context.length === 2) {
                                        const pesanan = context.find(c => c.dataset.label.includes(
                                            'Pendapatan'))?.parsed.y || 0;
                                        const pembelian = context.find(c => c.dataset.label.includes(
                                            'Pengeluaran'))?.parsed.y || 0;
                                    }
                                    return '';
                                }
                            },
                            // Animation for tooltip
                            animation: {
                                duration: 300,
                                easing: 'easeOutQuart'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grace: '10%',
                            grid: {
                                color: function(context) {
                                    // Gradient grid lines
                                    if (context.tick.value === 0) {
                                        return 'rgba(17, 24, 39, 0.2)';
                                    }
                                    return 'rgba(17, 24, 39, 0.05)';
                                },
                                drawBorder: false,
                                lineWidth: function(context) {
                                    return context.tick.value === 0 ? 2 : 1;
                                }
                            },
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: '600',
                                    family: 'system-ui, -apple-system, sans-serif'
                                },
                                color: '#6b7280',
                                padding: 15,
                                callback: function(value) {
                                    // Format with K/M notation for large numbers
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(0) + 'K';
                                    }
                                    return value.toLocaleString('id-ID');
                                }
                            },
                            // Enhanced axis styling
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: '700',
                                    family: 'system-ui, -apple-system, sans-serif'
                                },
                                color: '#374151',
                                padding: 15,
                                maxRotation: 0,
                                minRotation: 0
                            },
                            border: {
                                color: 'rgba(17, 24, 39, 0.1)',
                                width: 2
                            }
                        }
                    },
                    // Enhanced hover effects
                    onHover: (event, elements, chart) => {
                        chart.canvas.style.cursor = elements.length > 0 ? 'pointer' : 'default';

                        // Add subtle zoom effect on hover
                        if (elements.length > 0) {
                            chart.canvas.style.transform = 'scale(1.01)';
                            chart.canvas.style.transition = 'transform 0.2s ease';
                        } else {
                            chart.canvas.style.transform = 'scale(1)';
                        }
                    },
                    // Click interaction
                    onClick: (event, elements, chart) => {
                        if (elements.length > 0) {
                            const element = elements[0];
                            const datasetIndex = element.datasetIndex;
                            const dataIndex = element.index;
                            const value = chart.data.datasets[datasetIndex].data[dataIndex];
                            const label = chart.data.labels[dataIndex];

                            // Add click feedback animation
                            chart.update('none');
                            setTimeout(() => {
                                chart.update();
                            }, 200);

                            console.log(
                                `Clicked: ${chart.data.datasets[datasetIndex].label} - ${label}: ${value}`
                            );
                        }
                    }
                }
            });
        });


        const grafikPieData = @json($grafik_pie);
        const colors = ['#4285f4', '#34a853', '#fbbc04', '#ea4335', '#9c27b0', '#ff9800', '#795548', '#607d8b'];
        const borderColors = colors.map(color => color.replace(/[^,]+(?=\))/, '1'));

        function getChartData(sourceData) {
            if (!sourceData || !sourceData.labels || !sourceData.data) {
                return {
                    labels: [],
                    data: [],
                    colors: []
                };
            }

            // Filter data yang valid
            const validData = sourceData.labels
                .map((label, index) => ({
                    label: label || 'Unknown',
                    value: parseFloat(sourceData.data[index]) || 0
                }))
                .filter(item => item.value > 0);

            return {
                labels: validData.map(item => item.label),
                data: validData.map(item => item.value),
                colors: colors.slice(0, validData.length)
            };
        }

        const dataMonth = getChartData(grafikPieData.bulan_sekarang);
        const dataPreviousMonths = getChartData(grafikPieData.bulan_lalu);
        const dataYear = getChartData(grafikPieData.Satu_tahun);

        const periods = [{
                key: 'month',
                label: 'Bulan Sekarang',
                data: dataMonth
            },
            {
                key: 'previous',
                label: 'Bulan Sebelumnya',
                data: dataPreviousMonths
            },
            {
                key: 'year',
                label: 'Satu Tahun',
                data: dataYear
            }
        ];

        let currentChart = null;
        let currentPeriod = 'month';

        function initChart() {
            const ctx = document.getElementById('kategoriChart');
            if (!ctx) {
                console.error('Canvas element not found');
                return;
            }

            // Hancurkan chart sebelumnya jika ada
            if (currentChart) {
                currentChart.destroy();
            }

            const currentData = periods.find(p => p.key === currentPeriod)?.data || {
                labels: [],
                data: [],
                colors: []
            };
            // Jika tidak ada data, tampilkan pesan
            if (currentData.labels.length === 0) {
                ctx.style.display = 'none';
                document.getElementById('customLegend').innerHTML =
                    '<div class="text-center text-gray-500 py-4">Tidak ada data untuk ditampilkan</div>';
                updateStats(currentData);
                return;
            }

            ctx.style.display = 'block';

            currentChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: currentData.labels,
                    datasets: [{
                        data: currentData.data,
                        backgroundColor: currentData.colors,
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b,
                                        0);
                                    const percentage = total > 0 ? ((value / total) * 100)
                                        .toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%',
                    animation: {
                        animateRotate: true,
                        duration: 1000
                    }
                }
            });

            updateLegend(currentData);
            updateStats(currentData);
        }

        function updateLegend(data) {
            const legendContainer = document.getElementById('customLegend');
            if (!legendContainer) return;

            if (data.labels.length === 0) {
                legendContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Tidak ada data</div>';
                return;
            }

            legendContainer.innerHTML = data.labels.map((label, index) => `
        <div class="flex items-center gap-2 text-sm mb-1">
            <div class="w-4 h-4 rounded-full" style="background-color: ${data.colors[index]}"></div>
            <span class="text-gray-700">${label}: ${data.data[index]}</span>
        </div>
    `).join('');
        }

        function updateStats(data) {
            const totalCategories = data.labels.length;
            const totalValue = data.data.reduce((sum, value) => sum + value, 0);
            const topCategory = totalCategories > 0 ?
                data.labels[data.data.indexOf(Math.max(...data.data))] : 'Tidak ada data';

            document.getElementById('totalSales').textContent = totalValue.toLocaleString('id-ID');
            document.getElementById('topCategory').textContent = topCategory;
        }

        function changePeriod(period) {
            currentPeriod = period;

            // Update tombol aktif
            document.querySelectorAll('[data-period]').forEach(btn => {
                const isActive = btn.dataset.period === period;

                btn.disabled = false;
                btn.classList.toggle('bg-blue-500', isActive);
                btn.classList.toggle('text-white', isActive);
                btn.classList.toggle('bg-gray-100', !isActive);
                btn.classList.toggle('text-gray-700', !isActive);
            });

            initChart();
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded!');
                document.getElementById('kategoriChart').innerHTML =
                    '<div class="text-red-500">Error: Chart.js library tidak dimuat</div>';
                return;
            }

            initChart();

            // Event listeners untuk tombol periode
            document.querySelectorAll('[data-period]').forEach(btn => {
                btn.addEventListener('click', () => changePeriod(btn.dataset.period));
            });
        });
    </script>
</body>

</html>
