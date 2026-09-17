<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit {{ $hall->name }} - Hall Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

<!-- Header -->
<header class="bg-blue-700 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <!-- Logo / Title -->
            <div>

                <h1 class="text-3xl font-bold">
                    WEDDING HALLS
                </h1>

                <p class="text-blue-100 mt-1">
                    Hall Manager
                </p>

            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('hall-manager.halls.index') }}"
                    class="bg-white text-blue-700 px-5 py-2 rounded-lg
                           font-semibold hover:bg-blue-50 transition"
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
                        class="bg-blue-900 text-white px-5 py-2 rounded-lg
                               font-semibold hover:bg-blue-950 transition"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

</header>


<!-- Main -->
<main class="max-w-5xl mx-auto px-6 py-10">

    <!-- Back -->
    <div class="mb-6">

        <a
            href="{{ route('hall-manager.halls.show', $hall) }}"
            class="text-blue-600 hover:text-blue-800 font-semibold"
        >
            ← Back to Hall
        </a>

    </div>


    <!-- Page Title -->
    <div class="mb-8">

        <h2 class="text-4xl font-bold text-gray-800">
            Edit Hall
        </h2>

        <p class="text-gray-500 mt-2">
            Update your wedding hall information
        </p>

    </div>


    <!-- Success Message -->
    @if(session('success'))

        <div
            class="mb-6 bg-green-100 border border-green-300
                   text-green-800 px-5 py-4 rounded-xl"
        >
            {{ session('success') }}
        </div>

    @endif


    <!-- Validation Errors -->
    @if($errors->any())

        <div
            class="mb-6 bg-red-100 border border-red-300
                   text-red-800 px-5 py-4 rounded-xl"
        >

            <h3 class="font-bold mb-2">
                Please fix the following errors:
            </h3>

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-md p-8">

        <form
            method="POST"
            action="{{ route('hall-manager.halls.update', $hall) }}"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            <!-- Hall Name -->
            <div class="mb-6">

                <label
                    for="name"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Hall Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $hall->name) }}"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 outline-none"
                    placeholder="Enter hall name"
                >

                @error('name')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Description -->
            <div class="mb-6">

                <label
                    for="description"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 outline-none"
                    placeholder="Describe your wedding hall"
                >{{ old('description', $hall->description) }}</textarea>

                @error('description')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Address -->
            <div class="mb-6">

                <label
                    for="address"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Address
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 outline-none"
                    placeholder="Enter hall address"
                >{{ old('address', $hall->address) }}</textarea>

                @error('address')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- GPS Location -->
            <div class="mb-6 border border-blue-200 bg-blue-50 rounded-2xl p-5">

                <div class="mb-4">

                    <h3 class="text-lg font-bold text-gray-900">
                        📍 Hall Location
                    </h3>

                    <p class="text-sm text-gray-600 mt-1">
                        Enter the hall coordinates manually or use your
                        current location to update them automatically.
                    </p>

                </div>


                <!-- Latitude / Longitude -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Latitude -->
                    <div>

                        <label
                            for="latitude"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Latitude
                        </label>

                        <input
                            type="number"
                            id="latitude"
                            name="latitude"
                            value="{{ old('latitude', $hall->latitude) }}"
                            placeholder="Example: 31.9539"
                            step="any"
                            min="-90"
                            max="90"
                            class="w-full border border-gray-300 rounded-xl
                                   px-4 py-3 bg-white
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"
                        >

                        @error('latitude')

                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- Longitude -->
                    <div>

                        <label
                            for="longitude"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Longitude
                        </label>

                        <input
                            type="number"
                            id="longitude"
                            name="longitude"
                            value="{{ old('longitude', $hall->longitude) }}"
                            placeholder="Example: 35.9106"
                            step="any"
                            min="-180"
                            max="180"
                            class="w-full border border-gray-300 rounded-xl
                                   px-4 py-3 bg-white
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"
                        >

                        @error('longitude')

                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                <!-- GPS Button -->
                <button
                    type="button"
                    onclick="getLocation()"
                    id="location-button"
                    class="mt-4 px-6 py-3 rounded-xl
                           bg-green-600 text-white font-semibold
                           hover:bg-green-700
                           focus:outline-none
                           focus:ring-4 focus:ring-green-200"
                >
                    📍 Get My Location
                </button>


                <!-- GPS Status -->
                <p
                    id="location-status"
                    class="mt-3 text-sm text-gray-600"
                ></p>

            </div>


            <!-- Phone -->
            <div class="mb-6">

                <label
                    for="phone"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $hall->phone) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 outline-none"
                    placeholder="Enter phone number"
                >

                @error('phone')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Price & Capacity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Price -->
                <div>

                    <label
                        for="price"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Price
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ old('price', $hall->price) }}"
                        min="0"
                        step="0.01"
                        required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 outline-none"
                        placeholder="0.00"
                    >

                    @error('price')

                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- Capacity -->
                <div>

                    <label
                        for="capacity"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Capacity
                    </label>

                    <input
                        type="number"
                        id="capacity"
                        name="capacity"
                        value="{{ old('capacity', $hall->capacity) }}"
                        min="1"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 outline-none"
                        placeholder="Number of guests"
                    >

                    @error('capacity')

                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            <!-- Food & Sweets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Food -->
                <div>

                    <label
                        for="food"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Food
                    </label>

                    <select
                        id="food"
                        name="food"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               bg-white focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 outline-none"
                    >

                        <option value="">
                            Select food option
                        </option>

                        <option
                            value="included"
                            {{ old('food', $hall->food) === 'included' ? 'selected' : '' }}
                        >
                            Included
                        </option>

                        <option
                            value="available"
                            {{ old('food', $hall->food) === 'available' ? 'selected' : '' }}
                        >
                            Available
                        </option>

                        <option
                            value="not_available"
                            {{ old('food', $hall->food) === 'not_available' ? 'selected' : '' }}
                        >
                            Not Available
                        </option>

                    </select>

                    @error('food')

                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- Sweets -->
                <div>

                    <label
                        for="sweets"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Sweets
                    </label>

                    <select
                        id="sweets"
                        name="sweets"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               bg-white focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 outline-none"
                    >

                        <option value="">
                            Select sweets option
                        </option>

                        <option
                            value="included"
                            {{ old('sweets', $hall->sweets) === 'included' ? 'selected' : '' }}
                        >
                            Included
                        </option>

                        <option
                            value="available"
                            {{ old('sweets', $hall->sweets) === 'available' ? 'selected' : '' }}
                        >
                            Available
                        </option>

                        <option
                            value="not_available"
                            {{ old('sweets', $hall->sweets) === 'not_available' ? 'selected' : '' }}
                        >
                            Not Available
                        </option>

                    </select>

                    @error('sweets')

                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            <!-- Status -->
            <div class="mb-8">

                <label
                    for="status"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           bg-white focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 outline-none"
                >

                    <option
                        value="active"
                        {{ old('status', $hall->status) === 'active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        {{ old('status', $hall->status) === 'inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

                @error('status')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <!-- Current Images -->
            <div class="mb-8 pt-8 border-t border-gray-200">

                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                    Current Hall Images
                </h3>

                <p class="text-gray-500 text-sm mb-5">
                    Select the images you want to delete.
                </p>


                @if($hall->images->isNotEmpty())

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        @foreach($hall->images as $image)

                            <div
                                class="bg-white border border-gray-200
                                       rounded-2xl overflow-hidden shadow-md"
                            >

                                <img
                                    src="{{ asset('storage/' . $image->image) }}"
                                    alt="{{ $hall->name }}"
                                    class="w-full h-64 object-cover"
                                >

                                <div class="p-4">

                                    <label
                                        class="flex items-center gap-3 cursor-pointer"
                                    >

                                        <input
                                            type="checkbox"
                                            name="delete_images[]"
                                            value="{{ $image->id }}"
                                            class="w-5 h-5 text-red-600
                                                   border-gray-300 rounded
                                                   focus:ring-red-500"
                                        >

                                        <span class="text-red-600 font-semibold">
                                            Delete this image
                                        </span>

                                    </label>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="bg-gray-100 rounded-xl p-6 text-center">

                        <p class="text-gray-500">
                            No images uploaded yet.
                        </p>

                    </div>

                @endif

            </div>


            <!-- Add New Images -->
            <div class="mb-8">

                <label
                    for="images"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Add New Images
                </label>

                <input
                    type="file"
                    id="images"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full border border-gray-300 rounded-xl
                           px-4 py-3 bg-white"
                >

                <p class="text-gray-500 text-sm mt-2">
                    You can select multiple images.
                    Maximum size: 5MB per image.
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
            <div
                class="flex flex-col sm:flex-row gap-3
                       pt-6 border-t border-gray-200"
            >

                <!-- Update Hall -->
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-8 py-3 rounded-xl
                           font-semibold hover:bg-blue-700 transition"
                >
                    Update Hall
                </button>


                <!-- Update Food -->
                <a
                    href="{{ route('hall-manager.foods.index') }}"
                    class="bg-green-600 text-white px-8 py-3 rounded-xl
                           font-semibold hover:bg-green-700 transition
                           text-center"
                >
                    🍽️ Update Food
                </a>


                <!-- Update Sweets -->
                <a
                    href="{{ route('hall-manager.sweets.index') }}"
                    class="bg-pink-600 text-white px-8 py-3 rounded-xl
                           font-semibold hover:bg-pink-700 transition
                           text-center"
                >
                    🍰 Update Sweets
                </a>


                <!-- Cancel -->
                <a
                    href="{{ route('hall-manager.halls.show', $hall) }}"
                    class="bg-gray-100 text-gray-700 px-8 py-3 rounded-xl
                           font-semibold hover:bg-gray-200 transition
                           text-center"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</main>


<!-- GPS JavaScript -->
<script>

    function getLocation() {

        const status =
            document.getElementById('location-status');

        const latitude =
            document.getElementById('latitude');

        const longitude =
            document.getElementById('longitude');

        const button =
            document.getElementById('location-button');


        // Check browser support
        if (!navigator.geolocation) {

            status.textContent =
                'GPS is not supported by this browser.';

            status.className =
                'mt-3 text-sm text-red-600';

            return;
        }


        // Loading
        button.disabled = true;

        button.textContent =
            '📍 Getting Location...';

        status.textContent =
            'Getting your location... Please wait.';

        status.className =
            'mt-3 text-sm text-blue-600';


        // Get location
        navigator.geolocation.getCurrentPosition(

            function (position) {

                latitude.value =
                    position.coords.latitude.toFixed(7);

                longitude.value =
                    position.coords.longitude.toFixed(7);


                status.textContent =
                    '✓ Hall location detected successfully.';

                status.className =
                    'mt-3 text-sm text-green-600 font-medium';


                button.disabled = false;

                button.textContent =
                    '📍 Get My Location Again';

            },


            function (error) {

                let message =
                    'Unable to get your location.';


                if (error.code === 1) {

                    message =
                        'Location permission was denied. Please allow location access in your browser.';

                } else if (error.code === 2) {

                    message =
                        'Location is unavailable. Please try again.';

                } else if (error.code === 3) {

                    message =
                        'Location request timed out. Please try again.';

                }


                status.textContent = message;

                status.className =
                    'mt-3 text-sm text-red-600';


                button.disabled = false;

                button.textContent =
                    '📍 Get My Location Again';


                console.error(
                    'Geolocation error:',
                    error
                );

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