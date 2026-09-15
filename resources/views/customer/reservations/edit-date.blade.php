<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Update Reservation Date</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-gray-100 min-h-screen">


<div class="max-w-2xl mx-auto py-10 px-4">


    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Update Reservation Date
        </h1>

        <p class="text-gray-600 mt-2">
            Change the date of your reservation.
        </p>

    </div>



    {{-- Error Messages --}}
    @if ($errors->any())

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- Reservation Information --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Reservation Information
        </h2>


        <div class="space-y-3">

            <div class="flex justify-between">

                <span class="text-gray-600">
                    Reservation ID
                </span>

                <span class="font-semibold">
                    #{{ $reservation->id }}
                </span>

            </div>


            <div class="flex justify-between">

                <span class="text-gray-600">
                    Hall
                </span>

                <span class="font-semibold">
                    {{ $reservation->hall->name }}
                </span>

            </div>


            <div class="flex justify-between">

                <span class="text-gray-600">
                    Current Date
                </span>

                <span class="font-semibold">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}
                </span>

            </div>


            <div class="flex justify-between">

                <span class="text-gray-600">
                    Time
                </span>

                <span class="font-semibold">
                    {{ $reservation->start_time }}
                    -
                    {{ $reservation->end_time }}
                </span>

            </div>

        </div>

    </div>



    {{-- Important Notice --}}
    <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-5 mb-6">

        <h3 class="font-semibold text-yellow-800 mb-2">
            Important
        </h3>

        <p class="text-yellow-700">

            You can change your reservation date only if
            the reservation is at least
            <strong>14 days in advance</strong>.

        </p>

    </div>



    {{-- Update Form --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form
            action="{{ route('customer.reservations.update-date', $reservation) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="mb-6">

                <label
                    for="reservation_date"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    New Reservation Date
                </label>


                <input
                    type="date"
                    id="reservation_date"
                    name="reservation_date"
                    value="{{ old('reservation_date', \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d')) }}"
                    min="{{ \Carbon\Carbon::today()->addDays(14)->format('Y-m-d') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >


                @error('reservation_date')

                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>



            {{-- Buttons --}}
            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg"
                >
                    Update Date
                </button>


                <a
                    href="{{ route('customer.reservations.show', $reservation) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>


</body>

</html>