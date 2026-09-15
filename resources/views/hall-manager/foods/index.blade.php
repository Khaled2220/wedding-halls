<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Foods</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto py-10 px-4">

    {{-- Header --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                🍽️ My Foods
            </h1>

            <p class="text-gray-500 mt-2">
                Manage the foods available in your halls.
            </p>

        </div>


        <div class="flex gap-3">

            <a
                href="{{ route('hall-manager.halls.index') }}"
                class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 font-semibold transition">
                ← Halls
            </a>

            <a
                href="{{ route('hall-manager.foods.create') }}"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition"
            >
                + Add Food
            </a>

        </div>

    </div>


    {{-- Success Message --}}

    @if (session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 rounded-lg p-4">

            {{ session('success') }}

        </div>

    @endif


    {{-- Foods --}}

    @if ($foods->count())

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($foods as $food)

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">


                    {{-- Image --}}

                    @if ($food->images->count())

                        <img
                            src="{{ asset('storage/' . $food->images->first()->image_path) }}"
                            alt="Food image"
                            class="w-full h-56 object-cover"
                        >

                    @else

                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center">

                            <span class="text-6xl">
                                🍽️
                            </span>

                        </div>

                    @endif


                    {{-- Content --}}

                    <div class="p-6">


                        {{-- Hall --}}

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-4">

                            <p class="text-sm text-gray-500">
                                Hall
                            </p>

                            <p class="text-lg font-bold text-blue-600">
                                🏛️ {{ $food->hall->name }}
                            </p>

                        </div>


                        {{-- Price --}}

                        <div class="mb-4">

                            <p class="text-sm text-gray-500">
                                Price
                            </p>

                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($food->price, 2) }} JOD
                            </p>

                        </div>


                        {{-- Number of Images --}}

                        <p class="text-sm text-gray-500 mb-5">
                            📸 {{ $food->images->count() }} image(s)
                        </p>


                        {{-- Actions --}}

                        <div class="flex gap-2">

                            {{-- View --}}

                            <a
                                href="{{ route('hall-manager.foods.show', $food) }}"
                                class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition"
                            >
                                View
                            </a>


                            {{-- Edit --}}

                            <a
                                href="{{ route('hall-manager.foods.edit', $food) }}"
                                class="flex-1 text-center bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg font-semibold transition"
                            >
                                Edit
                            </a>


                            {{-- Delete --}}

                            <form
                                method="POST"
                                action="{{ route('hall-manager.foods.destroy', $food) }}"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to delete this food?');"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold transition"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


    @else

        {{-- Empty State --}}

        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">

            <div class="text-7xl mb-5">
                🍽️
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                No Foods Yet
            </h2>

            <p class="text-gray-500 mt-2">
                You haven't added any food items yet.
            </p>

            <a
                href="{{ route('hall-manager.foods.create') }}"
                class="inline-block mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition"
            >
                + Add Your First Food
            </a>

        </div>

    @endif

</div>

</body>

</html>




<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
</div>
