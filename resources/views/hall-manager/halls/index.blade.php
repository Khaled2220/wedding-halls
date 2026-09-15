<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Halls - Hall Manager</title>

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
                    Hall Manager
                </p>

            </div>

            <div class="flex flex-wrap items-center gap-3">

                <a
                    href="{{ route('hall-manager.halls.index') }}"
                    class="bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold hover:bg-blue-50 transition"
                >
                    My Halls
                </a>

                <a
                href="{{ route('hall-manager.reservations.index') }}"class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                Reservations
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


<main class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h2 class="text-3xl font-bold text-gray-800">
                My Halls
            </h2>

            <p class="text-gray-500 mt-2">
                Manage your wedding halls
            </p>

        </div>


        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('hall-manager.halls.create') }}"
                class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow"
            >
                🏛️ + Add New Hall
            </a>

        </div>

    </div>


    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl">

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    @if($halls->count() > 0)

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($halls as $hall)

                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition">

                    <div class="p-6">

                        <h3 class="mb-3">

                            <a
                                href="{{ route('hall-manager.halls.show', $hall) }}"
                                class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition"
                            >
                                {{ $hall->name }}
                            </a>

                        </h3>


                        @if($hall->description)

                            <p class="text-gray-600 mb-5 line-clamp-3">
                                {{ $hall->description }}
                            </p>

                        @endif


                        <div class="flex items-start gap-2 mb-3">

                            <span class="text-blue-600">
                                📍
                            </span>

                            <span class="text-gray-700">
                                {{ $hall->address }}
                            </span>

                        </div>


                        @if($hall->phone)

                            <div class="flex items-center gap-2 mb-3">

                                <span class="text-blue-600">
                                    📞
                                </span>

                                <span class="text-gray-700">
                                    {{ $hall->phone }}
                                </span>

                            </div>

                        @endif


                        <div class="flex items-center gap-2 mb-3">

                            <span class="text-blue-600">
                                💰
                            </span>

                            <span class="text-gray-700 font-semibold">
                                {{ number_format($hall->price, 2) }} JOD
                            </span>

                        </div>


                        @if($hall->capacity)

                            <div class="flex items-center gap-2 mb-4">

                                <span class="text-blue-600">
                                    👥
                                </span>

                                <span class="text-gray-700">
                                    Capacity: {{ $hall->capacity }}
                                </span>

                            </div>

                        @endif


                        @if($hall->food)

                            <div class="mb-2">

                                <span class="font-semibold text-gray-700">
                                    Old Food:
                                </span>

                                <span class="text-gray-600">
                                    {{ ucfirst(str_replace('_', ' ', $hall->food)) }}
                                </span>

                            </div>

                        @endif


                        @if($hall->sweets)

                            <div class="mb-4">

                                <span class="font-semibold text-gray-700">
                                    Old Sweets:
                                </span>

                                <span class="text-gray-600">
                                    {{ ucfirst(str_replace('_', ' ', $hall->sweets)) }}
                                </span>

                            </div>

                        @endif


                        <div class="mb-5">

                            @if($hall->status === 'active')

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                    Active
                                </span>

                            @else

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                    Inactive
                                </span>

                            @endif

                        </div>


                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">

                            <a
                                href="{{ route('hall-manager.halls.show', $hall) }}"
                                class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
                            >
                                View
                            </a>


                            <a
                                href="{{ route('hall-manager.halls.edit', $hall) }}"
                                class="flex-1 text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
                            >
                                Edit
                            </a>


                            <form
                                method="POST"
                                action="{{ route('hall-manager.halls.destroy', $hall) }}"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to delete this hall?');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full bg-red-100 text-red-700 px-4 py-2 rounded-lg font-semibold hover:bg-red-200 transition"
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

        <div class="bg-white rounded-2xl shadow-md p-12 text-center">

            <div class="text-6xl mb-5">
                🏛️
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-3">
                No Halls Yet
            </h3>

            <p class="text-gray-500 mb-6">
                You haven't added any wedding halls yet.
            </p>

            <a
                href="{{ route('hall-manager.halls.create') }}"
                class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition"
            >
                + Add Your First Hall
            </a>

        </div>

    @endif

</main>

</body>
</html>




<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div>
