<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Register - Wedding Halls</title>

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


    <!-- Register Card -->
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
                Create Your Account
            </h2>

            <p class="mt-2 text-lg text-blue-100">
                Join us and start planning your perfect wedding
            </p>

        </div>


        <!-- Register Form -->
        <form method="POST"
              action="{{ route('register') }}"
              class="space-y-4">

            @csrf


            <!-- Full Name -->
            <div class="relative">

                <input
                    id="fullname"
                    name="fullname"
                    type="text"
                    value="{{ old('fullname') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           px-5
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300"
                >

            </div>

            @error('fullname')
                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>
            @enderror


            <!-- Email -->
            <div class="relative">

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="Email Address"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           px-5
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


            <!-- Phone Number -->
            <div class="relative">

                <input
                    id="phone_number"
                    name="phone_number"
                    type="tel"
                    value="{{ old('phone_number') }}"
                    required
                    autocomplete="tel"
                    placeholder="Phone Number"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           px-5
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300"
                >

            </div>

            @error('phone_number')
                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>
            @enderror


            <!-- Address -->
            <div class="relative">

                <textarea
                    id="address"
                    name="address"
                    required
                    autocomplete="street-address"
                    placeholder="Address"
                    rows="3"
                    class="w-full
                           rounded-xl
                           border-0
                           bg-white
                           px-5 py-4
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300
                           resize-none"
                >{{ old('address') }}</textarea>

            </div>

            @error('address')
                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>
            @enderror


            <!-- Password -->
            <div class="relative">

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           px-5
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300"
                >

            </div>

            @error('password')
                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>
            @enderror


            <!-- Confirm Password -->
            <div class="relative">

                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                    class="w-full h-16
                           rounded-xl
                           border-0
                           bg-white
                           px-5
                           text-lg
                           text-gray-700
                           placeholder-gray-400
                           shadow-sm
                           focus:ring-4
                           focus:ring-blue-300"
                >

            </div>


            @error('password_confirmation')
                <p class="text-red-200 text-sm px-2">
                    {{ $message }}
                </p>
            @enderror


            <!-- Register Button -->
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
                       tracking-[0.15em]
                       transition
                       duration-200
                       shadow-lg
                       flex items-center justify-center gap-5"
            >

                <span>REGISTER</span>

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

                Already have an account?

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
