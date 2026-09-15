<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Forgot Password - Wedding Halls</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="min-h-screen bg-white">

<div class="min-h-screen flex items-center justify-center px-6 py-10">


<div class="w-full max-w-2xl">

    <!-- Logo / Brand -->
    <div class="text-center mb-8">

        <div class="flex justify-center mb-3">
            <div class="relative">

                <div class="w-32 h-24 border-4 border-blue-700 rounded-t-[70px] relative flex items-end justify-center">

                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2
                                w-16 h-16
                                bg-gradient-to-r from-blue-500 to-blue-800
                                rounded-t-full">
                    </div>

                    <div class="absolute bottom-5 left-1/2 -translate-x-1/2
                                flex gap-1 text-white text-2xl">
                        ♡
                    </div>

                </div>

            </div>
        </div>

        <h1 class="text-4xl md:text-5xl font-serif font-bold tracking-[0.15em]
                   text-blue-800">
            WEDDING HALLS
        </h1>

        <div class="flex items-center justify-center gap-3 mt-2">

            <span class="h-px w-16 bg-blue-300"></span>

            <span class="text-blue-600 text-sm font-medium">
                Make Your Special Day Perfect
            </span>

            <span class="h-px w-16 bg-blue-300"></span>

        </div>

    </div>


    <!-- Forgot Password Card -->
    <div class="bg-gradient-to-br from-blue-800 via-blue-700 to-blue-900
                rounded-[28px]
                shadow-2xl
                px-7 py-9 md:px-12 md:py-10">

        <!-- Card Header -->
        <div class="text-center text-white mb-8">

            <div class="flex items-center justify-center gap-3 mb-4">

                <span class="h-px w-20 bg-blue-300"></span>

                <span class="text-xl">
                    ♡
                </span>

                <span class="h-px w-20 bg-blue-300"></span>

            </div>

            <h2 class="text-3xl md:text-4xl font-bold">
                Forgot Password?
            </h2>

            <p class="mt-2 text-lg text-blue-100">
                No problem. Enter your email address and we will send you a password reset link.
            </p>

        </div>


        <!-- Session Status -->
        @if (session('status'))

            <div class="mb-5 rounded-xl bg-blue-600/50
                        px-5 py-4 text-center
                        text-white text-sm">

                {{ session('status') }}

            </div>

        @endif


        <!-- Forgot Password Form -->
        <form method="POST"
              action="{{ route('password.email') }}"
              class="space-y-4">

            @csrf


            <!-- Email -->
            <div class="relative">

                <span class="absolute left-6 top-1/2 -translate-y-1/2
                             text-blue-600 text-2xl">
                </span>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="Email Address"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           pl-16 pr-5
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300"
                >

            </div>


            @error('email')

                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>

            @enderror


            <!-- Send Button -->
            <button
                type="submit"
                class="w-full h-16
                       mt-3
                       rounded-xl
                       bg-blue-400
                       hover:bg-blue-300
                       text-white
                       font-bold
                       text-lg
                       tracking-[0.08em]
                       transition
                       duration-200
                       shadow-lg
                       flex items-center justify-center gap-5"
            >

                <span>
                    SEND RESET LINK
                </span>

                <span class="text-3xl">
                    →
                </span>

            </button>

        </form>


        <!-- Bottom -->
        <div class="mt-7 text-center">

            <div class="flex items-center justify-center gap-4 mb-6">

                <span class="h-px w-28 bg-blue-300"></span>

                <span class="text-white text-xl">
                    ♡
                </span>

                <span class="h-px w-28 bg-blue-300"></span>

            </div>


            <p class="text-white text-lg">

                Remember your password?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-blue-200 hover:text-white transition"
                >
                    Login
                </a>

            </p>

        </div>

    </div>

</div>


</div>

</body>
</html>
