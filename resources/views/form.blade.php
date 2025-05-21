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
                    <input type="text" name="id_pelanggan"
                        value="{{ old('id_pelanggan', $emptyPesanan->id_pelanggan) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="text" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                </div>
            </div>

            <!-- Input Barang -->
            <div class="grid grid-cols-3 gap-4 items-end mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang</label>
                    <select id="barangSelect"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->id_barang }}" data-nama="{{ $b->nama_barang }}"
                                data-harga="{{ $b->harga }}">
                                {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlahInput" min="1" value="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" />
                </div>
                <div>
                    <button type="button" id="tambahBarang"
                        class="w-full bg-[#ff9f1c] text-white p-2 rounded-md hover:bg-[#ffa82f] transition">+
                        Tambah</button>
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
        let index = 0;

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                minimumFractionDigits: 2
            }).format(number);
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-total').forEach(item => {
                total += parseFloat(item.value) || 0;
            });
            document.getElementById('grandTotal').textContent = formatRupiah(total);
            document.getElementById('totalHargaInput').value = total;
        }

        document.getElementById('tambahBarang').addEventListener('click', function() {

            const select = document.getElementById('barangSelect');
            const jumlahInput = document.getElementById('jumlahInput');

            const id = select.value;
            const nama = select.options[select.selectedIndex]?.dataset?.nama || '';
            const harga = parseFloat(select.options[select.selectedIndex]?.dataset?.harga || 0);
            const jumlah = parseInt(jumlahInput.value || 0);

            if (!id || jumlah < 1) {
                alert('Pilih barang dan masukkan jumlah yang valid.');
                return;
            }

            const total = harga * jumlah;
            const tbody = document.getElementById('daftarBarang');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${nama}<input type="hidden" name="items[${index}][id_barang]" value="${id}"></td>
                <td class="px-4 py-2">${jumlah}<input type="hidden" name="items[${index}][jumlah]" value="${jumlah}"></td>
                <td class="px-4 py-2">Rp ${formatRupiah(harga)}</td>
                <td class="px-4 py-2">Rp ${formatRupiah(total)}<input type="hidden" class="item-total" value="${total}"></td>
                <td class="px-4 py-2">
                    <button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('tr').remove(); updateGrandTotal();"><svg class="w-5 h-5 overflow-visible transition duration-75 "
            width="24" height="24" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg" width="448" height="512" viewBox="0 0 448 512"><path fill="currentColor" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0h120.4c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64s14.3-32 32-32h96zM32 128h384v320c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64zm96 64c-8.8 0-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16m96 0c-8.8 0-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16m96 0c-8.8 0-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16"/></svg></button>
                </td>
            `;
            tbody.appendChild(row);

            index++;
            updateGrandTotal();

            // Reset input
            select.selectedIndex = 0;
            jumlahInput.value = 1;
        });
    </script>
</body>

</html>
