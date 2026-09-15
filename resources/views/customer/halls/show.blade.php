<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $hall->name }} - Wedding Halls</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-gray-50">


<!-- Header -->

<header class="bg-blue-700 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


            <div>

                <h1 class="text-3xl font-bold">
                    WEDDING HALLS
                </h1>

                <p class="text-blue-100 mt-1">
                    Customer
                </p>

            </div>


            <div class="flex items-center gap-4">


                <!-- All Halls Button -->

                <a
                    href="http://127.0.0.1:8001/customer/halls"
                    class="bg-white
                           text-blue-700
                           px-5 py-2
                           rounded-lg
                           font-semibold
                           hover:bg-blue-50
                           transition"
                >
                    All Halls
                </a>


                <!-- Logout -->

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="bg-blue-900
                               px-5 py-2
                               rounded-lg
                               font-semibold
                               hover:bg-blue-950
                               transition"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

</header>



<!-- Main -->

<main class="max-w-6xl mx-auto px-6 py-10">


    <!-- Hall Name -->

    <div class="mb-8">

        <h2 class="text-4xl font-bold text-gray-900">
            {{ $hall->name }}
        </h2>

        <p class="text-gray-500 mt-2">
            Hall Details
        </p>

    </div>





    <!-- Hall Information -->

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">


        <div class="p-6">


            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                Hall Information
            </h3>



            <!-- Description -->

            @if($hall->description)

                <div class="mb-5">

                    <h4 class="font-semibold text-gray-700">
                        Description
                    </h4>

                    <p class="text-gray-600 mt-1">
                        {{ $hall->description }}
                    </p>

                </div>

            @endif



            <!-- Address -->

            <div class="mb-5">

                <h4 class="font-semibold text-gray-700">
                    Address
                </h4>

                <p class="text-gray-600 mt-1">
                    {{ $hall->address }}
                </p>

            </div>



            <!-- Location -->

            @if($hall->latitude && $hall->longitude)

                <div class="mb-6">

                    <h4 class="font-semibold text-gray-700">
                        📍 Location
                    </h4>


                    <div
                        class="mt-3
                               bg-blue-50
                               border
                               border-blue-200
                               rounded-xl
                               p-4"
                    >


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                            <!-- Latitude -->

                            <div>

                                <p class="text-sm text-gray-500">
                                    Latitude
                                </p>

                                <p class="font-semibold text-gray-800">
                                    {{ $hall->latitude }}
                                </p>

                            </div>



                            <!-- Longitude -->

                            <div>

                                <p class="text-sm text-gray-500">
                                    Longitude
                                </p>

                                <p class="font-semibold text-gray-800">
                                    {{ $hall->longitude }}
                                </p>

                            </div>


                        </div>



                        <!-- Google Maps -->

                        <a
                            href="https://www.google.com/maps?q={{ $hall->latitude }},{{ $hall->longitude }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex
                                   items-center
                                   mt-5
                                   px-6
                                   py-3
                                   bg-green-600
                                   text-white
                                   rounded-xl
                                   font-semibold
                                   hover:bg-green-700
                                   transition"
                        >
                            🗺️ Open in Google Maps
                        </a>


                    </div>

                </div>

            @else

                <div class="mb-6">

                    <div
                        class="bg-gray-100
                               border
                               border-gray-200
                               rounded-xl
                               p-4"
                    >

                        <p class="text-gray-500">
                            📍 Location is not available for this hall.
                        </p>

                    </div>

                </div>

            @endif



            <!-- Phone -->

            @if($hall->phone)

                <div class="mb-5">

                    <h4 class="font-semibold text-gray-700">
                        Phone
                    </h4>

                    <p class="text-gray-600 mt-1">
                        {{ $hall->phone }}
                    </p>

                </div>

            @endif



            <!-- Price -->

            <div class="mb-5">

                <h4 class="font-semibold text-gray-700">
                    Price
                </h4>

                <p class="text-blue-600 text-2xl font-bold mt-1">
                    {{ $hall->price }} JD
                </p>

            </div>



            <!-- Capacity -->

            @if($hall->capacity)

                <div class="mb-5">

                    <h4 class="font-semibold text-gray-700">
                        Capacity
                    </h4>

                    <p class="text-gray-600 mt-1">
                        {{ $hall->capacity }} guests
                    </p>

                </div>

            @endif



            <!-- Food Availability -->

            @if($hall->food)

                <div class="mb-5">

                    <h4 class="font-semibold text-gray-700">
                        Food
                    </h4>

                    <p class="text-gray-600 mt-1">
                        {{ ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $hall->food
                            )
                        ) }}
                    </p>

                </div>

            @endif



            <!-- Sweets Availability -->

            @if($hall->sweets)

                <div class="mb-5">

                    <h4 class="font-semibold text-gray-700">
                        Sweets
                    </h4>

                    <p class="text-gray-600 mt-1">
                        {{ ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $hall->sweets
                            )
                        ) }}
                    </p>

                </div>

            @endif



            <!-- Status -->

            <div class="mb-5">

                <h4 class="font-semibold text-gray-700">
                    Status
                </h4>

                <span
                    class="inline-block
                           mt-2
                           px-4
                           py-2
                           rounded-full
                           bg-green-100
                           text-green-700
                           font-semibold"
                >
                    {{ ucfirst($hall->status) }}
                </span>

            </div>


        </div>



        <!-- Hall Images -->

        <div class="border-t border-gray-200 p-6">


            <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Hall Images
            </h3>



            @if($hall->images->isNotEmpty())

                <div
                    class="grid
                           grid-cols-1
                           sm:grid-cols-2
                           lg:grid-cols-3
                           gap-6"
                >


                    @foreach($hall->images as $image)

                        <div
                            class="bg-gray-50
                                   rounded-2xl
                                   overflow-hidden
                                   shadow-md"
                        >

                            <img
                                src="{{ asset(
                                    'storage/' . $image->image
                                ) }}"
                                alt="{{ $hall->name }}"
                                class="w-full
                                       h-80
                                       object-cover
                                       hover:scale-105
                                       transition
                                       duration-300"
                            >

                        </div>

                    @endforeach


                </div>

            @else

                <div
                    class="bg-gray-100
                           rounded-2xl
                           p-10
                           text-center"
                >

                    <p class="text-gray-500">
                        No images available
                    </p>

                </div>

            @endif


        </div>



        <!-- Food Items -->

        <div class="border-t border-gray-200 p-6">


            <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Food
            </h3>



            @if($hall->foods->isNotEmpty())

                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           gap-6"
                >


                    @foreach($hall->foods as $food)

                        <div
                            class="bg-gray-50
                                   rounded-2xl
                                   p-5
                                   shadow-sm"
                        >


                            <h4 class="text-lg font-bold text-gray-800">
                                Food
                            </h4>


                            <p
                                class="text-blue-600
                                       text-xl
                                       font-bold
                                       mt-2"
                            >
                                {{ $food->price }} JD
                            </p>



                            @if($food->images->isNotEmpty())

                                <div
                                    class="grid
                                           grid-cols-2
                                           gap-3
                                           mt-4"
                                >


                                    @foreach($food->images as $image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $image->image_path
                                            ) }}"
                                            alt="Food"
                                            class="w-full
                                                   h-40
                                                   object-cover
                                                   rounded-xl"
                                        >

                                    @endforeach


                                </div>

                            @endif


                        </div>

                    @endforeach


                </div>

            @else

                <div
                    class="bg-gray-100
                           rounded-xl
                           p-6
                           text-center"
                >

                    <p class="text-gray-500">
                        No food available for this hall.
                    </p>

                </div>

            @endif


        </div>



        <!-- Sweet Items -->

        <div class="border-t border-gray-200 p-6">


            <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Sweets
            </h3>



            @if($hall->sweetItems->isNotEmpty())

                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           gap-6"
                >


                    @foreach($hall->sweetItems as $sweet)

                        <div
                            class="bg-gray-50
                                   rounded-2xl
                                   p-5
                                   shadow-sm"
                        >


                            <h4 class="text-lg font-bold text-gray-800">
                                Sweet
                            </h4>


                            <p
                                class="text-blue-600
                                       text-xl
                                       font-bold
                                       mt-2"
                            >
                                {{ $sweet->price }} JD
                            </p>



                            @if($sweet->images->isNotEmpty())

                                <div
                                    class="grid
                                           grid-cols-2
                                           gap-3
                                           mt-4"
                                >


                                    @foreach($sweet->images as $image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $image->image_path
                                            ) }}"
                                            alt="Sweet"
                                            class="w-full
                                                   h-40
                                                   object-cover
                                                   rounded-xl"
                                        >

                                    @endforeach


                                </div>

                            @endif


                        </div>

                    @endforeach


                </div>

            @else

                <div
                    class="bg-gray-100
                           rounded-xl
                           p-6
                           text-center"
                >

                    <p class="text-gray-500">
                        No sweets available for this hall.
                    </p>

                </div>

            @endif


        </div>



        <!-- Book Now -->

        <div class="border-t border-gray-200 p-6">


            <a
                href="{{ route(
                    'customer.reservations.create',
                    $hall
                ) }}"
                class="inline-block
                       w-full
                       md:w-auto
                       bg-blue-600
                       text-white
                       px-8
                       py-3
                       rounded-xl
                       font-semibold
                       hover:bg-blue-700
                       transition
                       text-center"
            >
                Book Now
            </a>

              <!-- Back Button -->



        <a
            href="http://127.0.0.1:8001/customer/halls"
            class="inline-flex
                   items-center
                   bg-gray-600
                   text-white
                   px-6
                   py-3
                   rounded-xl
                   font-semibold
                   shadow
                   hover:bg-gray-700
                   transition"
        >
            ← Back to Wedding Halls
        </a>



        </div>


    </div>
  

</main>
</body>
</html>