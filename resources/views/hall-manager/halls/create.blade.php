<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add New Hall - Wedding Halls</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-50">


    <!-- Header -->

    <header class="bg-white border-b border-gray-200">

        <div
            class="max-w-6xl mx-auto px-6 py-5
                   flex items-center justify-between"
        >

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

    <main class="max-w-4xl mx-auto px-6 py-10">


        <!-- Back -->

        <div class="mb-6">

            <a
                href="{{ route('hall-manager.halls.index') }}"
                class="inline-flex
                       items-center
                       text-blue-600
                       hover:text-blue-800
                       font-medium"
            >
                ← My Halls
            </a>

        </div>


        <!-- Card -->

        <div
            class="bg-white
                   rounded-2xl
                   shadow-sm
                   border border-gray-200
                   p-8"
        >


            <!-- Title -->

            <div class="mb-8">

                <h2 class="text-3xl font-bold text-gray-900">
                    Add New Hall
                </h2>

                <p class="mt-2 text-gray-500">
                    Add your wedding hall information below.
                </p>

            </div>


            <!-- Errors -->

            @if ($errors->any())

                <div
                    class="mb-6
                           rounded-xl
                           bg-red-50
                           border border-red-200
                           p-4"
                >

                    <h3
                        class="font-semibold
                               text-red-700
                               mb-2"
                    >
                        Please fix the following errors:
                    </h3>


                    <ul
                        class="list-disc
                               list-inside
                               text-sm
                               text-red-600"
                    >

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

                    <h3
                        class="text-xl
                               font-bold
                               text-gray-900
                               mb-5"
                    >
                        🏛️ Hall Information
                    </h3>


                    <!-- Hall Name -->

                    <div class="mb-6">

                        <label
                            for="name"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Hall Name
                        </label>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter hall name"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                            required
                        >

                    </div>


                    <!-- Hall Images -->

                    <div class="mb-6">

                        <label
                            for="images"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Hall Images
                        </label>


                        <input
                            type="file"
                            id="images"
                            name="images[]"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   bg-white
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                        >


                        <p class="mt-2 text-sm text-gray-500">
                            You can select multiple hall images.
                            Maximum 5MB per image.
                        </p>

                    </div>


                    <!-- Description -->

                    <div class="mb-6">

                        <label
                            for="description"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Description
                        </label>


                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Describe your wedding hall..."
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                        >{{ old('description') }}</textarea>

                    </div>


                    <!-- Address -->

                    <div class="mb-6">

                        <label
                            for="address"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Address
                        </label>


                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="Enter hall address"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                            required
                        >{{ old('address') }}</textarea>

                    </div>


                    <!-- Phone -->

                    <div class="mb-6">

                        <label
                            for="phone"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Phone
                        </label>


                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                        >

                    </div>


                    <!-- Price -->

                    <div class="mb-6">

                        <label
                            for="price"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Hall Price
                        </label>


                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            step="0.01"
                            placeholder="Enter hall price"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                            required
                        >

                    </div>


                    <!-- Capacity -->

                    <div>

                        <label
                            for="capacity"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Capacity
                        </label>


                        <input
                            type="number"
                            id="capacity"
                            name="capacity"
                            value="{{ old('capacity') }}"
                            min="1"
                            placeholder="Number of guests"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500"
                        >

                    </div>

                </div>


                <!-- ========================= -->
                <!-- FOOD -->
                <!-- ========================= -->

                <div
                    class="border
                           border-orange-200
                           bg-orange-50
                           rounded-2xl
                           p-6"
                >

                    <div class="mb-5">

                        <h3
                            class="text-xl
                                   font-bold
                                   text-gray-900"
                        >
                            🍽️ Food
                        </h3>


                        <p class="text-sm text-gray-600 mt-1">
                            Add food price and food images.
                        </p>

                    </div>


                    <!-- Food Price -->

                    <div class="mb-5">

                        <label
                            for="food_price"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Food Price
                        </label>


                        <input
                            type="number"
                            id="food_price"
                            name="food_price"
                            value="{{ old('food_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="Enter food price"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   bg-white
                                   focus:ring-2
                                   focus:ring-orange-500
                                   focus:border-orange-500"
                        >

                    </div>


                    <!-- Food Images -->

                    <div>

                        <label
                            for="food_images"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Food Images
                        </label>


                        <input
                            type="file"
                            id="food_images"
                            name="food_images[]"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   bg-white
                                   focus:ring-2
                                   focus:ring-orange-500
                                   focus:border-orange-500"
                        >


                        <p class="mt-2 text-sm text-gray-500">
                            You can select multiple food images.
                            Maximum 5MB per image.
                        </p>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- SWEETS -->
                <!-- ========================= -->

                <div
                    class="border
                           border-pink-200
                           bg-pink-50
                           rounded-2xl
                           p-6"
                >

                    <div class="mb-5">

                        <h3
                            class="text-xl
                                   font-bold
                                   text-gray-900"
                        >
                            🍰 Sweets
                        </h3>


                        <p class="text-sm text-gray-600 mt-1">
                            Add sweet price and sweet images.
                        </p>

                    </div>


                    <!-- Sweet Price -->

                    <div class="mb-5">

                        <label
                            for="sweet_price"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Sweet Price
                        </label>


                        <input
                            type="number"
                            id="sweet_price"
                            name="sweet_price"
                            value="{{ old('sweet_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="Enter sweet price"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   bg-white
                                   focus:ring-2
                                   focus:ring-pink-500
                                   focus:border-pink-500"
                        >

                    </div>


                    <!-- Sweet Images -->

                    <div>

                        <label
                            for="sweet_images"
                            class="block
                                   text-sm
                                   font-semibold
                                   text-gray-700
                                   mb-2"
                        >
                            Sweet Images
                        </label>


                        <input
                            type="file"
                            id="sweet_images"
                            name="sweet_images[]"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   px-4 py-3
                                   bg-white
                                   focus:ring-2
                                   focus:ring-pink-500
                                   focus:border-pink-500"
                        >


                        <p class="mt-2 text-sm text-gray-500">
                            You can select multiple sweet images.
                            Maximum 5MB per image.
                        </p>

                    </div>

                </div>


                <!-- ========================= -->
                <!-- GPS LOCATION -->
                <!-- ========================= -->

                <div
                    class="border
                           border-blue-200
                           bg-blue-50
                           rounded-2xl
                           p-6"
                >

                    <div class="mb-5">

                        <h3
                            class="text-xl
                                   font-bold
                                   text-gray-900"
                        >
                            📍 Hall Location
                        </h3>


                        <p class="text-sm text-gray-600 mt-1">
                            Enter the hall coordinates manually or use your
                            current location.
                        </p>

                    </div>


                    <div
                        class="grid
                               grid-cols-1
                               md:grid-cols-2
                               gap-4"
                    >

                        <!-- Latitude -->

                        <div>

                            <label
                                for="latitude"
                                class="block
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       mb-2"
                            >
                                Latitude
                            </label>


                            <input
                                type="number"
                                id="latitude"
                                name="latitude"
                                value="{{ old('latitude') }}"
                                placeholder="Example: 31.9539"
                                step="any"
                                min="-90"
                                max="90"
                                class="w-full
                                       border border-gray-300
                                       rounded-xl
                                       px-4 py-3
                                       bg-white
                                       focus:ring-2
                                       focus:ring-blue-500
                                       focus:border-blue-500"
                            >

                        </div>


                        <!-- Longitude -->

                        <div>

                            <label
                                for="longitude"
                                class="block
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       mb-2"
                            >
                                Longitude
                            </label>


                            <input
                                type="number"
                                id="longitude"
                                name="longitude"
                                value="{{ old('longitude') }}"
                                placeholder="Example: 35.9106"
                                step="any"
                                min="-180"
                                max="180"
                                class="w-full
                                       border border-gray-300
                                       rounded-xl
                                       px-4 py-3
                                       bg-white
                                       focus:ring-2
                                       focus:ring-blue-500
                                       focus:border-blue-500"
                            >

                        </div>

                    </div>


                    <!-- GPS Button -->

                    <button
                        type="button"
                        onclick="getLocation()"
                        id="location-button"
                        class="mt-4
                               px-6 py-3
                               rounded-xl
                               bg-green-600
                               text-white
                               font-semibold
                               hover:bg-green-700
                               focus:outline-none
                               focus:ring-4
                               focus:ring-green-200"
                    >
                        📍 Get My Location
                    </button>


                    <!-- GPS Status -->

                    <p
                        id="location-status"
                        class="mt-3 text-sm text-gray-600"
                    ></p>

                </div>


                <!-- ========================= -->
                <!-- BUTTONS -->
                <!-- ========================= -->

                <div
                    class="flex
                           flex-wrap
                           items-center
                           justify-end
                           gap-4
                           pt-6
                           border-t
                           border-gray-200"
                >

                    <a
                        href="{{ route('hall-manager.halls.index') }}"
                        class="px-6 py-3
                               rounded-xl
                               border border-gray-300
                               text-gray-700
                               font-medium
                               hover:bg-gray-50
                               transition"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="px-8 py-3
                               rounded-xl
                               bg-blue-600
                               text-white
                               font-semibold
                               hover:bg-blue-700
                               focus:ring-4
                               focus:ring-blue-200
                               transition"
                    >
                        Create Hall
                    </button>

                </div>

            </form>

        </div>

    </main>


    <!-- GPS JavaScript -->

    <script>

        function getLocation() {

            const status =
                document.getElementById(
                    'location-status'
                );

            const latitude =
                document.getElementById(
                    'latitude'
                );

            const longitude =
                document.getElementById(
                    'longitude'
                );

            const button =
                document.getElementById(
                    'location-button'
                );


            if (!navigator.geolocation) {

                status.textContent =
                    'GPS is not supported by this browser.';

                status.className =
                    'mt-3 text-sm text-red-600';

                return;
            }


            button.disabled = true;

            button.textContent =
                '📍 Getting Location...';

            status.textContent =
                'Getting your location... Please wait.';

            status.className =
                'mt-3 text-sm text-blue-600';


            navigator.geolocation.getCurrentPosition(

                function (position) {

                    latitude.value =
                        position.coords.latitude
                            .toFixed(7);

                    longitude.value =
                        position.coords.longitude
                            .toFixed(7);


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


                    status.textContent =
                        message;

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
