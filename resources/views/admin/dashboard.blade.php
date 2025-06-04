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


    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200  ">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-700 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200   ">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('admin.show') }}" class="flex ms-2 md:me-24">
                        <img src="{{ asset('img/favicon.svg') }}" class="h-8 me-3" alt="Materialin Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap ">Materialin</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 "
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                    alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-gray-50 divide-y divide-gray-100 rounded-sm shadow-sm  "
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none">
                                    {{ $username }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    {{ $email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="/signout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100   "
                                        role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-sidebar border-r border-white/25 sm:translate-x-0  "
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-sidebar ">
            <ul class="space-y-2 font-medium">

                <x-button-sidebar route="{{ route('admin.show') }}"
                    icon='<path fill="currentColor" d="M304 240V16.6c0-9 7-16.6 16-16.6c123.7 0 224 100.3 224 224c0 9-7.6 16-16.6 16zM32 272c0-121.3 90.1-221.7 207-237.7c9.2-1.3 17 6.1 17 15.4V288l156.5 156.5c6.7 6.7 6.2 17.7-1.5 23.1c-39.2 28-87.2 44.4-139 44.4c-132.5 0-240-107.4-240-240m526.4 16c9.3 0 16.6 7.8 15.4 17c-7.7 55.9-34.6 105.6-73.9 142.3c-6 5.6-15.4 5.2-21.2-.7L320 288z" />'>
                    Dashboard
                </x-button-sidebar>

                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                        aria-controls="dropdown-transaksi" data-collapse-toggle="dropdown-transaksi">
                        <svg class="w-5 h-5 text-gray-700 overflow-visible transition duration-75 group-hover:text-gray-900"
                            width="576" height="512" viewBox="0 0 576 512">
                            <path fill="currentColor"
                                d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23l-174-.2c-13.3 0-24-10.7-24-24s10.7-24 24-24h174.1zM105 377l-23 23h174c13.3 0 24 10.7 24 24s-10.7 24-24 24H81.9l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64h241.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52h117.4c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0l19.3-19.3V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52H138.6c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64m64 64H96v64c35.3 0 64-28.7 64-64m384 192c-35.3 0-64 28.7-64 64h64zm-224 32a96 96 0 1 0 0-192a96 96 0 1 0 0 192" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Transaksi</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-transaksi" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('admin.pesanan') }}"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pesanan</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembelian') }}"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pembelian</a>
                        </li>
                    </ul>
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
                <hr class="h-px my-8 bg-black/5 border-0 ">
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 bg-gray-100">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
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

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <!-- Sales Chart -->
                @php
                    $labels = ['Bulan Ini', '3 Bulan Terakhir', 'Tahun Ini'];
                    $colors = ['text-blue-500', 'text-yellow-500', 'text-purple-500'];
                    $defaultIndex = 0; // default: Bulan Ini
                @endphp

                <div x-data="{ selectedIndex: {{ $defaultIndex }} }" class="bg-white rounded-lg shadow p-6 space-y-6">
                    {{-- Select dropdown --}}
                    <div class="mb-4">
                        <label for="periode" class="block mb-2 text-sm font-medium text-gray-900 ">Pilih
                            Periode:</label>
                        <select x-model="selectedIndex" id="periode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            @foreach ($labels as $i => $label)
                                <option value="{{ $i }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tampilan Keuntungan Berdasarkan Pilihan --}}
                    <div x-data="{
                        profits: {{ Js::from($profit['profit']) }},
                        percentages: {{ Js::from($profit['persentase']) }},
                        labels: {{ Js::from($labels) }},
                    }">
                        <template x-for="(label, index) in labels" :key="index">
                            <div x-show="selectedIndex == index" class="flex justify-between items-center">
                                <div>
                                    <h5 class="leading-none text-3xl font-bold pb-2"
                                        :class="(profits[index] >= 0) ? 'text-green-500' : 'text-red-500'">
                                        <span
                                            x-text="new Intl.NumberFormat('id-ID', { 
                            style: 'currency', 
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(profits[index])"></span>
                                    </h5>
                                    <p class="text-base font-normal text-gray-500" x-text="`Keuntungan ${label}`"></p>
                                </div>

                                <div class="flex items-center px-2.5 py-0.5 text-xl font-semibold text-center"
                                    :class="(percentages[index] >= 0) ? 'text-green-500' : 'text-red-500'">
                                    <span
                                        x-text="`${percentages[index] >= 0 ? '+' : ''}${percentages[index]}%`"></span>
                                    <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            :d="(percentages[index] >= 0) ? 'M5 13V1m0 0L1 5m4-4 4 4' :
                                            'M5 1v12m0 0L1 9m4 4 4-4'" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Chart Section --}}
                    <div id="labels-chart" class="px-2.5">
                        <canvas id="profitChart" class="h-[300px]"></canvas>
                    </div>
                </div>


                <!-- Kategori Terlaris -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Kategori Terlaris Bulan Ini</h2>
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
                                        Tanggal</th>
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
                                        <td class="px-6 py-2">{{ $p->kode_pesanan }}</td>
                                        {{-- <td class="px-6 py-2">{{ $p->tanggal }}</td> --}}
                                        <td class="px-6 py-2">{{ $p->Pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td class="px-6 py-2 font-medium text-black">Rp.
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
                            label: 'Pesanan',
                            data: @json($grafik_line['pesanan']),
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
                            label: 'Pembelian',
                            data: @json($grafik_line['pembelian']),
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
                                            'Pesanan'))?.parsed.y || 0;
                                        const pembelian = context.find(c => c.dataset.label.includes(
                                            'Pembelian'))?.parsed.y || 0;
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

            // Enhanced color palette dengan gradient effects
            const createGradient = (ctx, color1, color2) => {
                const gradient = ctx.createRadialGradient(150, 150, 0, 150, 150, 150);
                gradient.addColorStop(0, color1);
                gradient.addColorStop(0.7, color2);
                gradient.addColorStop(1, color1);
                return gradient;
            };

            // Dynamic colors dengan gradient
            const gradientColors = [
                createGradient(kategoriCtx, 'rgba(59, 130, 246, 0.9)', 'rgba(59, 130, 246, 0.6)'), // Blue
                createGradient(kategoriCtx, 'rgba(16, 185, 129, 0.9)', 'rgba(16, 185, 129, 0.6)'), // Green
                createGradient(kategoriCtx, 'rgba(245, 158, 11, 0.9)', 'rgba(245, 158, 11, 0.6)'), // Amber
                createGradient(kategoriCtx, 'rgba(139, 92, 246, 0.9)', 'rgba(139, 92, 246, 0.6)'), // Purple
                createGradient(kategoriCtx, 'rgba(236, 72, 153, 0.9)', 'rgba(236, 72, 153, 0.6)'), // Pink
                createGradient(kategoriCtx, 'rgba(239, 68, 68, 0.9)', 'rgba(239, 68, 68, 0.6)'), // Red
                createGradient(kategoriCtx, 'rgba(14, 165, 233, 0.9)', 'rgba(14, 165, 233, 0.6)'), // Sky
                createGradient(kategoriCtx, 'rgba(168, 85, 247, 0.9)', 'rgba(168, 85, 247, 0.6)'), // Violet
            ];

            // Enhanced hover colors
            const hoverColors = [
                'rgba(59, 130, 246, 1)', // Blue
                'rgba(16, 185, 129, 1)', // Green  
                'rgba(245, 158, 11, 1)', // Amber
                'rgba(139, 92, 246, 1)', // Purple
                'rgba(236, 72, 153, 1)', // Pink
                'rgba(239, 68, 68, 1)', // Red
                'rgba(14, 165, 233, 1)', // Sky
                'rgba(168, 85, 247, 1)', // Violet
            ];

            new Chart(kategoriCtx, {
                type: 'doughnut', // Changed to doughnut for modern look
                data: {
                    labels: @json($grafik_pie['labels']),
                    datasets: [{
                        data: @json($grafik_pie['data']),
                        backgroundColor: gradientColors,
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(236, 72, 153, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(14, 165, 233, 1)',
                            'rgba(168, 85, 247, 1)',
                        ],
                        hoverBackgroundColor: hoverColors,
                        borderWidth: 3,
                        hoverBorderWidth: 5,
                        hoverOffset: 15,
                        borderRadius: 8,
                        hoverBorderRadius: 12,
                        // Enhanced spacing
                        spacing: 3,
                        // Segment styling
                        borderAlign: 'inner',
                        borderJoinStyle: 'round'
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 30,
                            left: 20,
                            right: 20
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    // Enhanced interactions
                    interaction: {
                        intersect: true,
                        mode: 'point'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'rectRounded',
                                padding: 25,
                                font: {
                                    size: 14,
                                    weight: '600',
                                    family: 'system-ui, -apple-system, sans-serif'
                                },
                                color: '#374151',
                                boxWidth: 18,
                                boxHeight: 18,
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        const dataset = data.datasets[0];
                                        const total = dataset.data.reduce((a, b) => a + b, 0);

                                        return data.labels.map((label, i) => {
                                            const value = dataset.data[i];

                                            return {
                                                text: `${label}`,
                                                fillStyle: dataset.backgroundColor[i],
                                                strokeStyle: dataset.borderColor[i],
                                                lineWidth: dataset.borderWidth,
                                                pointStyle: 'rectRounded',
                                                hidden: isNaN(value) || chart.getDatasetMeta(0)
                                                    .data[i].hidden,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            },
                            onHover: (event, legendItem, legend) => {
                                legend.chart.canvas.style.cursor = 'pointer';
                            },
                            onLeave: (event, legendItem, legend) => {
                                legend.chart.canvas.style.cursor = 'default';
                            },
                            onClick: (event, legendItem, legend) => {
                                // Enhanced click animation
                                const index = legendItem.index;
                                const ci = legend.chart;
                                const meta = ci.getDatasetMeta(0);
                                const segment = meta.data[index];

                                // Toggle with animation
                                segment.hidden = !segment.hidden;
                                ci.update('active');
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.98)',
                            titleColor: '#ffffff',
                            bodyColor: '#e5e7eb',
                            cornerRadius: 16,
                            padding: 20,
                            borderColor: 'rgba(75, 85, 99, 0.3)',
                            borderWidth: 2,
                            displayColors: true,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 15,
                            boxHeight: 15,
                            boxPadding: 10,
                            titleFont: {
                                size: 16,
                                weight: '700',
                                family: 'system-ui, -apple-system, sans-serif'
                            },
                            bodyFont: {
                                size: 14,
                                weight: '600',
                                family: 'system-ui, -apple-system, sans-serif'
                            },
                            // Enhanced callbacks
                            callbacks: {
                                title: function(context) {
                                    const label = context[0].label;
                                    return `${label}`;
                                },
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw;

                                    // Format value based on size
                                    let formattedValue;
                                    if (value >= 1000000) {
                                        formattedValue = (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        formattedValue = (value / 1000).toFixed(1) + 'K';
                                    } else {
                                        formattedValue = value.toLocaleString('id-ID');
                                    }

                                    return `Jumlah: ${formattedValue}`;
                                },
                                afterLabel: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw;
                                    const rank = context.dataset.data
                                        .map((val, idx) => ({
                                            val,
                                            idx
                                        }))
                                        .sort((a, b) => b.val - a.val)
                                        .findIndex(item => item.idx === context.dataIndex) + 1;

                                    return `Peringkat: #${rank} dari ${context.dataset.data.length}`;
                                }
                            },
                            // Smooth tooltip animation
                            animation: {
                                duration: 400,
                                easing: 'easeOutQuart'
                            }
                        }
                    },
                    // Modern doughnut styling
                    cutout: '65%',
                    radius: '90%',

                    // Enhanced animations
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        delay: (context) => {
                            return context.type === 'data' && context.mode === 'default' ?
                                context.dataIndex * 300 :
                                0;
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: false
                        }
                    },

                    // Enhanced hover effects
                    onHover: (event, elements, chart) => {
                        chart.canvas.style.cursor = elements.length > 0 ? 'pointer' : 'default';

                        // Scale effect on hover
                        if (elements.length > 0) {
                            chart.canvas.style.transform = 'scale(1.02)';
                            chart.canvas.style.transition = 'transform 0.3s ease';
                        } else {
                            chart.canvas.style.transform = 'scale(1)';
                        }
                    },

                    // Click interactions
                    onClick: (event, elements, chart) => {
                        if (elements.length > 0) {
                            const element = elements[0];
                            const dataIndex = element.index;
                            const value = chart.data.datasets[0].data[dataIndex];
                            const label = chart.data.labels[dataIndex];
                            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);

                            // Pulse animation on click
                            const segment = chart.getDatasetMeta(0).data[dataIndex];
                            const originalOffset = segment.options.hoverOffset || 0;

                            // Animate segment
                            segment.options.hoverOffset = 25;
                            chart.update('none');

                            setTimeout(() => {
                                segment.options.hoverOffset = originalOffset;
                                chart.update();
                            }, 300);

                            console.log(`Clicked: ${label} - ${value} (${percentage}%)`);
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>
