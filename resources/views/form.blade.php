<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pesanan - Materialin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: none;
        }
        .logo {
            color: #e67e22;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .logo-icon {
            color: #e67e22;
            font-size: 24px;
            margin-right: 5px;
        }
        .total-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }
        .btn-simpan {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }
        .btn-batal {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .btn-tambah {
            background-color: #2ecc71;
            border-color: #2ecc71;
            float: right;
        }
        .table thead {
            background-color: #fff3e0;
        }
        .input-no-border {
            border: none;
            background-color: transparent;
            width: 100%;
        }
        .input-no-border:focus {
            outline: none;
            background-color: #f8f9fa;
        }
        .table-items {
            border-collapse: collapse;
        }
        .table-items td {
            padding: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <div class="logo">
                    <i class="bi bi-grid-3x3-gap-fill logo-icon"></i> Materialin
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <form id="pesananForm" action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                    
                    <!-- Input hidden untuk ID pesanan kosong yang akan diisi -->
                    <input type="hidden" name="id_pesanan" value="{{ $emptyPesanan->id_pesanan }}">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                                <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" 
                                    value="{{ old('id_pelanggan', $emptyPesanan->id_pelanggan) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                    value="{{ old('tanggal', date('Y-m-d')) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_harga" class="form-label">Total Pesanan</label>
                                <div class="total-box">
                                    <span>Rp</span> <span id="totalDisplay">0,00</span>
                                    <input type="hidden" id="total_harga" name="total_harga" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="id_karyawan" class="form-label">ID Karyawan</label>
                                <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" 
                                    value="{{ old('id_karyawan', $emptyPesanan->id_karyawan) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <input type="text" class="form-control" id="catatan" name="catatan">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 d-flex justify-content-end" style="margin-top: 32px;">
                                <button type="submit" class="btn btn-simpan text-white me-2">
                                    <i class="bi bi-check"></i> Simpan
                                </button>
                                <a href="{{ route('pesanan.list') }}" class="btn btn-batal text-white">
                                    <i class="bi bi-x"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <table class="table table-bordered table-items">
                                <thead>
                                    <tr>
                                        <th width="35%">Nama Barang</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="25%">Harga</th>
                                        <th width="25%">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="itemRows">
                                    <tr class="item-row">
                                        <td>
                                            <select class="form-select input-no-border barang-select" name="items[0][id_barang]" required>
                                                <option value="">-- Pilih Barang --</option>
                                                @foreach($barang as $b)
                                                    <option value="{{ $b->id_barang }}" data-harga="{{ $b->harga }}">
                                                        {{ $b->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="input-no-border item-qty" name="items[0][jumlah]" value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="text" class="input-no-border item-price" name="items[0][harga]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="input-no-border item-total" readonly>
                                            <button type="button" class="btn btn-sm btn-danger delete-row float-end d-none">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <button type="button" id="addRow" class="btn btn-tambah text-white mt-2">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format number to currency
            function formatCurrency(number) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(number);
            }
            
            // Calculate row total
            function calculateRowTotal(row) {
                const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value.replace(/\./g, '').replace(',', '.')) || 0;
                const total = qty * price;
                
                row.querySelector('.item-total').value = formatCurrency(total);
                return total;
            }
            
            // Calculate grand total
            function calculateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.item-row').forEach(row => {
                    grandTotal += calculateRowTotal(row);
                });
                
                document.getElementById('totalDisplay').textContent = formatCurrency(grandTotal);
                document.getElementById('total_harga').value = grandTotal;
            }
            
            // Update price when product selected
            function updatePrice(row) {
                const select = row.querySelector('.barang-select');
                const priceInput = row.querySelector('.item-price');
                
                if (select.selectedIndex > 0) {
                    const option = select.options[select.selectedIndex];
                    const price = option.getAttribute('data-harga');
                    priceInput.value = formatCurrency(price);
                    calculateRowTotal(row);
                    calculateGrandTotal();
                } else {
                    priceInput.value = '';
                    row.querySelector('.item-total').value = '';
                    calculateGrandTotal();
                }
            }
            
            // Add new row event
            document.getElementById('addRow').addEventListener('click', function() {
                const tbody = document.getElementById('itemRows');
                const rowCount = tbody.querySelectorAll('.item-row').length;
                const lastRow = tbody.querySelector('.item-row:last-child');
                const newRow = lastRow.cloneNode(true);
                
                // Reset fields
                const newSelect = newRow.querySelector('.barang-select');
                newSelect.selectedIndex = 0;
                newSelect.name = `items[${rowCount}][id_barang]`;
                
                const newQty = newRow.querySelector('.item-qty');
                newQty.value = 1;
                newQty.name = `items[${rowCount}][jumlah]`;
                
                newRow.querySelector('.item-price').value = '';
                newRow.querySelector('.item-total').value = '';
                
                // Show delete button
                newRow.querySelector('.delete-row').classList.remove('d-none');
                
                // Add event listeners
                newSelect.addEventListener('change', function() {
                    updatePrice(newRow);
                });
                
                newQty.addEventListener('input', function() {
                    calculateRowTotal(newRow);
                    calculateGrandTotal();
                });
                
                newRow.querySelector('.delete-row').addEventListener('click', function() {
                    if (tbody.querySelectorAll('.item-row').length > 1) {
                        newRow.remove();
                        calculateGrandTotal();
                    }
                });
                
                tbody.appendChild(newRow);
            });
            
            // Initial setup of event listeners for the first row
            document.querySelectorAll('.item-row').forEach(row => {
                row.querySelector('.barang-select').addEventListener('change', function() {
                    updatePrice(row);
                });
                
                row.querySelector('.item-qty').addEventListener('input', function() {
                    calculateRowTotal(row);
                    calculateGrandTotal();
                });
            });
            
            // Form submit handler
            document.getElementById('pesananForm').addEventListener('submit', function(e) {
                // Validate at least one item with product selected
                let hasItems = false;
                document.querySelectorAll('.barang-select').forEach(select => {
                    if (select.value) hasItems = true;
                });
                
                if (!hasItems) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu barang!');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>