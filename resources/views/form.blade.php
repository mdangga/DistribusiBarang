<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <title>Form Pesanan - Materialin</title>
</head>

<body class="h-full bg-white flex flex-col items-center p-10">

    <!-- Toast untuk error validasi -->
    @if ($errors->has('id_pelanggan'))
        <x-toast-info :fields="['id_pelanggan']" type="error" />
    @endif

    @if ($errors->has('items') || $errors->has('items.*'))
        <x-toast-info :fields="['items', 'items.*']" type="error" />
    @endif

    @if (session('error'))
        <x-toast-info :fields="['general']" type="error" />
    @endif

    <a href="#" class="flex ms-2 md:me-24 my-5">
        <img src="{{ asset('img/favicon.svg') }}" class="h-16 me-3" alt="Materialin Logo" />
        <span class="self-center text-4xl font-semibold sm:text-4xl whitespace-nowrap">Materialin</span>
    </a>

    <div class="w-full max-w-7xl p-6 space-y-6">
        <form id="pesananForm" action="{{ route('pesanan.store') }}" method="POST">
            @csrf

            <!-- Main Grid: Informasi Umum (Kiri) dan Ringkasan Harga (Kanan) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Kiri: Informasi Umum dan Input Barang -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Informasi Umum -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama <a data-modal-target="addModalPelanggan"
                                    data-modal-toggle="addModalPelanggan" class="cursor-pointer">Pelanggan</a><span
                                    class="text-gray-400">(Opsional)</span>
                            </label>
                            <input type="hidden" name="id_pelanggan" id="id_pelanggan"
                                value="{{ old('id_pelanggan') }}">

                            <!-- Wrapper untuk autocomplete input dengan popover trigger -->
                            <div class="relative">
                                <x-autocomplete-input name="pelanggan" endpoint="{{ route('autocomplete.pelanggan') }}"
                                    placeholder="Cari pelanggan..." form-field="nama_pelanggan" id-field="id"
                                    id="autocomplete-pelanggan" :class="$errors->has('id_pelanggan') ? 'border-red-500' : ''" />

                                <!-- Popover trigger icon -->
                                <div id="popoverTrigger"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden cursor-help">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Popover -->
                            <div id="discountPopover" role="tooltip"
                                class="absolute z-50 invisible inline-block w-80 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 ">
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 rounded-t-lg ">
                                    <h3 id="popoverTitle" class="font-semibold text-gray-900 ">Status
                                        Diskon Pelanggan</h3>
                                </div>
                                <div class="px-4 py-3">
                                    <div id="popoverContent" class="space-y-2">
                                        <p class="text-gray-600">Pilih pelanggan untuk melihat status diskon</p>
                                    </div>
                                </div>
                                <div data-popper-arrow></div>
                            </div>

                            @error('id_pelanggan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input aria-label="disabled input 2" type="text" name="tanggal"
                                value="{{ old('tanggal', date('Y-m-d H:i:s')) }}" readonly
                                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Input Barang -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Autocomplete Barang -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang *</label>
                            <x-autocomplete-input name="barang" :endpoint="route('autocomplete.barang')" placeholder="Cari barang..."
                                form-field="nama_barang" id-field="id" />
                        </div>

                        <!-- Input Jumlah -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah *</label>
                            <input type="number" id="jumlahInput" min="1" value="1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5" />
                        </div>

                        <!-- Tombol Tambah -->
                        <div>
                            <label class="block text-sm font-medium text-transparent mb-2">.</label>
                            <button type="button" id="tambahBarang" disabled
                                class="bg-gray-400 text-white inline-flex items-center justify-center w-ful ">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    fill="currentColor">
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256z" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Pesan Error untuk Items -->
                    @if ($errors->has('items') || $errors->has('items.*'))
                        <div class="bg-red-50 border border-red-200 rounded-md p-4 mt-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Terjadi kesalahan pada item pesanan:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                @if (str_contains($error, 'item') || str_contains($error, 'barang') || str_contains($error, 'jumlah'))
                                                    <li>{{ $error }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tabel Daftar Barang -->
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="overflow-x-auto" id="tabelWrapper">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">Nama Barang</th>
                                        <th class="px-4 py-2">Jumlah</th>
                                        <th class="px-4 py-2">Harga Satuan</th>
                                        <th class="px-4 py-2">Subtotal</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="daftarBarang">
                                    <!-- Items akan ditambahkan di sini -->
                                </tbody>
                            </table>

                            <!-- Pesan jika belum ada item -->
                            <div id="emptyMessage"
                                class="flex items-center justify-center flex-col text-center text-gray-500 min-h-[322px] h-full w-full">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada item</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan barang ke pesanan.</p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan Harga -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Awal:</span>
                                <span class="font-medium">Rp <span id="totalAwal">0</span></span>
                            </div>

                            <div class="flex justify-between text-sm" id="diskonRow" style="display: none;">
                                <span class="text-gray-600">Diskon (2%):</span>
                                <span class="font-medium text-green-600">-Rp <span id="totalDiskon">0</span></span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Setelah Diskon:</span>
                                <span class="font-medium">Rp <span id="setelahDiskon">0</span></span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Pajak (11%):</span>
                                <span class="font-medium">Rp <span id="totalPajak">0</span></span>
                            </div>

                            <hr class="border-gray-300">

                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">Total Akhir:</span>
                                <span class="text-gray-900">Rp <span id="grandTotal">0</span></span>
                            </div>
                        </div>

                        <!-- Section Pembayaran Tunai -->
                        <div class="mt-6 pt-4 border-t border-gray-300">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Pembayaran Tunai</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Tunai <span class="text-gray-400">(Opsional)</span>
                                    </label>
                                    <input type="number" name="jumlah_tunai" id="jumlahTunai" min="0"
                                        step="1000" placeholder="Masukkan jumlah tunai"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kembalian</label>
                                    <div
                                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 font-medium">
                                        Rp <span id="kembalian">0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Pembayaran -->
                            <div id="statusPembayaran" class="mt-3 p-3 rounded-md hidden">
                                <div class="flex items-center">
                                    <div id="statusIcon" class="flex-shrink-0">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium" id="statusMessage"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs untuk form -->
                        <input type="hidden" name="total_awal" id="totalAwalInput" value="0">
                        <input type="hidden" name="total_diskon" id="totalDiskonInput" value="0">
                        <input type="hidden" name="total_pajak" id="totalPajakInput" value="0">
                        <input type="hidden" name="total_harga" id="totalHargaInput" value="0">
                        <input type="hidden" name="kembalian" id="kembalianInput" value="0">

                        <div class="mt-4 pt-4 border-t border-gray-300">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Tombol Simpan -->
                                <button type="submit" id="submitBtn" disabled class="bg-gray-400 text-white">
                                    Simpan
                                </button>
                                <!-- Tombol Batal -->
                                <a href="{{ route('pesanan.list') }}"
                                    class=" bg-orange hover:bg-orangehover text-center text-white px-6 py-3 rounded-md transition">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <x-modal id="addModalPelanggan" header="Tambah Pelanggan" button="Tambah" :actionRoute="route('add.pelanggan')"
            methodOverride="POST">
            <div class="grid gap-4 mb-4
            grid-cols-3">
                {{-- svg icon di header --}}
                <x-slot:iconheader>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"
                        class="text-gray-700 mr-3 overflow-visible">
                        <path fill="currentColor"
                            d="M224 256a128 128 0 1 0 0-256a128 128 0 1 0 0 256m-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512h388.6c10 0 18.8-4.9 24.2-12.5l-99.2-99.2c-14.9-14.9-23.3-35.1-23.3-56.1v-33c-15.9-4.7-32.8-7.2-50.3-7.2zM384 224c-17.7 0-32 14.3-32 32v82.7c0 17 6.7 33.3 18.7 45.3l107.4 107.3c18.7 18.7 49.1 18.7 67.9 0l73.4-73.4c18.7-18.7 18.7-49.1 0-67.9L512 242.7c-12-12-28.3-18.7-45.3-18.7zm24 80a24 24 0 1 1 48 0a24 24 0 1 1-48 0" />
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
                <div class="col-span-3">
                    <label for="nama_pelanggan" class="block mb-2 text-sm font-medium text-gray-900">Nama
                        Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5 ">
                </div>

                <div class="col-span-3 sm:col-span-3">
                    <label for="no_telpon" class="block mb-2 text-sm font-medium text-gray-900">No Telpon</label>
                    <input type="text" name="no_telpon" id="no_telpon"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transitions block w-full p-2.5">
                </div>

                <div class="col-span-3 sm:col-span-3">
                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 transition block w-full p-2.5 resize-none"></textarea>
                </div>
            </div>
        </x-modal>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Variabel untuk menyimpan data terpilih
                let barangTerpilih = null;
                let pelangganTerpilih = null;
                let discountStatus = null;
                let index = 0;
                let items = [];

                // Referensi elemen
                const tbody = document.getElementById('daftarBarang');
                const emptyMessage = document.getElementById('emptyMessage');
                const tambahBarangButton = document.getElementById('tambahBarang');
                const submitBtn = document.getElementById('submitBtn');
                const jumlahInput = document.getElementById('jumlahInput');
                const jumlahTunaiInput = document.getElementById('jumlahTunai');

                // Referensi elemen popover
                const popoverTrigger = document.getElementById('popoverTrigger');
                const popover = document.getElementById('discountPopover');
                const popoverTitle = document.getElementById('popoverTitle');
                const popoverContent = document.getElementById('popoverContent');

                // Setup Popover - Diperbaiki untuk positioning yang lebih baik
                function setupPopover() {
                    let hoverTimer;
                    let isHovering = false;

                    // Show popover on hover
                    function showPopover() {
                        if (discountStatus && popoverTrigger && !popoverTrigger.classList.contains('hidden')) {
                            positionPopover();
                            popover.classList.remove('invisible', 'opacity-0');
                            popover.classList.add('visible', 'opacity-100');
                        }
                    }

                    // Hide popover
                    function hidePopover() {
                        popover.classList.add('invisible', 'opacity-0');
                        popover.classList.remove('visible', 'opacity-100');
                    }

                    // Position popover - Diperbaiki untuk positioning yang lebih akurat
                    function positionPopover() {
                        if (!popoverTrigger || !popover) return;

                        const triggerRect = popoverTrigger.getBoundingClientRect();
                        const popoverRect = popover.getBoundingClientRect();
                        const viewportWidth = window.innerWidth;
                        const viewportHeight = window.innerHeight;

                        // Calculate position
                        let left = triggerRect.left - (popoverRect.width / 2) + (triggerRect.width / 2);
                        let top = triggerRect.bottom + 8;

                        // Adjust horizontal position if popover goes off screen
                        if (left < 8) {
                            left = 8;
                        } else if (left + popoverRect.width > viewportWidth - 8) {
                            left = viewportWidth - popoverRect.width - 8;
                        }

                        // Adjust vertical position if popover goes off bottom of screen
                        if (top + popoverRect.height > viewportHeight - 8) {
                            top = triggerRect.top - popoverRect.height - 8;
                        }

                        // Apply position
                        popover.style.position = 'fixed';
                        popover.style.left = `${left}px`;
                        popover.style.top = `${top}px`;
                        popover.style.zIndex = '9999';
                    }

                    // Event listeners for popover trigger
                    if (popoverTrigger) {
                        popoverTrigger.addEventListener('mouseenter', function() {
                            isHovering = true;
                            clearTimeout(hoverTimer);
                            showPopover();
                        });

                        popoverTrigger.addEventListener('mouseleave', function() {
                            isHovering = false;
                            hoverTimer = setTimeout(() => {
                                if (!isHovering) hidePopover();
                            }, 200);
                        });
                    }

                    // Keep popover open when hovering over it
                    if (popover) {
                        popover.addEventListener('mouseenter', function() {
                            isHovering = true;
                            clearTimeout(hoverTimer);
                        });

                        popover.addEventListener('mouseleave', function() {
                            isHovering = false;
                            hoverTimer = setTimeout(() => {
                                if (!isHovering) hidePopover();
                            }, 200);
                        });
                    }

                    // Hide popover when scrolling or resizing
                    window.addEventListener('scroll', hidePopover);
                    window.addEventListener('resize', hidePopover);
                }

                // Update popover content - Diperbaiki untuk handle data yang lebih robust
                function updatePopoverContent(data) {
                    if (!data || !popoverTitle || !popoverContent) {
                        if (popoverTrigger) popoverTrigger.classList.add('hidden');
                        return;
                    }

                    popoverTrigger.classList.remove('hidden');

                    if (data.eligible) {
                        popoverTitle.textContent = 'Mendapat Diskon 2%';
                        popoverContent.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-green-600 font-medium">Diskon Aktif</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <div>Total bulan ini: <strong>Rp ${formatRupiah(data.current_month_total || 0)}</strong></div>
                        <div class="text-green-600 mt-1">✓ Diskon 2% akan diterapkan</div>
                    </div>
                </div>
            `;
                    } else {
                        popoverTitle.textContent = 'Status Diskon';
                        const remainingAmount = data.remaining_amount || 0;
                        const currentTotal = data.current_month_total || 0;

                        popoverContent.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <span class="text-yellow-600 font-medium">Belum Mencukupi</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <div>Total bulan ini: <strong>Rp ${formatRupiah(currentTotal)}</strong></div>
                        ${remainingAmount > 0 ? `<div class="text-yellow-600 mt-1">Butuh <strong>Rp ${formatRupiah(remainingAmount)}</strong> lagi</div>` : ''}
                    </div>
                </div>
            `;
                    }
                }

                // Event listener untuk autocomplete - Diperbaiki untuk handle discount status
                document.addEventListener('autocomplete-selected', function(e) {
                    const {
                        field,
                        selected
                    } = e.detail;

                    if (field === 'barang') {
                        barangTerpilih = selected;
                        updateTambahButton();
                    } else if (field === 'pelanggan') {
                        pelangganTerpilih = selected;
                        const idPelangganInput = document.querySelector('input[name="id_pelanggan"]');
                        if (idPelangganInput) {
                            idPelangganInput.value = pelangganTerpilih.id;
                        }
                        // Check discount status setelah pelanggan dipilih
                        checkDiscountStatus(pelangganTerpilih.id);
                    }
                });

                // Event listener untuk autocomplete cleared - Diperbaiki
                document.addEventListener('autocomplete-cleared', function(e) {
                    const {
                        field
                    } = e.detail;

                    if (field === 'pelanggan') {
                        pelangganTerpilih = null;
                        discountStatus = null;
                        const idPelangganInput = document.querySelector('input[name="id_pelanggan"]');
                        if (idPelangganInput) {
                            idPelangganInput.value = '';
                        }
                        if (popoverTrigger) {
                            popoverTrigger.classList.add('hidden');
                        }
                        updateRingkasan();
                    } else if (field === 'barang') {
                        barangTerpilih = null;
                        updateTambahButton();
                    }
                });

                // Event listener untuk input jumlah
                jumlahInput.addEventListener('input', updateTambahButton);

                // Event listener untuk input tunai
                jumlahTunaiInput.addEventListener('input', function() {
                    updateKembalian();
                    updateStatusPembayaran();
                });

                // Fungsi untuk cek status diskon - Diperbaiki error handling
                async function checkDiscountStatus(pelangganId) {
                    if (!pelangganId) return;

                    try {
                        const response = await fetch(`/pesanan/discount-status/${pelangganId}`);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();
                        console.log('Discount status received:', data); // Debug log

                        discountStatus = data;
                        updatePopoverContent(data);
                        updateRingkasan();
                    } catch (error) {
                        console.error('Error checking discount status:', error);
                        discountStatus = null;
                        if (popoverTrigger) {
                            popoverTrigger.classList.add('hidden');
                        }
                        updateRingkasan();
                    }
                }

                // Fungsi untuk mengupdate status tombol tambah
                function updateTambahButton() {
                    const jumlah = parseInt(jumlahInput.value) || 0;
                    const canAdd = barangTerpilih && jumlah > 0;

                    tambahBarangButton.disabled = !canAdd;
                    tambahBarangButton.className = canAdd ?
                        "inline-flex items-center justify-center w-full bg-[#ff9f1c] text-white p-2 rounded-md hover:bg-[#c8821f] focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 transition text-center" :
                        "inline-flex items-center justify-center w-full bg-gray-400 text-white p-2 rounded-md transition text-center disabled:cursor-not-allowed";
                }

                // Event listener untuk tombol tambah barang
                tambahBarangButton.addEventListener('click', function() {
                    if (!barangTerpilih) return;

                    const jumlah = parseInt(jumlahInput.value) || 0;
                    if (jumlah <= 0) return;

                    const {
                        id,
                        nama_barang: nama,
                        harga
                    } = barangTerpilih;
                    const subtotal = harga * jumlah;

                    // Cek apakah barang sudah ada dalam daftar
                    const existingIndex = items.findIndex(item => item.id_barang === id);

                    if (existingIndex !== -1) {
                        // Jika barang sudah ada, tambahkan jumlahnya
                        const konfirmasi = confirm(
                            `Barang "${nama}" sudah ada dalam daftar. Apakah ingin menambah jumlahnya?`);
                        if (konfirmasi) {
                            items[existingIndex].jumlah += jumlah;
                            items[existingIndex].subtotal = items[existingIndex].harga * items[existingIndex]
                                .jumlah;
                        } else {
                            return;
                        }
                    } else {
                        // Tambahkan item baru
                        items.push({
                            id_barang: id,
                            nama_barang: nama,
                            jumlah: jumlah,
                            harga: harga,
                            subtotal: subtotal
                        });
                    }

                    // Render ulang tabel
                    renderTableWithHighlight();
                    updateRingkasan();
                    updateSubmitButton();
                    updateKembalian();
                    updateStatusPembayaran();

                    // Reset form
                    barangTerpilih = null;
                    jumlahInput.value = 1;
                    const searchInput = document.querySelector('input[name="barang"]');
                    if (searchInput) {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                    updateTambahButton();
                });

                // Event delegation untuk tombol hapus
                tbody.addEventListener('click', function(e) {
                    if (e.target.matches('button') && e.target.textContent.trim() === 'Hapus') {
                        const row = e.target.closest('tr');
                        const itemIndex = parseInt(row.dataset.index);

                        // Hapus dari array
                        items.splice(itemIndex, 1);

                        // Render ulang
                        renderTable();
                        updateRingkasan();
                        updateSubmitButton();
                        updateKembalian();
                        updateStatusPembayaran();
                    }
                });

                // Fungsi untuk render tabel
                function renderTable() {
                    if (items.length === 0) {
                        tbody.innerHTML = '';
                        emptyMessage.style.display = 'block';
                        return;
                    }

                    emptyMessage.style.display = 'none';
                    tbody.innerHTML = items.map((item, idx) => `
            <tr data-index="${idx}">
                <td class="px-4 py-2">
                    ${item.nama_barang}
                    <input type="hidden" name="items[${idx}][id_barang]" value="${item.id_barang}">
                </td>
                <td class="px-4 py-2">
                    ${item.jumlah}
                    <input type="hidden" name="items[${idx}][jumlah]" value="${item.jumlah}">
                </td>
                <td class="px-4 py-2">Rp ${formatRupiah(item.harga)}</td>
                <td class="px-4 py-2 font-medium">Rp ${formatRupiah(item.subtotal)}</td>
                <td class="px-4 py-2">
                    <button type="button" class="text-red-600 hover:text-red-800 font-medium">
                        Hapus
                    </button>
                </td>
            </tr>
        `).join('');
                }

                // Fungsi untuk mengupdate ringkasan - Diperbaiki untuk handle discount
                function updateRingkasan() {
                    const totalAwal = items.reduce((sum, item) => sum + item.subtotal, 0);

                    // Hitung diskon berdasarkan status pelanggan
                    let diskon = 0;
                    if (discountStatus && discountStatus.eligible && totalAwal > 0) {
                        diskon = totalAwal * 0.02; // 2%
                    }

                    const setelahDiskon = totalAwal - diskon;
                    const pajak = setelahDiskon * 0.11; // 11%
                    const totalAkhir = setelahDiskon + pajak;

                    // Update tampilan
                    document.getElementById('totalAwal').textContent = formatRupiah(totalAwal);
                    document.getElementById('totalDiskon').textContent = formatRupiah(diskon);
                    document.getElementById('setelahDiskon').textContent = formatRupiah(setelahDiskon);
                    document.getElementById('totalPajak').textContent = formatRupiah(pajak);
                    document.getElementById('grandTotal').textContent = formatRupiah(totalAkhir);

                    // Update hidden inputs
                    document.getElementById('totalAwalInput').value = totalAwal;
                    document.getElementById('totalDiskonInput').value = diskon;
                    document.getElementById('totalPajakInput').value = Math.round(pajak);
                    document.getElementById('totalHargaInput').value = Math.round(totalAkhir);

                    // Show/hide diskon row
                    const diskonRow = document.getElementById('diskonRow');
                    if (diskonRow) {
                        diskonRow.style.display = diskon > 0 ? 'flex' : 'none';
                    }
                }

                // Fungsi untuk update kembalian
                function updateKembalian() {
                    const totalAkhir = parseFloat(document.getElementById('totalHargaInput').value) || 0;
                    const jumlahTunai = parseFloat(jumlahTunaiInput.value) || 0;
                    const kembalian = Math.max(0, jumlahTunai - totalAkhir);

                    document.getElementById('kembalian').textContent = formatRupiah(kembalian);
                    document.getElementById('kembalianInput').value = kembalian;
                }

                // Fungsi untuk update status pembayaran
                function updateStatusPembayaran() {
                    const totalAkhir = parseFloat(document.getElementById('totalHargaInput').value) || 0;
                    const jumlahTunai = parseFloat(jumlahTunaiInput.value) || 0;
                    const statusDiv = document.getElementById('statusPembayaran');
                    const statusIcon = document.getElementById('statusIcon');
                    const statusMessage = document.getElementById('statusMessage');

                    if (jumlahTunai === 0) {
                        statusDiv.classList.add('hidden');
                        return;
                    }

                    statusDiv.classList.remove('hidden');

                    if (jumlahTunai >= totalAkhir) {
                        statusDiv.className = 'mt-3 p-3 bg-green-50 border border-green-200 rounded-md';
                        // statusIcon.className = 'h-5 w-5 text-green-400';
                        statusIcon.innerHTML = `
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        `;

                        statusMessage.className = 'text-sm font-medium text-green-800';
                        statusMessage.textContent = 'Pembayaran mencukupi';
                    } else {
                        const kekurangan = totalAkhir - jumlahTunai;
                        statusDiv.className = 'mt-3 p-3 bg-red-50 border border-red-200 rounded-md';
                        // statusIcon.className = 'h-5 w-5 text-red-400';
                        statusIcon.innerHTML = `
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        `;
                        statusMessage.className = 'text-sm font-medium text-red-800';
                        statusMessage.textContent = `Kurang Rp ${formatRupiah(kekurangan)}`;
                    }
                }

                // Fungsi untuk mengupdate tombol submit
                function updateSubmitButton() {
                    const canSubmit = items.length > 0;
                    submitBtn.disabled = !canSubmit;
                    submitBtn.className = canSubmit ?
                        "flex-1 bg-[#2ab6a9] hover:bg-[#1e8379] text-white px-6 py-3 rounded-md transition" :
                        "flex-1 bg-gray-400 text-white px-6 py-3 rounded-md transition disabled:cursor-not-allowed";
                }

                // Fungsi untuk highlight baris yang baru ditambahkan
                function highlightNewRow() {
                    const rows = tbody.querySelectorAll('tr');
                    const lastRow = rows[rows.length - 1];

                    if (lastRow) {
                        // Reset any existing transitions/styles
                        lastRow.style.transition = '';
                        lastRow.style.backgroundColor = '';

                        // Force browser reflow untuk memastikan reset
                        lastRow.offsetHeight;

                        // Set smooth transition dengan cubic-bezier untuk easing yang natural
                        lastRow.style.transition = 'background-color 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

                        // Gunakan requestAnimationFrame untuk smooth fade in
                        requestAnimationFrame(() => {
                            lastRow.style.backgroundColor = '#fef3cd';
                        });

                        // Fade out setelah 1.5 detik
                        setTimeout(() => {
                            lastRow.style.backgroundColor = '';

                            // Bersihkan transition setelah animasi selesai
                            setTimeout(() => {
                                lastRow.style.transition = '';
                            }, 400); // Durasi sama dengan transition
                        }, 1500);
                    }
                }

                // Update fungsi renderTable untuk include highlight
                function renderTableWithHighlight() {
                    const previousCount = tbody.querySelectorAll('tr').length;
                    renderTable();

                    // Jika ada item baru, highlight
                    if (items.length > previousCount) {
                        highlightNewRow();
                    }
                }

                // Form submit handler
                const form = document.getElementById('pesananForm');
                form.addEventListener('submit', function(e) {
                    if (items.length === 0) {
                        e.preventDefault();
                        alert('Minimal harus ada satu item dalam pesanan!');
                        return false;
                    }

                    // Validasi tambahan jika diperlukan
                    const totalAkhir = parseFloat(document.getElementById('totalHargaInput').value) || 0;
                    const jumlahTunai = parseFloat(jumlahTunaiInput.value) || 0;

                    // Jika ada input tunai tapi kurang dari total
                    if (jumlahTunai > 0 && jumlahTunai < totalAkhir) {
                        const konfirmasi = confirm(
                            'Jumlah tunai kurang dari total pembayaran. Apakah Anda yakin ingin melanjutkan?'
                        );
                        if (!konfirmasi) {
                            e.preventDefault();
                            return false;
                        }
                    }

                    // Tampilkan loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
            <div class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <rect width="10" height="10" x="1" y="1" fill="currentColor" rx="1">
                        <animate id="svgSpinnersBlocksShuffle30" fill="freeze" attributeName="x" begin="0;svgSpinnersBlocksShuffle3b.end" dur="0.2s" values="1;13" />
                        <animate id="svgSpinnersBlocksShuffle31" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle38.end" dur="0.2s" values="1;13" />
                        <animate id="svgSpinnersBlocksShuffle32" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle39.end" dur="0.2s" values="13;1" />
                        <animate id="svgSpinnersBlocksShuffle33" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle3a.end" dur="0.2s" values="13;1" />
                    </rect>
                    <rect width="10" height="10" x="1" y="13" fill="currentColor" rx="1">
                        <animate id="svgSpinnersBlocksShuffle34" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle30.end" dur="0.2s" values="13;1" />
                        <animate id="svgSpinnersBlocksShuffle35" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle31.end" dur="0.2s" values="1;13" />
                        <animate id="svgSpinnersBlocksShuffle36" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle32.end" dur="0.2s" values="1;13" />
                        <animate id="svgSpinnersBlocksShuffle37" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle33.end" dur="0.2s" values="13;1" />
                    </rect>
                    <rect width="10" height="10" x="13" y="13" fill="currentColor" rx="1">
                        <animate id="svgSpinnersBlocksShuffle38" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle34.end" dur="0.2s" values="13;1" />
                        <animate id="svgSpinnersBlocksShuffle39" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle35.end" dur="0.2s" values="13;1" />
                        <animate id="svgSpinnersBlocksShuffle3a" fill="freeze" attributeName="x" begin="svgSpinnersBlocksShuffle36.end" dur="0.2s" values="1;13" />
                        <animate id="svgSpinnersBlocksShuffle3b" fill="freeze" attributeName="y" begin="svgSpinnersBlocksShuffle37.end" dur="0.2s" values="1;13" />
                    </rect>
                </svg>
                <span class="ml-2">Menyimpan...</span>
            </div>
        `;
                });

                // Fungsi helper untuk format rupiah
                function formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID').format(Math.round(angka));
                }

                // Fungsi untuk validasi real-time pada input jumlah
                jumlahInput.addEventListener('input', function() {
                    let value = parseInt(this.value);

                    // Pastikan nilai minimal 1
                    if (value < 1 || isNaN(value)) {
                        this.value = 1;
                    }

                    // Batas maksimal jika diperlukan (misalnya 9999)
                    if (value > 9999) {
                        this.value = 9999;
                    }

                    updateTambahButton();
                });

                // Fungsi untuk validasi input tunai
                jumlahTunaiInput.addEventListener('input', function() {
                    let value = parseFloat(this.value);

                    // Pastikan nilai tidak negatif
                    if (value < 0) {
                        this.value = 0;
                    }

                    updateKembalian();
                    updateStatusPembayaran();
                });

                // Fungsi untuk handle paste pada input tunai (format angka)
                jumlahTunaiInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        let value = this.value.replace(/[^0-9.]/g, '');
                        this.value = value;
                        updateKembalian();
                        updateStatusPembayaran();
                    }, 10);
                });

                // Fungsi untuk handle keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // Enter pada input jumlah = tambah barang
                    if (e.target === jumlahInput && e.key === 'Enter') {
                        e.preventDefault();
                        if (!tambahBarangButton.disabled) {
                            tambahBarangButton.click();
                        }
                    }

                    // Ctrl+S = submit form
                    if (e.ctrlKey && e.key === 's') {
                        e.preventDefault();
                        if (!submitBtn.disabled) {
                            form.submit();
                        }
                    }

                    // Escape = focus ke search barang
                    if (e.key === 'Escape') {
                        const searchInput = document.querySelector('input[name="barang"]');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    }
                });

                // Auto-focus ke input barang saat halaman dimuat
                window.addEventListener('load', function() {
                    const barangInput = document.querySelector('input[name="barang"]');
                    if (barangInput) {
                        barangInput.focus();
                    }
                });

                // Event listener untuk menangani perubahan pada input barang (jika ada perubahan manual)
                document.addEventListener('input', function(e) {
                    if (e.target.name === 'barang') {
                        // Reset barang terpilih jika user mengetik manual
                        if (!e.target.dataset.selected) {
                            barangTerpilih = null;
                            updateTambahButton();
                        }
                    }
                });

                // Event listener untuk reset jika diperlukan
                document.addEventListener('keydown', function(e) {
                    // Ctrl+R atau F5 untuk refresh - konfirmasi jika ada data
                    if ((e.ctrlKey && e.key === 'r') || e.key === 'F5') {
                        if (items.length > 0) {
                            const konfirmasi = confirm(
                                'Ada data yang belum disimpan. Apakah Anda yakin ingin me-refresh halaman?');
                            if (!konfirmasi) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    }
                });

                // Inisialisasi saat halaman dimuat
                setupPopover(); // Tambahkan inisialisasi popover
                updateTambahButton();
                updateSubmitButton();
                updateRingkasan();

                console.log('Form pesanan script loaded successfully');
            });
        </script>
</body>

</html>
