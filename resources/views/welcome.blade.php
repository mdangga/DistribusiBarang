<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">  
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <meta http-equiv="X-UA-Compatible" content="ie=edge">     
    @vite(['resources/css/app.css', 'resources/js/app.js'])     
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>     
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">     
    <title>test</title>  
</head>  
<body class="">     
    <x-autocomplete-input 
        name="pelanggan" 
        endpoint="{{ route('autocomplete.pelanggan')}}" 
        placeholder="Cari pelanggan..."         
        form-field="nama_pelanggan" 
        id-field="id" 
    />      
    
    {{-- <!-- Komponen Alpine -->     
    <div id="formDetail" x-data="formDetailHandler()">         
        <div>             
            <label>Kode Barang:</label>             
            <input type="text" x-model="form.kode_barang" class="border w-full">         
        </div>         
        <div>             
            <label>Harga:</label>             
            <input type="text" x-model="form.harga" class="border w-full">         
        </div>     
    </div>      
    
    <script>         
        document.addEventListener('alpine:init', () => {             
            Alpine.data('formDetailHandler', () => ({                 
                form: {                     
                    kode_barang: '',                     
                    harga: ''                 
                },                 
                init() {                     
                    this.$watch('form', (val) => console.log('Form updated:', val));                     
                    window.addEventListener('autocomplete-selected', (event) => {
                        const selected = event.detail.selected;
                        console.log('Selected item:', selected);
                        // Use the actual property names from your API response
                        this.form.kode_barang = selected.kode_barang || selected.id;
                        this.form.harga = selected.harga || ''; 
                    });                 
                }             
            }));         
        });     
    </script>   --}}
</body>  
</html>