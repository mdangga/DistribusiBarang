<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Pembelian</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <input type="hidden" name="id_pesanan" value="{{ $emptyPesanan->id_pesanan }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Pelanggan</label>
                    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="">
                    <x-autocomplete-input name="pelanggan" endpoint="{{ route('autocomplete.pelanggan') }}"
                        placeholder="Cari pelanggan..." form-field="nama_pelanggan" id-field="id"
                        id="autocomplete-pelanggan" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input aria-label="disabled input 2" type="text" name="tanggal"
                        value="{{ old('tanggal', date('Y-m-d')) }}" readonly
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed ">
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" />
                </div>
                <div>
                    <button type="button" id="tambahBarang"
                        class="inline-flex items-center justify-center w-full bg-[#ff9f1c] text-white p-2 rounded-md hover:bg-[#ffa82f] transition text-center">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
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
            <div class="flex justify-end mt-4">
                <div class="text-right">
                    <div class="text-sm text-gray-700">Total Harga:</div>
                    <div class="text-3xl font-bold text-gray-900">Rp <span id="grandTotal">0,00</span></div>
                    <input type="hidden" name="total_harga" id="totalHargaInput" value="0">
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end mt-6 space-x-3">
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-500 transition">
                    Simpan Pesanan
                </button>

                <a href="{{ route('pesanan.list') }}"
                    class="bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-500">
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

            // Tangkap event sekali untuk kedua autocomplete
            document.addEventListener('autocomplete-selected', function(e) {
                const {
                    field,
                    selected
                } = e.detail;
                console.log('Field:', e.detail.field);
                console.log('Selected:', e.detail.selected);
                if (field === 'barang') {
                    // Kalau yang dipilih berasal dari autocomplete barang
                    barangTerpilih = selected;
                    console.log('Barang dipilih:', barangTerpilih);

                } else if (field === 'pelanggan') {
                    // Kalau yang dipilih berasal dari autocomplete pelanggan
                    pelangganTerpilih = selected;
                    console.log('Pelanggan dipilih:', pelangganTerpilih);

                    // Update input hidden id_pelanggan
                    console.log(pelangganTerpilih.id)
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

                const tbody = document.getElementById('daftarBarang');
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
                <button type="button"
                    class="text-red-600 hover:text-red-800"
                    >
                    Hapus
                </button>
            </td>
        `;
                tbody.appendChild(row);

                tbody.addEventListener('click', function(e) {
                    if (e.target.matches('button') && e.target.textContent.trim() === 'Hapus') {
                        e.target.closest('tr').remove();
                        updateGrandTotal();
                    }
                });
                
                index++;
                updateGrandTotal();

                // Reset barangTerpilih dan input pencarian
                barangTerpilih = null;
                jumlahInput.value = 1;
                const searchInput = document.querySelector('#autocomplete-barang input[type="text"]');
                if (searchInput) searchInput.value = '';
            });

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
