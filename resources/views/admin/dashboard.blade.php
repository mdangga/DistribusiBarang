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

    <div class="p-2 sm:ml-64 bg-gray-100">
        <div class="p-2  rounded-lg sm:mt-0 mt-14">
            <!-- Top Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pesanan</p>
                        <h3 class="font-bold text-2xl">{{ $pesanan['total_pesanan'] }}</h3>
                        <p x-data="{ persentase: {{ $pesanan['persentase'] }} }" :class="persentase >= 0 ? 'text-green-500' : 'text-red-500'"
                            class="text-xs flex items-center">
                            <svg class="w-3 h-3 me-1 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="persentase >= 0 ?
                                        'M5 13V1m0 0L1 5m4-4 4 4' :
                                        'M5 1v12m0 0L1 9m4 4 4-4'" />
                            </svg>
                            <span x-text="persentase + '% from last month'"></span>
                        </p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pembelian</p>
                        <h3 class="font-bold text-2xl">{{ $pembelian['total_pembelian'] }}</h3>
                        <p x-data="{ persentase: {{ $pembelian['persentase'] }} }" :class="persentase <= 0 ? 'text-green-500' : 'text-red-500'"
                            class="text-xs flex items-center">
                            <svg class="w-3 h-3 me-1 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="persentase >= 0 ?
                                        'M5 13V1m0 0L1 5m4-4 4 4' :
                                        'M5 1v12m0 0L1 9m4 4 4-4'" />
                            </svg>
                            <span x-text="persentase + '% from last month'"></span>
                        </p>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pendapatan</p>
                        <h3 class="font-bold text-xl">Rp. {{ number_format($pendapatan['total'], 2, ',', '.') }}</h3>
                        <p x-data="{ persentase: {{ $pendapatan['persentase'] }} }" :class="persentase >= 0 ? 'text-green-500' : 'text-red-500'"
                            class="text-xs flex items-center">
                            <svg class="w-3 h-3 me-1 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="persentase >= 0 ?
                                        'M5 13V1m0 0L1 5m4-4 4 4' :
                                        'M5 1v12m0 0L1 9m4 4 4-4'" />
                            </svg>
                            <span x-text="persentase + '% from last month'"></span>
                        </p>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-lg shadow p-6 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pengeluaran</p>
                        <h3 class="font-bold text-xl">Rp. {{ number_format($pengeluaran['total'], 2, ',', '.') }}</h3>
                        <p x-data="{ persentase: {{ $pengeluaran['persentase'] }} }" :class="persentase <= 0 ? 'text-green-500' : 'text-red-500'"
                            class="text-xs flex items-center">
                            <svg class="w-3 h-3 me-1 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="persentase >= 0 ?
                                        'M5 13V1m0 0L1 5m4-4 4 4' :
                                        'M5 1v12m0 0L1 9m4 4 4-4'" />
                            </svg>
                            <span x-text="persentase + '% from last month'"></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <!-- Business Performance Chart -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-6">
    <h3 class="text-base font-semibold text-gray-900">Business Performance</h3>
    <div class="flex items-center space-x-2">
        <span 
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
            :class="{
                'bg-green-100 text-green-800': business_status.status === 'profitable',
                'bg-blue-100 text-blue-800': business_status.status === 'stable' || business_status.status === 'improving',
                'bg-yellow-100 text-yellow-800': business_status.status === 'recovery',
                'bg-red-100 text-red-800': business_status.status === 'declining' || business_status.status === 'loss'
            }"
        >
            {{ ucfirst($business_status['status']) }}
        </span>
    </div>
</div>

<!-- Performance Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
    <!-- YTD Performance Card -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-blue-600">YTD Performance</p>
                <p class="text-xl font-bold leading-tight {{ $ytd_performance['is_profitable_ytd'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($ytd_performance['net_profit_ytd'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500">{{ $ytd_performance['periode'] }}</p>
            </div>
            <div class="p-3 rounded-full {{ $ytd_performance['is_profitable_ytd'] ? 'bg-green-100' : 'bg-red-100' }}">
                @if ($ytd_performance['is_profitable_ytd'])
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                @else
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <!-- 12-Month Performance Card -->
    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-purple-600">12-Month Performance</p>
                <p class="text-xl font-bold leading-tight {{ $full_year_performance['is_profitable_full_year'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($full_year_performance['net_profit_full_year'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500">{{ $full_year_performance['periode'] }}</p>
            </div>
            <div class="p-3 rounded-full {{ $full_year_performance['is_profitable_full_year'] ? 'bg-green-100' : 'bg-red-100' }}">
                @if ($full_year_performance['is_profitable_full_year'])
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                @else
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <!-- Business Health Card -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-green-600">Consecutive Profitable Months</p>
                <p class="text-xl font-bold leading-tight text-green-600">
                    {{ $business_status['consecutive_profitable_months'] }}
                </p>
                <p class="text-xs text-gray-500">
                    @if ($business_status['consistent_profit'])
                        Consistently Profitable
                    @else
                        Building Consistency
                    @endif
                </p>
            </div>
            <div class="p-3 rounded-full bg-green-100">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

                    <!-- Performance Chart -->
                    <div class="mb-6">
                        <canvas id="profitChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Status Message -->
                    <div class="flex items-center p-4 rounded-lg"
                        :class="{
                            'bg-green-50 border border-green-200': business_status.status === 'profitable',
                            'bg-blue-50 border border-blue-200': business_status.status === 'stable' ||
                                business_status
                                .status === 'improving',
                            'bg-yellow-50 border border-yellow-200': business_status.status === 'recovery',
                            'bg-red-50 border border-red-200': business_status.status === 'declining' ||
                                business_status
                                .status === 'loss'
                        }">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                @if ($business_status['status'] === 'profitable')
                                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @elseif($business_status['status'] === 'recovery')
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium"
                                    :class="{
                                        'text-green-800': business_status.status === 'profitable',
                                        'text-blue-800': business_status.status === 'stable' || business_status
                                            .status === 'improving',
                                        'text-yellow-800': business_status.status === 'recovery',
                                        'text-red-800': business_status.status === 'declining' || business_status
                                            .status === 'loss'
                                    }">
                                    {{ $business_status['message'] }}
                                </p>
                                @if ($business_status['needs_attention'])
                                    <p class="mt-1 text-sm text-red-600">
                                        Immediate attention required - consider cost reduction or revenue improvement
                                        strategies.
                                    </p>
                                @elseif($business_status['recovery_indicator'])
                                    <p class="mt-1 text-sm text-yellow-600">
                                        Great! Your business is showing signs of recovery. Keep monitoring trends.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Kategori Terlaris -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold mb-4">Kategori Terlaris</h2>
                    <div class="h-[450px] ">
                        <canvas id="kategoriChart" class=""></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Pesanan Terbaru</h2>
                        <a type="button" href="{{ route('admin.pesanan') }}"
                            class="text-blue-600 text-sm font-medium">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode Pesanan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($daftar_pesanan as $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3">{{ $p->kode_pesanan }}</td>
                                        {{-- <td class="px-6 py-2">{{ $p->tanggal }}</td> --}}
                                        <td class="px-6 py-3">{{ $p->Pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td class="px-6 py-3 font-medium text-black">Rp.
                                            {{ number_format($p->total_harga, 2, ',', '.') }}</td>
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

                <!-- Activity Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
                    <div class="space-y-2">
                        @foreach ($transaksi as $p)
                            <div class="grid grid-cols-[auto_1fr] gap-3 items-center">
                                <div
                                    class="h-8 w-8 rounded-full flex items-center justify-center text-blue-600 {{ $p->jenis == 'pesanan' ? 'bg-green-300' : 'bg-red-300' }}">
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $p->jenis }}</p>
                                    <p class="text-sm text-gray-500">{{ $p->kode }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->diffForHumans() }}</p>
                                </div>
                            </div>
                            <hr>
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

            // Kategori Chart
            const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');

            // Ambil data dari PHP
            const grafikPieData = @json($grafik_pie);

            // Warna dasar
            const colors = [
                'rgba(59, 130, 246, 0.8)', // Blue
                'rgba(16, 185, 129, 0.8)', // Green
                'rgba(245, 158, 11, 0.8)', // Amber
                'rgba(139, 92, 246, 0.8)', // Purple
                'rgba(236, 72, 153, 0.8)', // Pink
                'rgba(239, 68, 68, 0.8)', // Red
                'rgba(14, 165, 233, 0.8)', // Sky
                'rgba(168, 85, 247, 0.8)', // Violet
            ];

            const borderColors = [
                'rgba(59, 130, 246, 1)',
                'rgba(16, 185, 129, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(139, 92, 246, 1)',
                'rgba(236, 72, 153, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(14, 165, 233, 1)',
                'rgba(168, 85, 247, 1)',
            ];

            // Mapping periode
            const periods = [{
                    key: 'bulan_sekarang',
                    label: 'Bulan Sekarang',
                    opacity: 0.9
                },
                {
                    key: 'bulan_sebelumnya',
                    label: 'Bulan Sebelumnya',
                    opacity: 0.7
                },
                {
                    key: 'Satu_tahun',
                    label: 'Satu Tahun',
                    opacity: 0.5
                }
            ];

            // Fungsi untuk mengupdate tampilan chart
            function updateChartDisplay() {
                const activeDatasets = chart.data.datasets.filter((dataset, index) => {
                    const meta = chart.getDatasetMeta(index);
                    return !meta.hidden;
                });

                if (activeDatasets.length > 0) {
                    // Gabungkan semua label dari dataset yang aktif
                    const allLabels = new Set();
                    activeDatasets.forEach(dataset => {
                        dataset._originalLabels.forEach(label => {
                            allLabels.add(label);
                        });
                    });

                    // Update chart labels dengan urutan dari JSON
                    chart.data.labels = Array.from(allLabels);
                } else {
                    chart.data.labels = ['Tidak Ada Data'];
                }
            }

            // LANGKAH 1: Siapkan datasets dengan data sesuai urutan dari JSON
            let datasets = [];

            periods.forEach((period, periodIndex) => {
                const data = grafikPieData[period.key];

                if (data && data.labels && data.data && data.labels.length > 0) {
                    // Buat array data sesuai urutan dari JSON
                    const labels = [];
                    const values = [];

                    data.labels.forEach((label, index) => {
                        const value = parseInt(data.data[index]) || 0;
                        if (value > 0 && label && label.trim() !== '') {
                            labels.push(label);
                            values.push(value);
                        }
                    });

                    if (values.length > 0) {
                        // Buat warna dengan opacity sesuai periode
                        const datasetColors = colors.slice(0, values.length).map(color =>
                            color.replace(/0\.\d+/, period.opacity.toString())
                        );

                        datasets.push({
                            label: period.label,
                            data: values,
                            backgroundColor: datasetColors,
                            borderColor: borderColors.slice(0, values.length),
                            borderWidth: 2,
                            hoverBorderWidth: 3,
                            hoverOffset: 8,
                            _originalLabels: labels, // Simpan labels sesuai urutan dari JSON
                            _periodKey: period.key
                        });
                    }
                }
            });

            // Fallback jika tidak ada data
            if (datasets.length === 0) {
                datasets = [{
                    label: 'Tidak Ada Data',
                    data: [1],
                    backgroundColor: ['rgba(156, 163, 175, 0.5)'],
                    borderColor: ['rgba(156, 163, 175, 1)'],
                    borderWidth: 2,
                    _originalLabels: ['Tidak Ada Data']
                }];
            }

            // LANGKAH 3: Buat chart dengan konfigurasi yang diperbaiki
            const chart = new Chart(kategoriCtx, {
                type: 'pie',
                data: {
                    labels: datasets.length > 0 ? datasets[0]._originalLabels : ['Tidak Ada Data'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: 20
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                generateLabels: function(chart) {
                                    const labels = [];

                                    // Tambahkan legend untuk setiap dataset (periode)
                                    chart.data.datasets.forEach((dataset, index) => {
                                        // Tampilkan jumlah kategori untuk periode ini
                                        const categoryCount = dataset._originalLabels ? dataset
                                            ._originalLabels.length : 0;
                                        const labelText =
                                            `${dataset.label} (${categoryCount} kategori)`;

                                        labels.push({
                                            text: labelText,
                                            fillStyle: dataset.backgroundColor[0],
                                            strokeStyle: dataset.borderColor[0],
                                            lineWidth: dataset.borderWidth,
                                            hidden: chart.getDatasetMeta(index).hidden,
                                            datasetIndex: index
                                        });
                                    });

                                    return labels;
                                }
                            },
                            onClick: function(e, legendItem) {
                                const datasetIndex = legendItem.datasetIndex;
                                const dataset = chart.data.datasets[datasetIndex];

                                // Toggle visibility
                                const meta = chart.getDatasetMeta(datasetIndex);
                                meta.hidden = meta.hidden === null ? !dataset.hidden : null;

                                // Update labels dan data chart berdasarkan dataset yang visible
                                updateChartDisplay();
                                chart.update();
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            cornerRadius: 8,
                            padding: 12,
                            callbacks: {
                                title: function(context) {
                                    const dataset = context[0].dataset;
                                    const labelIndex = context[0].dataIndex;
                                    const categoryName = dataset._originalLabels[labelIndex];
                                    return `${categoryName} - ${dataset.label}`;
                                },
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);

                                    return `Jumlah: ${value.toLocaleString('id-ID')} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '20%',
                    animation: {
                        animateRotate: true,
                        duration: 1500
                    }
                }
            });
        });
    </script>

</body>

</html>
