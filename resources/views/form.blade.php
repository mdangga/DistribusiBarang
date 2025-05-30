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

<body class="h-full bg-white flex flex-col items-center  p-10">
    <a href="#" class="flex ms-2 md:me-24 my-5">
        <img src="{{ asset('img/favicon.svg') }}" class="h-16 me-3" alt="Materialin Logo" />
        <span class="self-center text-4xl font-semibold sm:text-4xl whitespace-nowrap ">Materialin</span>
    </a>
    <div class="w-full max-w-4xl p-6 space-y-6">
        <form id="pesananForm" action="{{ route('pesanan.store') }}" method="POST">
            @csrf
            <!-- Informasi Umum -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Input hidden untuk ID pesanan kosong yang akan diisi -->
                <input type="hidden" name="kode_pesanan" value="{{ $emptyPesanan->kode_pesanan }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan</label>
                    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="">
                    <x-autocomplete-input name="pelanggan" endpoint="{{ route('autocomplete.pelanggan') }}"
                        placeholder="Cari pelanggan..." form-field="nama_pelanggan" id-field="id"
                        id="autocomplete-pelanggan" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input aria-label="disabled input 2" type="text" name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}" readonly
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5 cursor-not-allowed ">
                </div>
            </div>

            <!-- Input Barang -->
            <div class="grid grid-cols-3 gap-4 items-end mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang</label>
                    <x-autocomplete-input name="barang" :endpoint="route('autocomplete.barang')" placeholder="Cari barang..."
                        form-field="nama_barang" id-field="id" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlahInput" min="1" value="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5" />
                </div>
                <div>
                    <button type="button" id="tambahBarang"
                        class="inline-flex items-center justify-center w-full bg-[#ff9f1c] text-white p-2 rounded-md hover:bg-[#c8821f] focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 transition text-center">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256z" />
                        </svg>
                        Tambah
                    </button>


                </div>
            </div>

            <!-- Tabel Daftar Barang -->
            <div class="overflow-x-auto mt-6  border rounded" id="tabelWrapper">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarBarang">

                    </tbody>
                </table>
            </div>

            <!-- Total Harga -->
            <div class="grid grid-rows-3 mt-4">
                <div class="text-right">
                    <div class="text-sm text-gray-700">Tunai:</div>
                    <input type="number" id="tunaiInput" min="1" value="0"
                        class="ml-auto text-right bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 block w-48 p-2.5" />
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-700">Total Harga:</div>
                    <div class="text-3xl font-bold text-gray-900">Rp <span id="grandTotal">0,00</span></div>
                    <input type="hidden" name="total_harga" id="totalHargaInput" value="0">
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-700">Kembalian:</div>
                    <div class="text-3xl font-bold text-gray-900">Rp <span id="kembalian">0,00</span></div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end mt-6 space-x-3">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 transition">
                    Simpan Pesanan
                </button>

                <a href="{{ route('pesanan.list') }}"
                    class="bg-red-600 text-white px-5 py-2 rounded-md focus:ring-1 focus:outline-none focus:ring-[#2ec4b6] focus:border-blue-500 hover:bg-red-700 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk menyimpan data terpilih
            let barangTerpilih = null;
            let pelangganTerpilih = null;
            let index = 0;

            // Referensi elemen
            const tunaiInput = document.getElementById('tunaiInput');
            const totalHargaHidden = document.getElementById('totalHargaInput');
            const kembalianSpan = document.getElementById('kembalian');
            const grandTotalSpan = document.getElementById('grandTotal');

            // Event listener untuk input tunai - hitung kembalian real-time
            tunaiInput.addEventListener('input', function() {
                hitungKembalian();
            });

            // Fungsi untuk menghitung kembalian
            function hitungKembalian() {
                const tunai = parseFloat(tunaiInput.value) || 0;
                const totalHarga = parseFloat(totalHargaHidden.value) || 0;
                const kembalian = tunai - totalHarga;

                // Update tampilan kembalian
                if (kembalian >= 0) {
                    kembalianSpan.textContent = formatRupiah(kembalian);
                    kembalianSpan.parentElement.style.color = ''; // Reset warna
                } else {
                    kembalianSpan.textContent = '-' + formatRupiah(Math.abs(kembalian));
                    kembalianSpan.parentElement.style.color = 'red'; // Warna merah jika kurang
                }
            }

            // Event delegation untuk tombol hapus (SATU KALI SAJA)
            const tbody = document.getElementById('daftarBarang');
            tbody.addEventListener('click', function(e) {
                if (e.target.matches('button') && e.target.textContent.trim() === 'Hapus') {
                    e.target.closest('tr').remove();
                    updateGrandTotal();
                }
            });

            // Tangkap event sekali untuk kedua autocomplete
            document.addEventListener('autocomplete-selected', function(e) {
                const {
                    field,
                    selected
                } = e.detail;
                // console.log('Field:', e.detail.field);
                // console.log('Selected:', e.detail.selected);

                if (field === 'barang') {
                    barangTerpilih = selected;
                    // console.log('Barang dipilih:', barangTerpilih);
                } else if (field === 'pelanggan') {
                    pelangganTerpilih = selected;
                    // console.log('Pelanggan dipilih:', pelangganTerpilih);
                    document.querySelector('input[name="id_pelanggan"]').value = pelangganTerpilih.id;
                }
            });

            // Tombol Tambah Barang
            const tambahBarangButton = document.getElementById('tambahBarang');
            tambahBarangButton.addEventListener('click', function() {
                const jumlahInput = document.getElementById('jumlahInput');
                const jumlah = parseInt(jumlahInput.value || 0);

                if (!barangTerpilih || jumlah < 1) {
                    alert('Pilih barang dan masukkan jumlah yang valid.');
                    return;
                }

                const {
                    id,
                    nama_barang: nama,
                    harga
                } = barangTerpilih;
                const total = harga * jumlah;

                const row = document.createElement('tr');
                row.innerHTML = `
            <td class="px-4 py-2">${nama}
                <input type="hidden" name="items[${index}][id_barang]" value="${id}">
            </td>
            <td class="px-4 py-2">${jumlah}
                <input type="hidden" name="items[${index}][jumlah]" value="${jumlah}">
            </td>
            <td class="px-4 py-2">Rp ${formatRupiah(harga)}</td>
            <td class="px-4 py-2">Rp ${formatRupiah(total)}
                <input type="hidden" class="item-total" value="${total}">
            </td>
            <td class="px-4 py-2">
                <button type="button" class="text-red-600 hover:text-red-800">
                    Hapus
                </button>
            </td>
        `;
                tbody.appendChild(row);

                index++;
                updateGrandTotal();

                // Reset barangTerpilih dan input pencarian
                barangTerpilih = null;
                jumlahInput.value = 1;
                const searchInput = document.querySelector('#autocomplete-barang input[type="text"]');
                if (searchInput) searchInput.value = '';
            });

            // TAMBAHAN: Form submit validation dan loading state
            const form = document.getElementById('pesananForm');
            const submitButton = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function(e) {
                // Validasi: pastikan ada minimal 1 item
                const items = document.querySelectorAll('input[name^="items["][name$="[id_barang]"]');

                if (items.length === 0) {
                    e.preventDefault();
                    alert('Tambahkan minimal 1 barang untuk melanjutkan pesanan.');
                    return false;
                }

                // Validasi: pastikan total harga > 0
                const totalHarga = parseFloat(document.getElementById('totalHargaInput').value);
                if (totalHarga <= 0) {
                    e.preventDefault();
                    alert('Total harga harus lebih dari 0.');
                    return false;
                }

                // Tampilkan loading state
                submitButton.disabled = true;
                submitButton.innerHTML = `
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
        <span>Menyimpan...</span>
    </div>
`;

                // Log data yang akan dikirim untuk debug
                // console.log('Form data being submitted:', new FormData(form));

                // Form akan submit secara normal
                return true;
            });

            // TAMBAHAN: Tampilkan error jika ada
            @if (session('error'))
                alert('Error: {{ session('error') }}');
            @endif

            @if (session('success'))
                alert('Success: {{ session('success') }}');
            @endif

            // TAMBAHAN: Tampilkan validation errors
            @if ($errors->any())
                let errorMessages = [];
                @foreach ($errors->all() as $error)
                    errorMessages.push('{{ $error }}');
                @endforeach
                alert('Validation Errors:\n' + errorMessages.join('\n'));
            @endif

            function updateGrandTotal() {
                const totalEls = document.querySelectorAll('.item-total');
                let grandTotal = 0;
                totalEls.forEach(el => grandTotal += parseFloat(el.value));
                document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
                document.getElementById('totalHargaInput').value = grandTotal;
            }

            function formatRupiah(angka) {
                return angka.toLocaleString('id-ID');
            }
        });
    </script>
</body>

</html>
