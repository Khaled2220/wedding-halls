<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Food & Sweets</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto py-10 px-4">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Update Food & Sweets
                </h1>

                <p class="text-gray-600 mt-2">
                    Update the food and sweets for your reservation.
                </p>
            </div>

            <a
                href="{{ route('customer.reservations.show', $reservation) }}"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg"
            >
                Back to Reservation
            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Messages --}}
    @if($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Reservation Information --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Reservation Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <p class="text-sm text-gray-500">
                    Hall
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $reservation->hall->name }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Reservation Date
                </p>

                <p class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Time
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $reservation->start_time }}
                    -
                    {{ $reservation->end_time }}
                </p>
            </div>

        </div>

    </div>


    <form
        action="{{ route('customer.reservations.update-food-sweets', $reservation) }}"
        method="POST"
        id="foodSweetForm"
    >

        @csrf

        @method('PUT')


        {{-- FOOD --}}
        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Food
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Select the food items you want.
                    </p>

                </div>

                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">

                    Selected:
                    <span id="foodCount" class="font-bold">0</span>

                </div>

            </div>


            @if($foods->count() > 0)

                @php
                    $selectedFoodIds = $reservation->foods->pluck('id')->map(fn ($id) => (int) $id)->toArray();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($foods as $food)

                        @php
                            $image = $food->images->first();
                            $isSelected = in_array((int) $food->id, $selectedFoodIds);
                        @endphp

                        <label
                            class="food-card block cursor-pointer border-2 rounded-xl overflow-hidden transition
                            {{ $isSelected ? 'border-blue-600 ring-2 ring-blue-200' : 'border-gray-200' }}"
                            data-price="{{ $food->price }}"
                        >

                            <input
                                type="checkbox"
                                name="food_ids[]"
                                value="{{ $food->id }}"
                                class="food-checkbox hidden"
                                data-price="{{ $food->price }}"
                                {{ $isSelected ? 'checked' : '' }}
                            >


                            {{-- Image --}}
                            <div class="h-48 bg-gray-200 overflow-hidden">

                                @if($image)

                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="{{ $food->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>

                                @endif

                            </div>


                            {{-- Food Information --}}
                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="font-bold text-lg text-gray-800">
                                        {{ $food->name }}
                                    </h3>

                                    <span
                                        class="food-check text-blue-600 text-2xl {{ $isSelected ? '' : 'hidden' }}"
                                    >
                                        ✓
                                    </span>

                                </div>

                                <p class="text-gray-600 mt-2">
                                    {{ $food->description ?? '' }}
                                </p>

                                <p class="text-blue-600 font-bold mt-3">
                                    {{ number_format((float) $food->price, 2) }}
                                </p>

                            </div>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-500">
                    No food items available for this hall.
                </div>

            @endif

        </div>



        {{-- SWEETS --}}
        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Sweets
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Select the sweets you want.
                    </p>

                </div>

                <div class="bg-pink-100 text-pink-800 px-4 py-2 rounded-lg">

                    Selected:
                    <span id="sweetCount" class="font-bold">0</span>

                </div>

            </div>


            @if($sweets->count() > 0)

                @php
                    $selectedSweetIds = $reservation->sweets->pluck('id')->map(fn ($id) => (int) $id)->toArray();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($sweets as $sweet)

                        @php
                            $image = $sweet->images->first();
                            $isSelected = in_array((int) $sweet->id, $selectedSweetIds);
                        @endphp

                        <label
                            class="sweet-card block cursor-pointer border-2 rounded-xl overflow-hidden transition
                            {{ $isSelected ? 'border-pink-600 ring-2 ring-pink-200' : 'border-gray-200' }}"
                            data-price="{{ $sweet->price }}"
                        >

                            <input
                                type="checkbox"
                                name="sweet_ids[]"
                                value="{{ $sweet->id }}"
                                class="sweet-checkbox hidden"
                                data-price="{{ $sweet->price }}"
                                {{ $isSelected ? 'checked' : '' }}
                            >


                            {{-- Image --}}
                            <div class="h-48 bg-gray-200 overflow-hidden">

                                @if($image)

                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="{{ $sweet->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>

                                @endif

                            </div>


                            {{-- Sweet Information --}}
                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <h3 class="font-bold text-lg text-gray-800">
                                        {{ $sweet->name }}
                                    </h3>

                                    <span
                                        class="sweet-check text-pink-600 text-2xl {{ $isSelected ? '' : 'hidden' }}"
                                    >
                                        ✓
                                    </span>

                                </div>

                                <p class="text-gray-600 mt-2">
                                    {{ $sweet->description ?? '' }}
                                </p>

                                <p class="text-pink-600 font-bold mt-3">
                                    {{ number_format((float) $sweet->price, 2) }}
                                </p>

                            </div>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-500">
                    No sweets available for this hall.
                </div>

            @endif

        </div>



        {{-- PRICE SUMMARY --}}
        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Price Summary
            </h2>

            <div class="space-y-4">

                {{-- Hall --}}
                <div class="flex justify-between items-center">

                    <span class="text-gray-600">
                        Hall Price
                    </span>

                    <span
                        id="hallPrice"
                        class="font-semibold text-gray-800"
                        data-price="{{ $reservation->hall->price }}"
                    >
                        {{ number_format((float) $reservation->hall->price, 2) }}
                    </span>

                </div>


                {{-- Food --}}
                <div class="flex justify-between items-center">

                    <span class="text-gray-600">
                        Food
                    </span>

                    <span
                        id="foodTotal"
                        class="font-semibold text-gray-800"
                    >
                        0.00
                    </span>

                </div>


                {{-- Sweets --}}
                <div class="flex justify-between items-center">

                    <span class="text-gray-600">
                        Sweets
                    </span>

                    <span
                        id="sweetTotal"
                        class="font-semibold text-gray-800"
                    >
                        0.00
                    </span>

                </div>


                <div class="border-t pt-4">

                    <div class="flex justify-between items-center">

                        <span class="text-xl font-bold text-gray-800">
                            Total
                        </span>

                        <span
                            id="totalPrice"
                            class="text-2xl font-bold text-green-600"
                        >
                            0.00
                        </span>

                    </div>

                </div>


                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">

                    <div class="flex justify-between items-center">

                        <span class="text-gray-700 font-semibold">
                            Deposit (20%)
                        </span>

                        <span
                            id="depositPrice"
                            class="font-bold text-yellow-700"
                        >
                            0.00
                        </span>

                    </div>

                </div>

            </div>

        </div>



        {{-- BUTTONS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex flex-col sm:flex-row gap-4 justify-end">

                <a
                    href="{{ route('customer.reservations.show', $reservation) }}"
                    class="text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold"
                >
                    Update Food & Sweets
                </button>

            </div>

        </div>

    </form>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const foodCheckboxes = document.querySelectorAll('.food-checkbox');
    const sweetCheckboxes = document.querySelectorAll('.sweet-checkbox');

    const foodCount = document.getElementById('foodCount');
    const sweetCount = document.getElementById('sweetCount');

    const foodTotal = document.getElementById('foodTotal');
    const sweetTotal = document.getElementById('sweetTotal');

    const totalPrice = document.getElementById('totalPrice');
    const depositPrice = document.getElementById('depositPrice');

    const hallPriceElement = document.getElementById('hallPrice');


    const hallPrice = parseFloat(
        hallPriceElement.dataset.price || 0
    );


    function updateFoodCards() {

        let total = 0;
        let count = 0;

        foodCheckboxes.forEach(function (checkbox) {

            const card = checkbox.closest('.food-card');
            const checkIcon = card.querySelector('.food-check');

            if (checkbox.checked) {

                total += parseFloat(checkbox.dataset.price || 0);

                count++;

                card.classList.add(
                    'border-blue-600',
                    'ring-2',
                    'ring-blue-200'
                );

                card.classList.remove(
                    'border-gray-200'
                );

                checkIcon.classList.remove('hidden');

            } else {

                card.classList.remove(
                    'border-blue-600',
                    'ring-2',
                    'ring-blue-200'
                );

                card.classList.add(
                    'border-gray-200'
                );

                checkIcon.classList.add('hidden');

            }

        });


        foodCount.textContent = count;

        foodTotal.textContent = total.toFixed(2);

        return total;
    }



    function updateSweetCards() {

        let total = 0;
        let count = 0;

        sweetCheckboxes.forEach(function (checkbox) {

            const card = checkbox.closest('.sweet-card');
            const checkIcon = card.querySelector('.sweet-check');

            if (checkbox.checked) {

                total += parseFloat(checkbox.dataset.price || 0);

                count++;

                card.classList.add(
                    'border-pink-600',
                    'ring-2',
                    'ring-pink-200'
                );

                card.classList.remove(
                    'border-gray-200'
                );

                checkIcon.classList.remove('hidden');

            } else {

                card.classList.remove(
                    'border-pink-600',
                    'ring-2',
                    'ring-pink-200'
                );

                card.classList.add(
                    'border-gray-200'
                );

                checkIcon.classList.add('hidden');

            }

        });


        sweetCount.textContent = count;

        sweetTotal.textContent = total.toFixed(2);

        return total;
    }



    function updatePrices() {

        const foodPrice = updateFoodCards();

        const sweetPrice = updateSweetCards();

        const total = hallPrice + foodPrice + sweetPrice;

        const deposit = total * 0.20;


        totalPrice.textContent = total.toFixed(2);

        depositPrice.textContent = deposit.toFixed(2);
    }



    foodCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updatePrices();

        });

    });


    sweetCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updatePrices();

        });

    });


    updatePrices();

});

</script>

</body>
</html>
