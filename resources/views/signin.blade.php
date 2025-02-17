<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Sign In</title>
</head>
<body class="h-full">

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="img/logo.png" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  
  
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="{{ route('signin.submit') }}" method="POST">
      @csrf
      <x-form type="text" name="username">Username</x-form>
      <x-form type="password" name="password">Password</x-form>

    @if (session('gagal'))
        <p class="mt-10 text-center text-sm/6 text-red-500">
          {{ session('gagal') }}
        </p>
    @endif
    
    <div class="flex justify-end mt-2">
        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Forgot Password?</a>
    </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-150 ease-in">Sign In</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Don't have an account?
      <a href="/signup" class="font-semibold text-indigo-600 hover:text-indigo-500 ">Sign Up!</a>
    </p>
  </div>
</div>
@if (session('success'))
<div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-green-100 rounded-lg shadow-sm " role="alert">
  <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
      </svg>
      <span class="sr-only">Check icon</span>
  </div>
  <div class="ms-3 text-sm font-normal">Sign Up Successfull! Please Sign In.</div>
  <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-100 text-gray-400 hover:text-green-100 rounded-2xl focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-green-800 inline-flex items-center justify-center h-8 w-8 " data-dismiss-target="#toast-success" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
  </button>
</div>
@endif
</body>
</html>