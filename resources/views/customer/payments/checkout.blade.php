<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Checkout</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">

        <div class="bg-white rounded-2xl shadow-lg p-8">

            {{-- Page Title --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Payment Checkout
                </h1>

                <p class="text-gray-500 mt-2">
                    Pay your reservation deposit securely.
                </p>
            </div>


            {{-- Reservation Information --}}
            <div class="border rounded-xl p-6 bg-gray-50">

                <h2 class="text-xl font-bold text-gray-800 mb-5">
                    Reservation Details
                </h2>

                <div class="space-y-4">

                    {{-- Hall --}}
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">
                            Hall
                        </span>

                        <span class="text-gray-900 font-semibold">
                            {{ $reservation->hall->name }}
                        </span>
                    </div>


                    {{-- Date --}}
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">
                            Date
                        </span>

                        <span class="text-gray-900">
                            {{ $reservation->reservation_date->format('Y-m-d') }}
                        </span>
                    </div>


                    {{-- Time --}}
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">
                            Time
                        </span>

                        <span class="text-gray-900">
                            {{ $reservation->start_time }}
                            -
                            {{ $reservation->end_time }}
                        </span>
                    </div>


                    {{-- Total Price --}}
                    <div class="flex justify-between border-t pt-4">
                        <span class="text-gray-600 font-medium">
                            Total Price
                        </span>

                        <span class="text-gray-900 font-bold">
                            {{ $reservation->total_price }} JOD
                        </span>
                    </div>


                    {{-- Deposit --}}
                    <div class="flex justify-between">

                        <span class="text-gray-600 font-medium">
                            Deposit Required
                        </span>

                        <span class="text-blue-600 font-bold text-lg">
                            {{ $reservation->deposit_amount }} JOD
                        </span>

                    </div>

                </div>

            </div>


            {{-- Payment Information --}}
            <div class="mt-8">

                <h2 class="text-xl font-bold text-gray-800 mb-3">
                    Online Payment
                </h2>

                <p class="text-gray-600 mb-6">
                    You will be redirected to the secure payment page
                    to pay your reservation deposit.
                </p>


                {{-- PayTabs Payment --}}
                <form
                    method="POST"
                    action="{{ route(
                        'customer.payments.process',
                        $reservation
                    ) }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full bg-blue-600
                               hover:bg-blue-700
                               text-white font-bold
                               py-3 px-6 rounded-lg
                               transition duration-200"
                    >
                        Pay {{ $reservation->deposit_amount }} JOD
                    </button>

                </form>


                {{-- Pay Later --}}
                <div class="mt-4">

                    <a
                        href="{{ route(
                            'customer.reservations.show',
                            $reservation
                        ) }}"
                        class="block w-full text-center
                               bg-gray-200
                               hover:bg-gray-300
                               text-gray-800
                               font-semibold
                               py-3 px-6 rounded-lg
                               transition"
                    >
                        Pay Later
                    </a>

                </div>

            </div>


            {{-- Security Notice --}}
            <div class="mt-8 p-4 bg-green-50 border
                        border-green-200 rounded-lg">

                <p class="text-sm text-green-700 text-center">
                    Your payment will be processed securely.
                    We do not store your card information.
                </p>

            </div>

        </div>

    </div>

</body>
</html>



<div>
    <!-- Well begun is half done. - Aristotle -->
</div>
