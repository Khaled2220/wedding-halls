<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Edit Sweet</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-pink-50 min-h-screen">

<div class="max-w-4xl mx-auto py-10 px-4">


<div class="bg-white rounded-2xl shadow-lg p-8">


    <!-- Header -->

    <div class="flex items-center justify-between mb-8">


        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                🍰 Edit Sweet
            </h1>

            <p class="text-gray-500 mt-2">
                Update the sweet price or add more images.
            </p>

        </div>


        <a
            href="{{ route('hall-manager.sweets.index') }}"
            class="px-5
                   py-2
                   bg-gray-200
                   hover:bg-gray-300
                   rounded-lg
                   text-gray-700
                   font-semibold
                   transition"
        >
            ← Back
        </a>


    </div>



    <!-- Validation Errors -->

    @if ($errors->any())

        <div
            class="mb-6
                   bg-red-100
                   border border-red-300
                   text-red-700
                   rounded-lg
                   p-4"
        >

            <ul class="list-disc list-inside">

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
        action="{{ route('hall-manager.sweets.update', $sweet) }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf

        @method('PUT')

    

        <!-- Price -->

        <div>

            <label
                for="price"
                class="block text-sm font-semibold text-gray-700 mb-2"
            >
                Price
            </label>


            <input
                type="number"
                id="price"
                name="price"
                value="{{ old('price', $sweet->price) }}"
                min="0"
                step="0.01"
                required
                placeholder="Enter sweet price"
                class="w-full
                       border-gray-300
                       rounded-lg
                       shadow-sm
                       focus:ring-pink-500
                       focus:border-pink-500"
            >

        </div>



        <!-- Current Images -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Current Images
            </label>


            @if ($sweet->images->count())


                <div
                    class="grid
                           grid-cols-2
                           md:grid-cols-3
                           gap-4"
                >


                    @foreach ($sweet->images as $image)


                        <div
                            class="border
                                   rounded-lg
                                   overflow-hidden
                                   bg-gray-50"
                        >

                            <img
                                src="{{ asset('storage/' . $image->image_path) }}"
                                alt="Sweet image"
                                class="w-full h-40 object-cover"
                            >

                        </div>


                    @endforeach


                </div>


            @else


                <div
                    class="bg-gray-100
                           rounded-lg
                           p-6
                           text-center
                           text-gray-500"
                >
                    No images uploaded yet.
                </div>


            @endif

        </div>



        <!-- Add New Images -->

        <div>

            <label
                for="images"
                class="block text-sm font-semibold text-gray-700 mb-2"
            >
                Add More Images
            </label>


            <input
                type="file"
                id="images"
                name="images[]"
                multiple
                accept=".jpg,.jpeg,.png,.webp"
                class="w-full
                       border
                       border-gray-300
                       rounded-lg
                       p-3
                       bg-white"
            >


            <p class="text-sm text-gray-500 mt-2">
                You can select multiple images.
                JPG, JPEG, PNG and WEBP.
                Maximum 5MB per image.
            </p>

        </div>



        <!-- Buttons -->

        <div class="flex gap-3 pt-4">


            <button
                type="submit"
                class="flex-1
                       bg-pink-600
                       hover:bg-pink-700
                       text-white
                       font-semibold
                       py-3
                       rounded-lg
                       transition"
            >
                💾 Update Sweet
            </button>


            <a
                href="{{ route('hall-manager.sweets.index') }}"
                class="px-8
                       py-3
                       bg-gray-200
                       hover:bg-gray-300
                       text-gray-700
                       font-semibold
                       rounded-lg
                       transition"
            >
                Cancel
            </a>


        </div>


    </form>


</div>


</div>

</body>

</html>




<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
</div>
