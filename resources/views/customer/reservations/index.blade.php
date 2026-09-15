<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Reservations</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-gray-100 min-h-screen">


<div class="max-w-6xl mx-auto py-10 px-4">


    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                My Reservations
            </h1>

            <p class="text-gray-600 mt-2">
                View and manage your reservations.
            </p>

        </div>


        <a
        href="{{ route('customer.halls.index') }}"
        class="inline-block bg-gray-600 hover:bg-gray-700
        text-white font-semibold
        py-2 px-5 rounded-lg transition">
        ← Back
       </a>

    </div>



    {{-- Success Message --}}
    @if(session('success'))

        <div
            class="mb-6 bg-green-100
                   border border-green-300
                   text-green-800
                   px-4 py-3 rounded-lg"
        >

            {{ session('success') }}

        </div>

    @endif



    {{-- Error Message --}}
    @if(session('error'))

        <div
            class="mb-6 bg-red-100
                   border border-red-300
                   text-red-800
                   px-4 py-3 rounded-lg"
        >

            {{ session('error') }}

        </div>

    @endif



    {{-- Reservations --}}
    @if($reservations->count() > 0)


        <div class="space-y-6">


            @foreach($reservations as $reservation)


                @php

                    $statusClasses = match($reservation->status) {

                        'pending' =>
                            'bg-yellow-100 text-yellow-800',

                        'confirmed' =>
                            'bg-green-100 text-green-800',

                        'cancelled' =>
                            'bg-red-100 text-red-800',

                        'completed' =>
                            'bg-blue-100 text-blue-800',

                        default =>
                            'bg-gray-100 text-gray-800',

                    };

                    /*
                    |--------------------------------------------------------------------------
                    | Update Date Rule
                    |--------------------------------------------------------------------------
                    | Customer can update the reservation date only if
                    | the reservation is at least 14 days in the future.
                    */

                    $reservationDate = \Carbon\Carbon::parse(
                        $reservation->reservation_date
                    )->startOfDay();

                    $today = \Carbon\Carbon::today();

                    $daysUntilReservation = $today->diffInDays(
                        $reservationDate,
                        false
                    );

                    $canUpdateDate =
                        $reservation->status === 'pending'
                        && $daysUntilReservation >= 14;

                @endphp



                <div class="bg-white rounded-xl shadow-md p-6">


                    {{-- Reservation Header --}}
                    <div
                        class="flex flex-col md:flex-row
                               md:items-center
                               md:justify-between
                               gap-4"
                    >


                        <div>

                            <h2 class="text-2xl font-bold text-gray-800">

                                {{ $reservation->hall->name }}

                            </h2>


                            <p class="text-gray-500 mt-1">

                                Reservation #{{ $reservation->id }}

                            </p>

                        </div>



                        {{-- Status --}}
                        <span
                            class="inline-flex items-center
                                   justify-center
                                   px-4 py-2
                                   rounded-full
                                   font-semibold
                                   {{ $statusClasses }}"
                        >

                            {{ ucfirst($reservation->status) }}

                        </span>


                    </div>



                    {{-- Reservation Information --}}
                    <div
                        class="grid grid-cols-1
                               sm:grid-cols-2
                               md:grid-cols-4
                               gap-4
                               mt-6"
                    >


                        {{-- Date --}}
                        <div class="bg-gray-50 rounded-lg p-4">

                            <p class="text-sm text-gray-500">
                                Date
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">

                                {{ $reservationDate->format('Y-m-d') }}

                            </p>

                            @if($daysUntilReservation >= 0)

                                <p class="text-xs text-gray-500 mt-1">

                                    {{ $daysUntilReservation }}
                                    days remaining

                                </p>

                            @endif

                        </div>



                        {{-- Time --}}
                        <div class="bg-gray-50 rounded-lg p-4">

                            <p class="text-sm text-gray-500">
                                Time
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">

                                {{ \Carbon\Carbon::parse(
                                    $reservation->start_time
                                )->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse(
                                    $reservation->end_time
                                )->format('H:i') }}

                            </p>

                        </div>



                        {{-- Guests --}}
                        <div class="bg-gray-50 rounded-lg p-4">

                            <p class="text-sm text-gray-500">
                                Guests
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">

                                {{ $reservation->guests }}

                            </p>

                        </div>



                        {{-- Total Price --}}
                        <div class="bg-gray-50 rounded-lg p-4">

                            <p class="text-sm text-gray-500">
                                Total Price
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">

                                {{ number_format(
                                    $reservation->total_price,
                                    2
                                ) }}

                                JD

                            </p>

                        </div>


                    </div>



                    {{-- Deposit --}}
                    <div
                        class="mt-4
                               bg-blue-50
                               border border-blue-100
                               rounded-lg
                               p-4"
                    >

                        <div class="flex justify-between items-center">

                            <span class="text-gray-600">
                                Deposit Amount
                            </span>

                            <span class="font-bold text-blue-700">

                                {{ number_format(
                                    $reservation->deposit_amount,
                                    2
                                ) }}

                                JD

                            </span>

                        </div>

                    </div>



                    {{-- Selected Food --}}
                    @if($reservation->foods->count() > 0)

                        <div class="mt-5">

                            <h3 class="font-semibold text-gray-800 mb-2">
                                Selected Food
                            </h3>

                            <div class="flex flex-wrap gap-2">

                                @foreach($reservation->foods as $food)

                                    <span
                                        class="bg-purple-100
                                               text-purple-800
                                               px-3 py-1
                                               rounded-full
                                               text-sm"
                                    >

                                        {{ $food->name }}

                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif



                    {{-- Selected Sweets --}}
                    @if($reservation->sweets->count() > 0)

                        <div class="mt-5">

                            <h3 class="font-semibold text-gray-800 mb-2">
                                Selected Sweets
                            </h3>

                            <div class="flex flex-wrap gap-2">

                                @foreach($reservation->sweets as $sweet)

                                    <span
                                        class="bg-pink-100
                                               text-pink-800
                                               px-3 py-1
                                               rounded-full
                                               text-sm"
                                    >

                                        {{ $sweet->name }}

                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endif



                    {{-- Buttons --}}
                    <div
                        class="mt-6
                               flex flex-col
                               sm:flex-row
                               gap-3"
                    >


                        {{-- View Reservation --}}
                        <a
                            href="{{ route(
                                'customer.reservations.show',
                                $reservation
                            ) }}"
                            class="flex-1
                                   text-center
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   font-semibold
                                   py-3 px-6
                                   rounded-lg
                                   transition"
                        >

                            View Reservation

                        </a>



                        {{-- Update Food & Sweets --}}
                        @if($reservation->status === 'pending')

                            <a
                                href="{{ route(
                                    'customer.reservations.edit-food-sweets',
                                    $reservation
                                ) }}"
                                class="flex-1
                                       text-center
                                       bg-purple-600
                                       hover:bg-purple-700
                                       text-white
                                       font-semibold
                                       py-3 px-6
                                       rounded-lg
                                       transition"
                            >

                                Update Food & Sweets

                            </a>

                        @endif



                        {{-- Update Date --}}
                        @if($canUpdateDate)

                            <a
                                href="{{ route(
                                    'customer.reservations.edit-date',
                                    $reservation
                                ) }}"
                                class="flex-1
                                       text-center
                                       bg-orange-600
                                       hover:bg-orange-700
                                       text-white
                                       font-semibold
                                       py-3 px-6
                                       rounded-lg
                                       transition"
                            >

                                Update Date

                            </a>

                        @endif


                    </div>



                    {{-- Date Update Information --}}
                    @if(
                        $reservation->status === 'pending'
                        && !$canUpdateDate
                        && $daysUntilReservation >= 0
                    )

                        <div
                            class="mt-4
                                   bg-red-50
                                   border border-red-200
                                   text-red-700
                                   rounded-lg
                                   p-4"
                        >

                            <p class="font-semibold">
                                Date cannot be changed.
                            </p>

                            <p class="text-sm mt-1">

                                The reservation date must be at least
                                14 days in advance to be changed.

                            </p>

                        </div>

                    @endif


                </div>


            @endforeach


        </div>



        {{-- Pagination --}}
        <div class="mt-8">

            {{ $reservations->links() }}

        </div>


    @else


        {{-- No Reservations --}}
        <div
            class="bg-white
                   rounded-xl
                   shadow-md
                   p-10
                   text-center"
        >

            <div class="text-5xl mb-4">
                📅
            </div>


            <h2 class="text-2xl font-bold text-gray-800">

                No Reservations Yet

            </h2>


            <p class="text-gray-600 mt-2">

                You don't have any reservations yet.

            </p>


            <a
                href="{{ route('customer.halls.index') }}"
                class="inline-block
                       mt-6
                       bg-blue-600
                       hover:bg-blue-700
                       text-white
                       font-semibold
                       py-3 px-6
                       rounded-lg
                       transition"
            >

                Browse Wedding Halls

            </a>

        </div>


    @endif


</div>


</body>

</html>
