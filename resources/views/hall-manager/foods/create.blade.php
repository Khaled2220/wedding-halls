<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Food - {{ $hall->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">


<div class="max-w-3xl mx-auto py-10 px-4">


    <!-- Back -->

    <div class="mb-6">

        <a
            href="{{ route('hall-manager.halls.show', $hall) }}"
            class="inline-flex items-center
                   text-blue-600
                   hover:text-blue-800
                   font-medium"
        >
            ← Back to {{ $hall->name }}
        </a>

    </div>


    <!-- Card -->

    <div class="bg-white rounded-2xl
                shadow-sm
                border border-gray-200
                p-8">


        <!-- Header -->

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-900">
                Add Food
            </h1>

            <p class="mt-2 text-gray-500">
                Add food to this wedding hall.
            </p>

        </div>


        <!-- Errors -->

        @if ($errors->any())

            <div class="mb-6 rounded-xl
                        bg-red-50
                        border border-red-200
                        p-4">

                <h3 class="font-semibold text-red-700 mb-2">
                    Please fix the following errors:
                </h3>

                <ul class="list-disc list-inside
                           text-sm text-red-600">

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
            action="{{ route('hall-manager.foods.store') }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf


            <!-- Selected Hall -->

            <input
                type="hidden"
                name="hall_id"
                value="{{ $hall->id }}"
            >


            <div>

                <label
                    class="block text-sm
                           font-semibold
                           text-gray-700 mb-2"
                >
                    Hall
                </label>

                <div
                    class="w-full
                           bg-gray-100
                           border border-gray-300
                           rounded-xl
                           px-4 py-3
                           text-gray-700"
                >
                    {{ $hall->name }}
                </div>

            </div>


            <!-- Price -->

            <div>

                <label
                    for="price"
                    class="block text-sm
                           font-semibold
                           text-gray-700 mb-2"
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
                    placeholder="Enter food price"
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


            <!-- Images -->

            <div>

                <label
                    for="images"
                    class="block text-sm
                           font-semibold
                           text-gray-700 mb-2"
                >
                    Food Images
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
                           px-4 py-3
                           bg-white"
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
                       justify-end
                       gap-4
                       pt-6
                       border-t
                       border-gray-200"
            >

                <a
                    href="{{ route('hall-manager.halls.show', $hall) }}"
                    class="px-6 py-3
                           rounded-xl
                           border border-gray-300
                           text-gray-700
                           font-medium
                           hover:bg-gray-50"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="px-6 py-3
                           rounded-xl
                           bg-blue-600
                           text-white
                           font-semibold
                           hover:bg-blue-700
                           focus:ring-4
                           focus:ring-blue-200"
                >
                    🍽️ Add Food
                </button>

            </div>


        </form>


    </div>


</div>


</body>

</html>





<div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
</div>
