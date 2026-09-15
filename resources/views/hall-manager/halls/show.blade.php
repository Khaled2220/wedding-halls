<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $hall->name }} - Wedding Halls</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- Header -->

    <header class="bg-white border-b border-gray-200">

        <div
            class="max-w-7xl mx-auto px-6 py-5
                   flex items-center justify-between"
        >

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    WEDDING HALLS
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Hall Manager
                </p>

            </div>


            <a
                href="{{ route('hall-manager.halls.index') }}"
                class="text-blue-600 font-medium hover:text-blue-800"
            >
                ← All Halls
            </a>

        </div>

    </header>



    <!-- Main -->

    <main class="max-w-7xl mx-auto px-6 py-10">


        <!-- Success Message -->

        @if (session('success'))

            <div
                class="mb-6
                       rounded-xl
                       bg-green-50
                       border border-green-200
                       px-5 py-4
                       text-green-700"
            >

                {{ session('success') }}

            </div>

        @endif



        <!-- Error Message -->

        @if (session('error'))

            <div
                class="mb-6
                       rounded-xl
                       bg-red-50
                       border border-red-200
                       px-5 py-4
                       text-red-700"
            >

                {{ session('error') }}

            </div>

        @endif



        <!-- Hall Card -->

        <div
            class="bg-white
                   rounded-2xl
                   shadow-sm
                   border border-gray-200
                   overflow-hidden"
        >


            <!-- Hall Images -->

            @if ($hall->images && $hall->images->count() > 0)

                <div
                    class="grid
                           grid-cols-1
                           sm:grid-cols-2
                           lg:grid-cols-3
                           gap-4
                           p-6
                           bg-gray-50"
                >

                    @foreach ($hall->images as $image)

                        <div
                            class="overflow-hidden
                                   rounded-xl
                                   bg-gray-200
                                   aspect-video"
                        >

                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                alt="{{ $hall->name }}"
                                class="w-full h-full object-cover"
                            >

                        </div>

                    @endforeach

                </div>

            @endif



            <!-- Hall Information -->

            <div class="p-8">


                <!-- Title -->

                <div
                    class="flex flex-col
                           md:flex-row
                           md:items-start
                           md:justify-between
                           gap-4
                           mb-8"
                >

                    <div>

                        <h2
                            class="text-3xl
                                   font-bold
                                   text-gray-900"
                        >
                            {{ $hall->name }}
                        </h2>


                        @if ($hall->status)

                            <span
                                class="inline-block
                                       mt-3
                                       px-3 py-1
                                       rounded-full
                                       text-sm
                                       font-medium
                                       {{ $hall->status === 'active'
                                           ? 'bg-green-100 text-green-700'
                                           : 'bg-gray-100 text-gray-600' }}"
                            >

                                {{ ucfirst($hall->status) }}

                            </span>

                        @endif

                    </div>



                    <!-- Edit Hall -->

                    <a
                        href="{{ route(
                            'hall-manager.halls.edit',
                            $hall
                        ) }}"
                        class="inline-flex
                               items-center
                               justify-center
                               px-5 py-3
                               rounded-xl
                               bg-gray-900
                               text-white
                               font-semibold
                               hover:bg-gray-800
                               transition"
                    >

                        ✏️ Edit Hall

                    </a>

                </div>



                <!-- Description -->

                @if ($hall->description)

                    <div class="mb-8">

                        <h3
                            class="text-lg
                                   font-bold
                                   text-gray-900
                                   mb-2"
                        >
                            Description
                        </h3>


                        <p class="text-gray-600 leading-7">
                            {{ $hall->description }}
                        </p>

                    </div>

                @endif



                <!-- Details -->

                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           lg:grid-cols-3
                           gap-5
                           mb-8"
                >


                    <!-- Address -->

                    <div
                        class="rounded-xl
                               bg-gray-50
                               border border-gray-200
                               p-5"
                    >

                        <p
                            class="text-sm
                                   font-semibold
                                   text-gray-500
                                   mb-1"
                        >
                            Address
                        </p>


                        <p class="text-gray-900">
                            {{ $hall->address }}
                        </p>

                    </div>



                    <!-- Phone -->

                    @if ($hall->phone)

                        <div
                            class="rounded-xl
                                   bg-gray-50
                                   border border-gray-200
                                   p-5"
                        >

                            <p
                                class="text-sm
                                       font-semibold
                                       text-gray-500
                                       mb-1"
                            >
                                Phone
                            </p>


                            <p class="text-gray-900">
                                {{ $hall->phone }}
                            </p>

                        </div>

                    @endif



                    <!-- Price -->

                    <div
                        class="rounded-xl
                               bg-gray-50
                               border border-gray-200
                               p-5"
                    >

                        <p
                            class="text-sm
                                   font-semibold
                                   text-gray-500
                                   mb-1"
                        >
                            Price
                        </p>


                        <p class="text-gray-900 font-semibold">
                            {{ $hall->price }}
                        </p>

                    </div>



                    <!-- Capacity -->

                    @if ($hall->capacity)

                        <div
                            class="rounded-xl
                                   bg-gray-50
                                   border border-gray-200
                                   p-5"
                        >

                            <p
                                class="text-sm
                                       font-semibold
                                       text-gray-500
                                       mb-1"
                            >
                                Capacity
                            </p>


                            <p class="text-gray-900">
                                {{ $hall->capacity }} people
                            </p>

                        </div>

                    @endif



                    <!-- Food Status -->

                    @if ($hall->food)

                        <div
                            class="rounded-xl
                                   bg-gray-50
                                   border border-gray-200
                                   p-5"
                        >

                            <p
                                class="text-sm
                                       font-semibold
                                       text-gray-500
                                       mb-1"
                            >
                                Food
                            </p>


                            <p class="text-gray-900">
                                {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $hall->food
                                    )
                                ) }}
                            </p>

                        </div>

                    @endif



                    <!-- Sweets Status -->

                    @if ($hall->sweets)

                        <div
                            class="rounded-xl
                                   bg-gray-50
                                   border border-gray-200
                                   p-5"
                        >

                            <p
                                class="text-sm
                                       font-semibold
                                       text-gray-500
                                       mb-1"
                            >
                                Sweets
                            </p>


                            <p class="text-gray-900">
                                {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $hall->sweets
                                    )
                                ) }}
                            </p>

                        </div>

                    @endif

                </div>



                <!-- Food & Sweets -->

                <div
                    class="border-t
                           border-gray-200
                           pt-8"
                >

                    <h3
                        class="text-2xl
                               font-bold
                               text-gray-900
                               mb-2"
                    >
                        Hall Food & Sweets
                    </h3>


                    <p class="text-gray-500 mb-6">
                        Add food and sweets specifically for this hall.
                    </p>



                    <div
                        class="grid
                               grid-cols-1
                               md:grid-cols-2
                               gap-5"
                    >


                        <!-- Add Food -->

                        <a
                            href="{{ route(
                                'hall-manager.foods.create',
                                ['hall_id' => $hall->id]
                            ) }}"
                            class="flex
                                   items-center
                                   justify-center
                                   gap-3
                                   px-6 py-5
                                   rounded-2xl
                                   bg-blue-100
                                   text-blue-700
                                   font-semibold
                                   text-lg
                                   hover:bg-blue-200
                                   transition"
                        >

                            🍽️

                            <span>
                                Add Food
                            </span>

                        </a>



                        <!-- Add Sweet -->

                        <a
                            href="{{ route(
                                'hall-manager.sweets.create',
                                ['hall_id' => $hall->id]
                            ) }}"
                            class="flex
                                   items-center
                                   justify-center
                                   gap-3
                                   px-6 py-5
                                   rounded-2xl
                                   bg-pink-100
                                   text-pink-700
                                   font-semibold
                                   text-lg
                                   hover:bg-pink-200
                                   transition"
                        >

                            🍰

                            <span>
                                Add Sweet
                            </span>

                        </a>

                    </div>

                </div>



                <!-- Existing Foods -->

                @if ($hall->foods && $hall->foods->count() > 0)

                    <div
                        class="border-t
                               border-gray-200
                               pt-8
                               mt-8"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between
                                   mb-5"
                        >

                            <h3
                                class="text-xl
                                       font-bold
                                       text-gray-900"
                            >
                                Foods
                            </h3>


                            <a
                                href="{{ route(
                                    'hall-manager.foods.index',
                                    ['hall_id' => $hall->id]
                                ) }}"
                                class="text-blue-600
                                       font-medium
                                       hover:text-blue-800"
                            >
                                View All
                            </a>

                        </div>



                        <div
                            class="grid
                                   grid-cols-1
                                   sm:grid-cols-2
                                   lg:grid-cols-3
                                   gap-5"
                        >

                            @foreach ($hall->foods as $food)

                                <div
                                    class="border
                                           border-gray-200
                                           rounded-xl
                                           p-5
                                           bg-white"
                                >

                                    <p
                                        class="text-sm
                                               text-gray-500
                                               mb-1"
                                    >
                                        Food
                                    </p>


                                    <p
                                        class="text-xl
                                               font-bold
                                               text-gray-900"
                                    >
                                        {{ $food->price }}
                                    </p>


                                    <a
                                        href="{{ route(
                                            'hall-manager.foods.show',
                                            $food
                                        ) }}"
                                        class="inline-block
                                               mt-4
                                               text-blue-600
                                               font-medium
                                               hover:text-blue-800"
                                    >
                                        View Food →
                                    </a>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif



                <!-- Existing Sweets -->

                @if (
                    $hall->sweetItems &&
                    $hall->sweetItems->count() > 0
                )

                    <div
                        class="border-t
                               border-gray-200
                               pt-8
                               mt-8"
                    >

                        <div
                            class="flex
                                   items-center
                                   justify-between
                                   mb-5"
                        >

                            <h3
                                class="text-xl
                                       font-bold
                                       text-gray-900"
                            >
                                Sweets
                            </h3>


                            <a
                                href="{{ route(
                                    'hall-manager.sweets.index',
                                    ['hall_id' => $hall->id]
                                ) }}"
                                class="text-pink-600
                                       font-medium
                                       hover:text-pink-800"
                            >
                                View All
                            </a>

                        </div>



                        <div
                            class="grid
                                   grid-cols-1
                                   sm:grid-cols-2
                                   lg:grid-cols-3
                                   gap-5"
                        >

                            @foreach (
                                $hall->sweetItems
                                as $sweet
                            )

                                <div
                                    class="border
                                           border-gray-200
                                           rounded-xl
                                           p-5
                                           bg-white"
                                >

                                    <p
                                        class="text-sm
                                               text-gray-500
                                               mb-1"
                                    >
                                        Sweet
                                    </p>


                                    <p
                                        class="text-xl
                                               font-bold
                                               text-gray-900"
                                    >
                                        {{ $sweet->price }}
                                    </p>


                                    <a
                                        href="{{ route(
                                            'hall-manager.sweets.show',
                                            $sweet
                                        ) }}"
                                        class="inline-block
                                               mt-4
                                               text-pink-600
                                               font-medium
                                               hover:text-pink-800"
                                    >
                                        View Sweet →
                                    </a>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif



                <!-- Bottom Actions -->

                <div
                    class="border-t
                           border-gray-200
                           mt-8
                           pt-6
                           flex
                           flex-wrap
                           gap-4"
                >


                    <!-- Back -->

                    <a
                        href="{{ route(
                            'hall-manager.halls.index'
                        ) }}"
                        class="px-6
                               py-3
                               rounded-xl
                               border border-gray-300
                               text-gray-700
                               font-medium
                               hover:bg-gray-50
                               transition"
                    >
                        ← Back to Halls
                    </a>



                    <!-- Delete -->

                    <form
                        action="{{ route(
                            'hall-manager.halls.destroy',
                            $hall
                        ) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this hall?');"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="px-6
                                   py-3
                                   rounded-xl
                                   bg-red-600
                                   text-white
                                   font-semibold
                                   hover:bg-red-700
                                   transition"
                        >
                            🗑️ Delete Hall
                        </button>

                    </form>

                </div>


            </div>

        </div>

    </main>


</body>

</html>
