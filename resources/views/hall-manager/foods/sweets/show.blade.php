<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Sweet Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

<header class="bg-blue-700 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold">
                    WEDDING HALLS
                </h1>

                <p class="text-blue-100 mt-1">
                    Sweet Details
                </p>
            </div>

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('hall-manager.sweets.index') }}"
                    class="bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold hover:bg-blue-50 transition"
                >
                    All Sweets
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="bg-blue-900 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-950 transition"
                    >
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</header>


<main class="max-w-5xl mx-auto px-6 py-10">

    <div class="mb-6">

        <a
            href="{{ route('hall-manager.sweets.index') }}"
            class="text-blue-600 hover:text-blue-800 font-semibold"
        >
            ← Back to Sweets
        </a>

    </div>


    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <!-- SWEET IMAGES -->

        @if($sweet->images->isNotEmpty())

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">

                @foreach($sweet->images as $image)

                    <div class="rounded-2xl overflow-hidden">

                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            alt="Sweet"
                            class="w-full h-80 object-cover"
                        >

                    </div>

                @endforeach

            </div>

        @else

            <div class="h-80 bg-gray-200 flex items-center justify-center">

                <span class="text-7xl">
                    🍰
                </span>

            </div>

        @endif


        <!-- SWEET INFORMATION -->

        <div class="p-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">
                Sweet #{{ $sweet->id }}
            </h2>


            <!-- Hall -->

            <div class="border border-gray-200 rounded-xl p-5 mb-5">

                <p class="text-sm text-gray-500 mb-2">
                    Hall
                </p>

                @if($sweet->hall)

                    <p class="text-xl font-bold text-gray-800">
                        {{ $sweet->hall->name }}
                    </p>

                @else

                    <p class="text-red-500 font-semibold">
                        No hall assigned
                    </p>

                @endif

            </div>


            <!-- Price -->

            <div class="border border-gray-200 rounded-xl p-5">

                <p class="text-sm text-gray-500 mb-2">
                    Price
                </p>

                <p class="text-2xl font-bold text-pink-600">
                    {{ number_format($sweet->price, 2) }} JOD
                </p>

            </div>


            <!-- Actions -->

            <div class="mt-8 flex flex-wrap gap-3">

                <a
                    href="{{ route('hall-manager.sweets.edit', $sweet) }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition"
                >
                    ✏️ Edit Sweet
                </a>

                <a
                    href="{{ route('hall-manager.sweets.index') }}"
                    class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition"
                >
                    ← Back
                </a>

            </div>

        </div>

    </div>

</main>

</body>

</html>

<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie -->
</div>
