<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Hall - Wedding Halls</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200">

        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    WEDDING HALLS
                </h1>

            </div>

            <div class="text-gray-600 font-medium">
                Hall Manager
            </div>

        </div>

    </header>


    <!-- Main -->
    <main class="max-w-5xl mx-auto px-6 py-10">

        <!-- Back -->
        <div class="mb-6">

            <a
                href="{{ route('hall-manager.halls.index') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium"
            >
                ← My Halls
            </a>

        </div>


        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

            <!-- Title -->
            <div class="mb-8">

                <h2 class="text-3xl font-bold text-gray-900">
                    Create Hall
                </h2>

                <p class="mt-2 text-gray-500">
                    Add a new wedding hall and its details.
                </p>

            </div>


            <!-- Errors -->
            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <h3 class="font-semibold text-red-700 mb-2">
                        Please fix the following errors:
                    </h3>

                    <ul class="list-disc list-inside text-sm text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- Form -->
            <form
                method="POST"
                action="{{ route('hall-manager.halls.store') }}"
                enctype="multipart/form-data"
                class="space-y-8"
            >

                @csrf


                <!-- ========================= -->
                <!-- HALL INFORMATION -->
                <!-- ========================= -->

                <div>

                    <h3 class="text-xl font-bold text-gray-900 mb-5">
                        🏛️ Hall Information
                    </h3>


                    <!-- Name -->
                    <div class="mb-6">

                        <label
                            for="name"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Hall Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Example: Royal Wedding Hall"
                            required
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >

                        @error('name')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- Description -->
                    <div class="mb-6">

                        <label
                            for="description"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Describe your wedding hall..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >{{ old('description') }}</textarea>

                        @error('description')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                <!-- ========================= -->
                <!-- CONTACT INFORMATION -->
                <!-- ========================= -->

                <div class="border border-gray-200 rounded-2xl p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-5">
                        📞 Contact Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <!-- Address -->
                        <div>

                            <label
                                for="address"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Address
                            </label>

                            <input
                                type="text"
                                id="address"
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="Example: Irbid, Jordan"
                                required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >

                            @error('address')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- Phone -->
                        <div>

                            <label
                                for="phone"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Phone
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Example: 0790000000"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >

                            @error('phone')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- PRICE & CAPACITY -->
                <!-- ========================= -->

                <div class="border border-green-200 bg-green-50 rounded-2xl p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-5">
                        💰 Hall Pricing & Capacity
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <!-- Price -->
                        <div>

                            <label
                                for="price"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Hall Price (JD)
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                min="0"
                                step="0.01"
                                placeholder="Example: 2000"
                                required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            >

                            @error('price')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- Capacity -->
                        <div>

                            <label
                                for="capacity"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Capacity
                            </label>

                            <input
                                type="number"
                                id="capacity"
                                name="capacity"
                                value="{{ old('capacity') }}"
                                min="1"
                                placeholder="Example: 500"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            >

                            @error('capacity')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- FOOD & SWEETS -->
                <!-- ========================= -->

                <div class="border border-yellow-200 bg-yellow-50 rounded-2xl p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        🍽️ Food & Sweets
                    </h3>

                    <p class="text-sm text-gray-600 mb-6">
                        You can optionally add food and sweets for this hall.
                    </p>


                    <!-- Food -->
                    <div class="border border-gray-200 bg-white rounded-xl p-5 mb-6">

                        <h4 class="text-lg font-bold text-gray-900 mb-4">
                            Food
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            <!-- Food Price -->
                            <div>

                                <label
                                    for="food_price"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Food Price (JD)
                                </label>

                                <input
                                    type="number"
                                    id="food_price"
                                    name="food_price"
                                    value="{{ old('food_price') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Example: 10"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                >

                                @error('food_price')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- Food Images -->
                            <div>

                                <label
                                    for="food_images"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Food Images
                                </label>

                                <input
                                    type="file"
                                    id="food_images"
                                    name="food_images[]"
                                    multiple
                                    accept="image/*"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
                                >

                                @error('food_images')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                                @error('food_images.*')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>


                    <!-- Sweets -->
                    <div class="border border-gray-200 bg-white rounded-xl p-5">

                        <h4 class="text-lg font-bold text-gray-900 mb-4">
                            Sweets
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            <!-- Sweet Price -->
                            <div>

                                <label
                                    for="sweet_price"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Sweet Price (JD)
                                </label>

                                <input
                                    type="number"
                                    id="sweet_price"
                                    name="sweet_price"
                                    value="{{ old('sweet_price') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="Example: 5"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                >

                                @error('sweet_price')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- Sweet Images -->
                            <div>

                                <label
                                    for="sweet_images"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Sweet Images
                                </label>

                                <input
                                    type="file"
                                    id="sweet_images"
                                    name="sweet_images[]"
                                    multiple
                                    accept="image/*"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
                                >

                                @error('sweet_images')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                                @error('sweet_images.*')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- HALL IMAGES -->
                <!-- ========================= -->

                <div class="border border-blue-200 bg-blue-50 rounded-2xl p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        🖼️ Hall Images
                    </h3>

                    <p class="text-sm text-gray-600 mb-5">
                        Upload one or more images of your wedding hall.
                    </p>

                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        multiple
                        accept="image/*"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white"
                    >

                    @error('images')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                    @error('images.*')

                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- ========================= -->
                <!-- LOCATION -->
                <!-- ========================= -->

                <div class="border border-purple-200 bg-purple-50 rounded-2xl p-6">

                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        📍 Hall Location
                    </h3>

                    <p class="text-sm text-gray-600 mb-5">
                        You can enter the GPS coordinates of the hall.
                    </p>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <!-- Latitude -->
                        <div>

                            <label
                                for="latitude"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Latitude
                            </label>

                            <input
                                type="text"
                                id="latitude"
                                name="latitude"
                                value="{{ old('latitude') }}"
                                placeholder="Example: 32.5556"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            >

                            @error('latitude')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <!-- Longitude -->
                        <div>

                            <label
                                for="longitude"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Longitude
                            </label>

                            <input
                                type="text"
                                id="longitude"
                                name="longitude"
                                value="{{ old('longitude') }}"
                                placeholder="Example: 35.8510"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            >

                            @error('longitude')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    <!-- Get Location Button -->
                    <div class="mt-5">

                        <button
                            type="button"
                            onclick="getLocation()"
                            class="px-5 py-3 rounded-xl bg-purple-600 text-white font-semibold hover:bg-purple-700 transition"
                        >
                            📍 Get My Location
                        </button>

                        <p
                            id="location-message"
                            class="mt-3 text-sm text-gray-600"
                        ></p>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- BUTTONS -->
                <!-- ========================= -->

                <div class="flex flex-wrap items-center justify-end gap-4 pt-6 border-t border-gray-200">

                    <a
                        href="{{ route('hall-manager.halls.index') }}"
                        class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-8 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition"
                    >
                        Create Hall
                    </button>

                </div>

            </form>

        </div>

    </main>


    <!-- Location JavaScript -->
    <script>

        function getLocation() {

            const message =
                document.getElementById('location-message');

            if (!navigator.geolocation) {

                message.textContent =
                    'Geolocation is not supported by this browser.';

                return;
            }

            message.textContent =
                'Getting your location...';

            navigator.geolocation.getCurrentPosition(

                function (position) {

                    document.getElementById('latitude').value =
                        position.coords.latitude;

                    document.getElementById('longitude').value =
                        position.coords.longitude;

                    message.textContent =
                        'Location coordinates have been added successfully.';

                },

                function (error) {

                    switch (error.code) {

                        case error.PERMISSION_DENIED:

                            message.textContent =
                                'Location permission was denied.';

                            break;

                        case error.POSITION_UNAVAILABLE:

                            message.textContent =
                                'Location information is unavailable.';

                            break;

                        case error.TIMEOUT:

                            message.textContent =
                                'Location request timed out.';

                            break;

                        default:

                            message.textContent =
                                'Unable to get your location.';

                            break;
                    }

                },

                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }

            );

        }

    </script>

</body>

</html>