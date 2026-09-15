<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reservation Details</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">

        <div class="bg-white rounded-2xl shadow-lg p-8">


            {{-- Success Message --}}
            @if(session('success'))

                <div
                    class="mb-6 rounded-lg bg-green-100 border border-green-300
                           text-green-800 px-4 py-3"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- Error Message --}}
            @if(session('error'))

                <div
                    class="mb-6 rounded-lg bg-red-100 border border-red-300
                           text-red-800 px-4 py-3"
                >
                    {{ session('error') }}
                </div>

            @endif


            {{-- Validation Errors --}}
            @if($errors->any())

                <div
                    class="mb-6 rounded-lg bg-red-100 border border-red-300
                           text-red-800 px-4 py-3"
                >

                    <ul class="list-disc list-inside">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Page Title --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-8">
                Reservation Details
            </h1>


            {{-- Reservation Information --}}
            <div class="space-y-4">


                {{-- Hall --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        Hall
                    </span>

                    <span class="text-gray-900 font-medium">
                        {{ $reservation->hall->name }}
                    </span>

                </div>


                {{-- Date --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        Reservation Date
                    </span>

                    <span class="text-gray-900">

                        {{ $reservation->reservation_date->format('Y-m-d') }}

                    </span>

                </div>


                {{-- Start Time --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        Start Time
                    </span>

                    <span class="text-gray-900">
                        {{ $reservation->start_time }}
                    </span>

                </div>


                {{-- End Time --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        End Time
                    </span>

                    <span class="text-gray-900">
                        {{ $reservation->end_time }}
                    </span>

                </div>


                {{-- Total Price --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        Total Price
                    </span>

                    <span class="text-gray-900 font-bold">
                        {{ number_format((float) $reservation->total_price, 2) }}
                        JOD
                    </span>

                </div>


                {{-- Deposit --}}
                <div
                    class="flex justify-between items-center
                           border-b pb-4"
                >

                    <span class="font-semibold text-gray-600">
                        Deposit (20%)
                    </span>

                    <span class="text-blue-600 font-bold">

                        {{ number_format((float) $reservation->deposit_amount, 2) }}
                        JOD

                    </span>

                </div>


                {{-- Status --}}
                <div
                    class="flex justify-between items-center"
                >

                    <span class="font-semibold text-gray-600">
                        Reservation Status
                    </span>


                    @if($reservation->status === 'pending')

                        <span
                            class="px-3 py-1 rounded-full
                                   bg-yellow-100 text-yellow-700
                                   font-semibold"
                        >
                            Pending
                        </span>

                    @elseif($reservation->status === 'confirmed')

                        <span
                            class="px-3 py-1 rounded-full
                                   bg-green-100 text-green-700
                                   font-semibold"
                        >
                            Confirmed
                        </span>

                    @elseif($reservation->status === 'cancelled')

                        <span
                            class="px-3 py-1 rounded-full
                                   bg-red-100 text-red-700
                                   font-semibold"
                        >
                            Cancelled
                        </span>

                    @else

                        <span
                            class="px-3 py-1 rounded-full
                                   bg-gray-100 text-gray-700
                                   font-semibold"
                        >
                            {{ ucfirst($reservation->status) }}
                        </span>

                    @endif

                </div>

            </div>



            {{-- Update Food & Sweets --}}
            @if($reservation->status === 'pending')

                <div class="mt-8 border-t pt-8">

                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        Food & Sweets
                    </h2>

                    <p class="text-gray-600 mb-5">
                        You can update your selected food and sweets
                        while the reservation is pending.
                    </p>


                    <a
                        href="{{ route(
                            'customer.reservations.edit-food-sweets',
                            $reservation
                        ) }}"
                        class="block w-full text-center
                               bg-purple-600 hover:bg-purple-700
                               text-white font-semibold
                               py-3 px-6 rounded-lg
                               transition"
                    >
                        Update Food & Sweets
                    </a>

                </div>

            @endif



            {{-- Payment Section --}}
            <div class="mt-10 border-t pt-8">

                <h2 class="text-2xl font-bold text-gray-800 mb-3">
                    Payment
                </h2>


                <p class="text-gray-600 mb-6">

                    Payment is optional. You can pay the deposit now
                    or continue without payment.

                </p>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                    {{-- Pay Now --}}
                    <a
                        href="{{ route(
                            'customer.payments.checkout',
                            $reservation
                        ) }}"
                        class="text-center bg-blue-600
                               hover:bg-blue-700
                               text-white font-semibold
                               py-3 px-6 rounded-lg
                               transition"
                    >
                        Pay Deposit Now
                    </a>


                    {{-- Pay Later --}}
                    <a
                        href="{{ route('customer.halls.index') }}"
                        class="text-center bg-gray-200
                               hover:bg-gray-300
                               text-gray-800 font-semibold
                               py-3 px-6 rounded-lg
                               transition"
                    >
                        Pay Later
                    </a>

                </div>

            </div>



            {{-- Back to Halls --}}
            <div class="mt-6">

                <a
                    href="{{ route('customer.halls.index') }}"
                    class="block text-center
                           bg-gray-600 hover:bg-gray-700
                           text-white font-semibold
                           py-3 px-6 rounded-lg
                           transition"
                >
                    Back to Halls
                </a>

            </div>


        </div>

    </div>

</body>

</html>
