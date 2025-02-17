<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Sign Up</title>
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img class="mx-auto h-10 w-auto" src="img/logo.png" alt="Your Company">
          <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign Up to your account</h2>
        </div>
      
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          <form class="space-y-6" action="{{ route('signup.submit') }}" method="POST">
            @csrf
            <x-form type="text" name="username">Username</x-form>
            <x-form type="email" name="email">Email</x-form>
            <x-form type="password" name="password">Password</x-form>
            <x-form type="text" name="nama_user">Nama</x-form>
            <div class="grid md:grid-cols-2 md:gap-6">
              <x-form type="tel" name="no_telpon">Phone number</x-form>
              <x-form type="text" name="nama_perusahaan">Nama Perusahaan</x-form>
            </div>
            <x-form type="text" name="alamat">alamat</x-form>

            <div>
              <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-150 ease-in">Sign Up</button>
            </div>
          </form>
      
          <p class="mt-10 text-center text-sm/6 text-gray-500">
            Already have an account?
            <a href="/" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign In!</a>
          </p>
        </div>
      </div>
</body>
</html>