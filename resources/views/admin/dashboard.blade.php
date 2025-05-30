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
                        <p
                            class="{{ $pesanan['persentase'] >= 0 ? 'text-green-500' : 'text-red-500' }} text-xs flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $pesanan['persentase'] }}% from last month
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
                        <p
                            class="{{ $pembelian['persentase'] <= 0 ? 'text-green-500' : 'text-red-500' }} text-xs flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $pembelian['persentase'] }}% from last month
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
                        <p class="text-red-500 text-xs flex items-center">
                            <i class="fas fa-arrow-down mr-1"></i> {{ $pendapatan['persentase'] }}% from last month
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
                        <p
                            class="{{ $pengeluaran['persentase'] <= 0 ? 'text-green-500' : 'text-red-500' }} text-xs flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $pengeluaran['persentase'] }}% from last month
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
                        <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                            Periode:</label>
                        <select x-model="selectedIndex" id="periode"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 focus:outline-none px-3 py-2">
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
                        <canvas id="salesChart" class="h-[300px]"></canvas>
                    </div>
                </div>


                <!-- Kategori Terlaris -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Kategori Terlaris</h2>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
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
                                        <td class="px-6 py-2">{{ $p->tanggal }}</td>
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
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-medium text-gray-900">New user registered</p>
                                <p class="text-sm text-gray-500">John Doe just signed up</p>
                                <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-medium text-gray-900">New order received</p>
                                <p class="text-sm text-gray-500">Order #ORD-0005 for $156.00</p>
                                <p class="text-xs text-gray-400 mt-1">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-truck"></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-medium text-gray-900">Order shipped</p>
                                <p class="text-sm text-gray-500">Order #ORD-0003 has been shipped</p>
                                <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-medium text-gray-900">Payment failed</p>
                                <p class="text-sm text-gray-500">Payment for order #ORD-0006 failed</p>
                                <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const revenueGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
            revenueGradient.addColorStop(0, 'rgba(75, 192, 192, 0.3)');
            revenueGradient.addColorStop(1, 'rgba(75, 192, 192, 0.05)');

            const expenseGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
            expenseGradient.addColorStop(0, 'rgba(255, 99, 132, 0.3)');
            expenseGradient.addColorStop(1, 'rgba(255, 99, 132, 0.05)');

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($grafik_line['labels']),
                    datasets: [{
                            label: 'Pesanan',
                            data: @json($grafik_line['pesanan']),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: revenueGradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        },
                        {
                            label: 'Pembelian',
                            data: @json($grafik_line['pembelian']),
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: expenseGradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
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
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            cornerRadius: 12,
                            padding: 12,
                            displayColors: true,
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ' ' + context.parsed.y
                                        .toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '500',
                                    height: '300'
                                },
                                color: '#6b7280',
                                padding: 10,
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                color: '#374151',
                                padding: 10
                            }
                        }
                    }
                }
            });

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($grafik_pie['labels']),
                    datasets: [{
                        data: @json($grafik_pie['data']),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // Blue
                            'rgba(16, 185, 129, 0.8)', // Green
                            'rgba(245, 158, 11, 0.8)', // Amber
                            'rgba(139, 92, 246, 0.8)', // Purple
                            'rgba(156, 163, 175, 0.8)', // Gray
                            'rgba(239, 68, 68, 0.8)', // Red
                            'rgba(236, 72, 153, 0.8)', // Pink
                            'rgba(6, 182, 212, 0.8)' // Cyan
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(156, 163, 175, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(236, 72, 153, 1)',
                            'rgba(6, 182, 212, 1)'
                        ],
                        borderWidth: 2,
                        hoverBorderWidth: 3,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateRotate: true,
                        duration: 1000
                    }
                }
            });
        });
    </script>

</body>

</html>
