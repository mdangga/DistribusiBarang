<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <title>Sign In</title>
</head>

<body class="h-full flex items-center justify-center bg-cover bg-center"
    style="background-image: url('img/bg-signin.jpg')">
    {{-- gradient HITAM --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-0"></div>

    <div class="absolute z-10 bg-white shadow-lg rounded-lg overflow-hidden h-auto w-3/4 max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Image section -->
            <div class="hidden lg:block">
                <img src="img/login-img.svg" alt="illustration"
                    class="h-auto m-auto object-cover scale-x-[-1] cursor-not-allowed" draggable="false">
            </div>

            <!-- Form section -->
            <div class="p-10 h-auto my-auto">
                {{-- hello text --}}
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-semibold text-black">Welcome Back!</h1>
                </div>

                {{-- awal pesan --}}
                @if (session('gagal'))
                    <div id="alert-gagal"
                        class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50"
                        role="alert">
                        <div class="ms-3 text-sm font-normal" role="alert">
                            <span class="font-medium">Peringatan!</span> {{ session('gagal') }}
                        </div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                            data-dismiss-target="#alert-gagal" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('logout'))
                    <div id="alert-logout"
                        class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <div class="ms-3 text-sm font-normal" role="alert">
                            <span class="font-medium">Sukses! </span> {{ session('logout') }}
                        </div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                            data-dismiss-target="#alert-logout" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif
                {{-- akhir pesan --}}

                <form class="" action="{{ route('signin.submit') }}" method="POST">
                    @csrf
                    {{-- input email --}}
                    <x-form type="email" name="email">Email</x-form>
                    {{-- input password --}}
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                            <div class="text-sm">
                                <a href="#" class="font-semibold text-[#ff9f1c] hover:text-[#ffbf69]">Lupa
                                    password?</a>
                            </div>
                        </div>

                        <x-form type="password" name="password"></x-form>
                    </div>

                    {{-- submit button --}}
                    <div class="place-items-end">
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-[#ff9f1c] px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-[#ffbf69] hover:text-black transition duration-150 ease-in">Sign
                            In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
