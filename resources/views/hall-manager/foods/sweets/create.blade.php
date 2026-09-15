<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Sweet - {{ $hall->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">


    <!-- Header -->

    <header class="bg-white border-b border-gray-200">

        <div class="max-w-6xl mx-auto px-6 py-5
                    flex items-center justify-between">

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

    <main class="max-w-3xl mx-auto px-6 py-10">


        <!-- Back -->

        <div class="mb-6">

            <a
                href="{{ route('hall-manager.halls.show', $hall) }}"
                class="inline-flex items-center
                       text-pink-600
                       hover:text-pink-800
                       font-medium"
            >
                ← Back to {{ $hall->name }}
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
                    Add Sweet
                </h2>

                <p class="mt-2 text-gray-500">
                    Add a sweet to this wedding hall.
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
                action="{{ route('hall-manager.sweets.store') }}"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf



                <!-- Selected Hall ID -->

                <input
                    type="hidden"
                    name="hall_id"
                    value="{{ $hall->id }}"
                >



                <!-- Selected Hall -->

                <div>

                    <label
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Hall
                    </label>


                    <div
                        class="w-full
                               bg-gray-100
                               border border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               text-gray-700"
                    >

                        {{ $hall->name }}

                    </div>


                    <p class="mt-2 text-sm text-gray-500">
                        This sweet will belong to this hall only.
                    </p>

                </div>



                <!-- Price -->

                <div>

                    <label
                        for="price"
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Price
                    </label>


                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter sweet price"
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               focus:ring-2
                               focus:ring-pink-500
                               focus:border-pink-500"
                        required
                    >

                </div>



                <!-- Sweet Images -->

                <div>

                    <label
                        for="images"
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
                        id="images"
                        name="images[]"
                        multiple
                        accept=".jpg,.jpeg,.png,.webp"
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               bg-white
                               focus:ring-2
                               focus:ring-pink-500
                               focus:border-pink-500"
                    >


                    <p class="mt-2 text-sm text-gray-500">
                        You can select multiple images.
                        JPG, JPEG, PNG or WEBP.
                        Maximum 5MB per image.
                    </p>

                </div>



                <!-- Buttons -->

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


                    <!-- Cancel -->

                    <a
                        href="{{ route('hall-manager.halls.show', $hall) }}"
                        class="px-6
                               py-3
                               rounded-xl
                               border border-gray-300
                               text-gray-700
                               font-medium
                               hover:bg-gray-50
                               transition"
                    >
                        Cancel
                    </a>



                    <!-- Add Sweet -->

                    <button
                        type="submit"
                        class="px-6
                               py-3
                               rounded-xl
                               bg-pink-600
                               text-white
                               font-semibold
                               hover:bg-pink-700
                               focus:outline-none
                               focus:ring-4
                               focus:ring-pink-200
                               transition"
                    >
                        🍰 Add Sweet
                    </button>


                </div>


            </form>


        </div>


    </main>


</body>

</html>



<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
</div>
