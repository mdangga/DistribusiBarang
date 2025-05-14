<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    <title>Sign In</title>
</head>

<body class="h-full flex items-center justify-center bg-cover bg-center"
    style="background-image: url('img/bg-signin.jpg')">

    {{-- gradint HITAM --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-0"></div>

    <div class="absolute z-10 bg-white shadow-lg rounded-lg overflow-hidden h-auto w-3/4 max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Image section -->
            <div class="hidden lg:block">
                <img src="img/login-img.svg" alt="illustration" class="h-auto m-auto object-cover scale-x-[-1]">
            </div>

            <!-- Form section -->
            <div class="p-10 h-auto my-auto">
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-semibold text-black">Welcome Back!</h1>
                </div>

                <form class="" action="{{ route('signin.submit') }}" method="POST">
                    @csrf
                    <x-form type="email" name="email">Email</x-form>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                            <div class="text-sm">
                                <a href="#" class="font-semibold text-[#ff9f1c] hover:text-[#ffbf69]">Forgot
                                    password?</a>
                            </div>
                        </div>
                        <x-form type="password" name="password"></x-form>
                    </div>

                    @if (session('gagal'))
                        <p class="mt-10 text-center text-sm/6 text-red-500">
                            {{ session('gagal') }}
                        </p>
                    @endif

                    <div class="place-items-end">
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-[#ff9f1c] px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-[#ffbf69] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-150 ease-in">Sign
                            In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
