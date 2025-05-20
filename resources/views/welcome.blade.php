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
    name="barang"
    endpoint="{{ route('autocomplete.barang') }}"
    placeholder="Cari barang..."
    form-field="nama_barang"
    id-field="id"
    :min-chars="1"
/>
</body>

</html>
