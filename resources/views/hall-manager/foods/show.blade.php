<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Food Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-50 min-h-screen">


<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->

<header class="bg-blue-700 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


            <!-- Logo / Title -->

            <div>

                <h1 class="text-3xl font-bold">
                    WEDDING HALLS
                </h1>

                <p class="text-blue-100 mt-1">
                    Food Details
                </p>

            </div>


            <!-- Navigation -->

            <div class="flex items-center gap-3">


                <!-- All Foods -->

                <a
                    href="{{ route('hall-manager.foods.index') }}"
                    class="bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold hover:bg-blue-50 transition"
                >
                    All Foods
                </a>


                <!-- Logout -->

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



<!-- ========================================================= -->
<!-- MAIN -->
<!-- ========================================================= -->

<main class="max-w-5xl mx-auto px-6 py-10">


    <!-- Back -->

    <div class="mb-6">

        <a
            href="{{ route('hall-manager.foods.index') }}"
            class="text-blue-600 hover:text-blue-800 font-semibold"
        >
            ← Back to Foods
        </a>

    </div>



    <!-- ===================================================== -->
    <!-- FOOD CARD -->
    <!-- ===================================================== -->

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">


        <!-- ================================================= -->
        <!-- FOOD IMAGES -->
        <!-- ================================================= -->

        @if($food->images->isNotEmpty())


            <div
                class="grid
                       grid-cols-1
                       md:grid-cols-2
                       gap-4
                       p-6"
            >


                @foreach($food->images as $image)


                    <div
                        class="rounded-2xl
                               overflow-hidden
                               shadow-sm"
                    >

                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            alt="Food"
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


            <!-- No Images -->

            <div
                class="h-80
                       bg-gray-200
                       flex
                       items-center
                       justify-center"
            >

                <span class="text-7xl">
                    🍽️
                </span>

            </div>


        @endif



        <!-- ================================================= -->
        <!-- FOOD INFORMATION -->
        <!-- ================================================= -->

        <div class="p-8">


            <h2 class="text-3xl font-bold text-gray-800 mb-6">
                Food #{{ $food->id }}
            </h2>



            <!-- ================================================= -->
            <!-- HALL -->
            <!-- ================================================= -->

            <div
                class="border
                       border-gray-200
                       rounded-xl
                       p-5
                       mb-5"
            >

                <p class="text-sm text-gray-500 mb-2">
                    Hall
                </p>


                @if($food->hall)


                    <p class="text-xl font-bold text-gray-800">
                        {{ $food->hall->name }}
                    </p>


                @else


                    <p class="text-red-500 font-semibold">
                        No hall assigned
                    </p>


                @endif

            </div>



            <!-- ================================================= -->
            <!-- PRICE -->
            <!-- ================================================= -->

            <div
                class="border
                       border-gray-200
                       rounded-xl
                       p-5"
            >

                <p class="text-sm text-gray-500 mb-2">
                    Price
                </p>


                <p class="text-2xl font-bold text-orange-600">
                    {{ number_format($food->price, 2) }} JOD
                </p>

            </div>



            <!-- ================================================= -->
            <!-- ACTIONS -->
            <!-- ================================================= -->

            <div class="mt-8 flex flex-wrap gap-3">


                <!-- Edit -->

                <a
                    href="{{ route('hall-manager.foods.edit', $food) }}"
                    class="bg-blue-600
                           text-white
                           px-6
                           py-3
                           rounded-xl
                           font-semibold
                           hover:bg-blue-700
                           transition"
                >
                    ✏️ Edit Food
                </a>



                <!-- Back -->

                <a
                    href="{{ route('hall-manager.foods.index') }}"
                    class="bg-gray-100
                           text-gray-700
                           px-6
                           py-3
                           rounded-xl
                           font-semibold
                           hover:bg-gray-200
                           transition"
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
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
</div>
