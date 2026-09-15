<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Food - Hall Manager</title>

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


<main class="max-w-3xl mx-auto px-6 py-10">

    <!-- Page Header -->

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-gray-800">
            🍽️ Edit Food
        </h2>

        <p class="text-gray-500 mt-2">
            Update the food price or add new images.
        </p>

    </div>


    <!-- Validation Errors -->

    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300
                    text-red-800 px-5 py-4 rounded-xl">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Success Message -->

    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300
                    text-green-800 px-5 py-4 rounded-xl">

            {{ session('success') }}

        </div>

    @endif


    <!-- Edit Food Form -->

    <div class="bg-white rounded-2xl shadow-md p-8">

        <form
            method="POST"
            action="{{ route('hall-manager.foods.update', $food) }}"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            <!-- Hall -->

            @if($food->hall)

                <div class="mb-6">

                    <label
                        for="hall"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Hall
                    </label>

                    <input
                        type="text"
                        id="hall"
                        value="{{ $food->hall->name }}"
                        disabled
                        class="w-full px-4 py-3 rounded-lg border border-gray-300
                               bg-gray-100 text-gray-600"
                    >

                    <p class="text-sm text-gray-500 mt-2">
                        This food belongs to this hall. The hall cannot be changed.
                    </p>

                </div>

            @endif


            <!-- Price -->

            <div class="mb-6">

                <label
                    for="price"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Price (JOD)
                </label>

                <input
                    type="number"
                    name="price"
                    id="price"
                    value="{{ old('price', $food->price) }}"
                    step="0.01"
                    min="0"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('price')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Current Images -->

            @if($food->images->count() > 0)

                <div class="mb-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Current Images
                    </label>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                        @foreach($food->images as $image)

                            <div class="border rounded-xl overflow-hidden bg-gray-50">

                                <img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="Food image"
                                    class="w-full h-40 object-cover"
                                >

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            <!-- Add New Images -->

            <div class="mb-8">

                <label
                    for="images"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Add More Images
                </label>

                <input
                    type="file"
                    name="images[]"
                    id="images"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300
                           bg-white"
                >

                <p class="text-sm text-gray-500 mt-2">
                    Allowed: JPG, JPEG, PNG, WEBP. Maximum 5MB per image.
                </p>

                @error('images')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

                @error('images.*')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Buttons -->

            <div class="flex flex-col sm:flex-row gap-3">

                <button
                    type="submit"
                    class="flex-1 bg-blue-600 text-white px-6 py-3
                           rounded-xl font-semibold
                           hover:bg-blue-700 transition"
                >
                    💾 Update Food
                </button>


                <a
                    href="{{ route('hall-manager.foods.index') }}"
                    class="flex-1 text-center bg-gray-100 text-gray-700
                           px-6 py-3 rounded-xl font-semibold
                           hover:bg-gray-200 transition"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</main>

</body>

</html>





<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
</div>
