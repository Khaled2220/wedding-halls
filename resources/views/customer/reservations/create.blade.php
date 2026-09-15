<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Make a Reservation</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto py-8 px-4">

    <!-- Header -->
    <div class="mb-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    WEDDING HALLS
                </h1>

                <p class="text-gray-500 mt-1">
                    Make a Reservation
                </p>

            </div>

            <a
                href="{{ route('customer.halls.show', $hall) }}"
                class="inline-flex items-center justify-center bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800 transition"
            >
                ← Back to Hall
            </a>

        </div>

    </div>


    <!-- Errors -->
    @if ($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-5 mb-6">

            <h2 class="font-bold mb-2">
                Please fix the following errors:
            </h2>

            <ul class="list-disc list-inside space-y-1">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Success -->
    @if (session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-5 mb-6">

            {{ session('success') }}

        </div>

    @endif


    <!-- Hall Information -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $hall->name }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-gray-50 rounded-lg p-4">

                <p class="text-sm text-gray-500">
                    Price
                </p>

                <p class="text-xl font-bold text-blue-600">
                    {{ number_format($hall->price ?? 0, 2) }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-lg p-4">

                <p class="text-sm text-gray-500">
                    Capacity
                </p>

                <p class="text-xl font-bold text-gray-800">
                    {{ $hall->capacity }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-lg p-4">

                <p class="text-sm text-gray-500">
                    Address
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $hall->address }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-lg p-4">

                <p class="text-sm text-gray-500">
                    Phone
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $hall->phone }}
                </p>

            </div>

        </div>

    </div>


    <form
        method="POST"
        action="{{ route('customer.reservations.store', $hall) }}"
        id="reservationForm"
    >

        @csrf


        <input
            type="hidden"
            name="hall_id"
            value="{{ $hall->id }}"
        >


        <!-- Calendar -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <div class="flex items-center justify-between mb-6">

                <button
                    type="button"
                    id="previousMonth"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition"
                >
                    ←
                </button>

                <h2
                    id="calendarTitle"
                    class="text-xl font-bold text-gray-800"
                ></h2>

                <button
                    type="button"
                    id="nextMonth"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition"
                >
                    →
                </button>

            </div>


            <!-- Week Days -->
            <div class="grid grid-cols-7 gap-2 mb-2">

                <div class="text-center font-semibold text-gray-500">
                    Sun
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Mon
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Tue
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Wed
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Thu
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Fri
                </div>

                <div class="text-center font-semibold text-gray-500">
                    Sat
                </div>

            </div>


            <!-- Calendar Days -->
            <div
                id="calendarDays"
                class="grid grid-cols-7 gap-2"
            ></div>


            <!-- Date -->
            <div class="mt-6">

                <label
                    for="reservation_date"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Reservation Date
                </label>

                <input
                    type="date"
                    name="reservation_date"
                    id="reservation_date"
                    value="{{ old('reservation_date') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

            </div>

        </div>


        <!-- Hours -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Choose Time
            </h2>

            <p class="text-gray-500 mb-5">
                Select the start and end time of your reservation.
            </p>


            <div
                id="hourSlots"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3"
            ></div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">

                <div>

                    <label
                        for="start_time"
                        class="block font-semibold text-gray-700 mb-2"
                    >
                        Start Time
                    </label>

                    <input
                        type="time"
                        name="start_time"
                        id="start_time"
                        value="{{ old('start_time') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    >

                </div>


                <div>

                    <label
                        for="end_time"
                        class="block font-semibold text-gray-700 mb-2"
                    >
                        End Time
                    </label>

                    <input
                        type="time"
                        name="end_time"
                        id="end_time"
                        value="{{ old('end_time') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    >

                </div>

            </div>

        </div>


        <!-- Guests -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-xl font-bold text-gray-800 mb-4">
                Number of Guests
            </h2>

            <label
                for="guests"
                class="block font-semibold text-gray-700 mb-2"
            >
                Guests
            </label>

            <input
                type="number"
                name="guests"
                id="guests"
                value="{{ old('guests') }}"
                min="1"
                max="{{ $hall->capacity }}"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3"
            >

            <p class="text-sm text-gray-500 mt-2">
                Maximum capacity:
                {{ $hall->capacity }}
                guests.
            </p>

        </div>


        <!-- FOOD -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Choose Food
            </h2>

            <p class="text-gray-500 mb-6">
                Select the food you want.
            </p>


            @if ($hall->foods->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($hall->foods as $food)

                        <label
                            class="food-card relative block cursor-pointer border-2 border-gray-200 rounded-xl overflow-hidden bg-white hover:shadow-lg transition"
                        >

                            <input
                                type="checkbox"
                                name="food_ids[]"
                                value="{{ $food->id }}"
                                data-price="{{ $food->price ?? 0 }}"
                                class="food-checkbox hidden"
                                {{ in_array($food->id, old('food_ids', [])) ? 'checked' : '' }}
                            >


                            <!-- Check -->
                            <div
                                class="food-check hidden absolute top-3 right-3 z-20 bg-green-600 text-white w-9 h-9 rounded-full items-center justify-center font-bold text-lg shadow"
                            >
                                ✓
                            </div>


                            <!-- Image -->
                            <div class="h-52 bg-gray-100">

                                @if ($food->images->count())

                                    <img
                                        src="{{ asset('storage/' . $food->images->first()->image_path) }}"
                                        alt="{{ $food->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-400"
                                    >
                                        No Image
                                    </div>

                                @endif

                            </div>


                            <!-- Food Info -->
                            <div class="p-4">

                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $food->name }}
                                </h3>

                                <p class="text-blue-600 font-bold mt-2">
                                    {{ number_format($food->price ?? 0, 2) }}
                                </p>

                            </div>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="bg-gray-50 rounded-lg p-5 text-gray-500">
                    No food available for this hall.
                </div>

            @endif

        </div>


        <!-- SWEETS -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Choose Sweets
            </h2>

            <p class="text-gray-500 mb-6">
                Select the sweets you want.
            </p>


            @if ($hall->sweetItems->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($hall->sweetItems as $sweet)

                        <label
                            class="sweet-card relative block cursor-pointer border-2 border-gray-200 rounded-xl overflow-hidden bg-white hover:shadow-lg transition"
                        >

                            <input
                                type="checkbox"
                                name="sweet_ids[]"
                                value="{{ $sweet->id }}"
                                data-price="{{ $sweet->price ?? 0 }}"
                                class="sweet-checkbox hidden"
                                {{ in_array($sweet->id, old('sweet_ids', [])) ? 'checked' : '' }}
                            >


                            <!-- Check -->
                            <div
                                class="sweet-check hidden absolute top-3 right-3 z-20 bg-green-600 text-white w-9 h-9 rounded-full items-center justify-center font-bold text-lg shadow"
                            >
                                ✓
                            </div>


                            <!-- Image -->
                            <div class="h-52 bg-gray-100">

                                @if ($sweet->images->count())

                                    <img
                                        src="{{ asset('storage/' . $sweet->images->first()->image_path) }}"
                                        alt="{{ $sweet->name }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-400"
                                    >
                                        No Image
                                    </div>

                                @endif

                            </div>


                            <!-- Sweet Info -->
                            <div class="p-4">

                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $sweet->name }}
                                </h3>

                                <p class="text-pink-600 font-bold mt-2">
                                    {{ number_format($sweet->price ?? 0, 2) }}
                                </p>

                            </div>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="bg-gray-50 rounded-lg p-5 text-gray-500">
                    No sweets available for this hall.
                </div>

            @endif

        </div>


        <!-- PRICE SUMMARY -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                Reservation Summary
            </h2>


            <div class="space-y-4">

                <!-- Hall -->
                <div class="flex items-center justify-between border-b pb-3">

                    <span class="text-gray-600">
                        Hall Price
                    </span>

                    <span
                        id="hallPrice"
                        class="font-bold text-gray-800"
                    >
                        {{ number_format($hall->price ?? 0, 2) }}
                    </span>

                </div>


                <!-- Food -->
                <div class="flex items-center justify-between border-b pb-3">

                    <span class="text-gray-600">
                        Food
                    </span>

                    <span
                        id="foodPrice"
                        class="font-bold text-gray-800"
                    >
                        0.00
                    </span>

                </div>


                <!-- Sweets -->
                <div class="flex items-center justify-between border-b pb-3">

                    <span class="text-gray-600">
                        Sweets
                    </span>

                    <span
                        id="sweetPrice"
                        class="font-bold text-gray-800"
                    >
                        0.00
                    </span>

                </div>


                <!-- Total -->
                <div class="flex items-center justify-between border-b pb-3">

                    <span class="text-lg font-bold text-gray-800">
                        Total Price
                    </span>

                    <span
                        id="totalPrice"
                        class="text-2xl font-bold text-blue-600"
                    >
                        {{ number_format($hall->price ?? 0, 2) }}
                    </span>

                </div>


                <!-- Deposit -->
                <div class="flex items-center justify-between">

                    <div>

                        <span class="text-lg font-bold text-gray-800">
                            Deposit
                        </span>

                        <p class="text-sm text-gray-500">
                            20% of total price
                        </p>

                    </div>

                    <span
                        id="depositPrice"
                        class="text-2xl font-bold text-green-600"
                    >
                        {{ number_format(($hall->price ?? 0) * 0.20, 2) }}
                    </span>

                </div>

            </div>

        </div>


        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">

            <a
                href="{{ route('customer.halls.show', $hall) }}"
                class="w-full sm:w-auto px-6 py-3 bg-gray-500 text-white rounded-lg text-center font-semibold hover:bg-gray-600 transition"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="w-full sm:flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition"
            >
                Confirm Reservation
            </button>

        </div>

    </form>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | Booked Reservations
    |--------------------------------------------------------------------------
    */

    const bookedReservations =
        @json($bookedReservations);


    /*
    |--------------------------------------------------------------------------
    | Calendar Variables
    |--------------------------------------------------------------------------
    */

    const calendarTitle =
        document.getElementById('calendarTitle');

    const calendarDays =
        document.getElementById('calendarDays');

    const reservationDateInput =
        document.getElementById('reservation_date');

    const previousMonthButton =
        document.getElementById('previousMonth');

    const nextMonthButton =
        document.getElementById('nextMonth');

    const hourSlots =
        document.getElementById('hourSlots');


    let currentDate = new Date();


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    function formatDate(date)
    {
        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Reservations For Date
    |--------------------------------------------------------------------------
    */

    function getReservationsForDate(dateString)
    {
        return bookedReservations
            .filter(function (reservation) {

                const reservationDate =
                    String(
                        reservation.reservation_date
                    ).substring(0, 10);

                return reservationDate === dateString;

            })
            .map(function (reservation) {

                return {

                    date:
                        String(
                            reservation.reservation_date
                        ).substring(0, 10),

                    start:
                        String(
                            reservation.start_time
                        ).substring(0, 5),

                    end:
                        String(
                            reservation.end_time
                        ).substring(0, 5)

                };

            });
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Hour Is Booked
    |--------------------------------------------------------------------------
    */

    function isHourBooked(
        dateString,
        hour
    )
    {
        const reservations =
            getReservationsForDate(
                dateString
            );


        const hourStart =
            `${String(hour).padStart(2, '0')}:00`;

        const hourEnd =
            `${String(hour + 1).padStart(2, '0')}:00`;


        return reservations.some(
            function (reservation) {

                return (
                    reservation.start < hourEnd &&
                    reservation.end > hourStart
                );

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Render Calendar
    |--------------------------------------------------------------------------
    */

    function renderCalendar()
    {
        calendarDays.innerHTML = '';


        const year =
            currentDate.getFullYear();

        const month =
            currentDate.getMonth();


        const monthName =
            currentDate.toLocaleString(
                'default',
                {
                    month: 'long'
                }
            );


        calendarTitle.textContent =
            `${monthName} ${year}`;


        const firstDay =
            new Date(
                year,
                month,
                1
            ).getDay();


        const daysInMonth =
            new Date(
                year,
                month + 1,
                0
            ).getDate();


        /*
        |--------------------------------------------------------------------------
        | Empty Days
        |--------------------------------------------------------------------------
        */

        for (
            let i = 0;
            i < firstDay;
            i++
        ) {

            const empty =
                document.createElement('div');

            calendarDays.appendChild(
                empty
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Calendar Days
        |--------------------------------------------------------------------------
        */

        for (
            let day = 1;
            day <= daysInMonth;
            day++
        ) {

            const date =
                new Date(
                    year,
                    month,
                    day
                );


            const dateString =
                formatDate(date);


            const button =
                document.createElement('button');


            button.type =
                'button';


            button.textContent =
                day;


            button.dataset.date =
                dateString;


            button.className =
                'h-12 rounded-lg border text-sm font-semibold transition';


            const reservations =
                getReservationsForDate(
                    dateString
                );


            /*
            |--------------------------------------------------------------------------
            | Fully Booked
            |--------------------------------------------------------------------------
            */

            if (reservations.length > 0) {

                button.classList.add(
                    'bg-red-100',
                    'border-red-300',
                    'text-red-700'
                );

                button.title =
                    'This date has reservations.';

            }
            else {

                button.classList.add(
                    'bg-green-50',
                    'border-green-300',
                    'text-green-700',
                    'hover:bg-green-100'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Selected Date
            |--------------------------------------------------------------------------
            */

            if (
                reservationDateInput.value ===
                dateString
            ) {

                button.classList.add(
                    'ring-2',
                    'ring-blue-500'
                );

            }


            button.addEventListener(
                'click',
                function () {

                    selectDate(
                        dateString
                    );

                }
            );


            calendarDays.appendChild(
                button
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Select Date
    |--------------------------------------------------------------------------
    */

    function selectDate(
        dateString
    )
    {
        reservationDateInput.value =
            dateString;


        renderCalendar();


        renderHours();

    }


    /*
    |--------------------------------------------------------------------------
    | Render Hours
    |--------------------------------------------------------------------------
    */

    function renderHours()
    {
        hourSlots.innerHTML = '';


        if (!reservationDateInput.value) {

            hourSlots.innerHTML =
                '<p class="col-span-full text-gray-500">Please select a date first.</p>';

            return;

        }


        const selectedDate =
            reservationDateInput.value;


        /*
        |--------------------------------------------------------------------------
        | Hours From 08:00 To 23:00
        |--------------------------------------------------------------------------
        */

        for (
            let hour = 8;
            hour < 23;
            hour++
        ) {

            const start =
                `${String(hour).padStart(2, '0')}:00`;

            const end =
                `${String(hour + 1).padStart(2, '0')}:00`;


            const booked =
                isHourBooked(
                    selectedDate,
                    hour
                );


            const button =
                document.createElement('button');


            button.type =
                'button';


            button.textContent =
                `${start} - ${end}`;


            button.className =
                'px-3 py-3 rounded-lg border text-sm font-semibold transition';


            if (booked) {

                button.disabled =
                    true;

                button.classList.add(
                    'bg-red-100',
                    'border-red-300',
                    'text-red-600',
                    'cursor-not-allowed'
                );

                button.title =
                    'This time is already booked.';

            }
            else {

                button.classList.add(
                    'bg-green-50',
                    'border-green-300',
                    'text-green-700',
                    'hover:bg-green-100'
                );


                button.addEventListener(
                    'click',
                    function () {

                        document.getElementById(
                            'start_time'
                        ).value = start;


                        document.getElementById(
                            'end_time'
                        ).value = end;

                    }
                );

            }


            hourSlots.appendChild(
                button
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Previous Month
    |--------------------------------------------------------------------------
    */

    previousMonthButton.addEventListener(
        'click',
        function () {

            currentDate.setMonth(
                currentDate.getMonth() - 1
            );

            renderCalendar();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Next Month
    |--------------------------------------------------------------------------
    */

    nextMonthButton.addEventListener(
        'click',
        function () {

            currentDate.setMonth(
                currentDate.getMonth() + 1
            );

            renderCalendar();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Date Input Change
    |--------------------------------------------------------------------------
    */

    reservationDateInput.addEventListener(
        'change',
        function () {

            const selectedDate =
                new Date(
                    this.value + 'T00:00:00'
                );


            if (
                !Number.isNaN(
                    selectedDate.getTime()
                )
            ) {

                currentDate =
                    selectedDate;

                renderCalendar();

                renderHours();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Price Calculation
    |--------------------------------------------------------------------------
    */

    function calculateTotal()
    {
        let foodTotal =
            0;

        let sweetTotal =
            0;


        /*
        |--------------------------------------------------------------------------
        | Food
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.food-checkbox:checked'
            )
            .forEach(
                function (checkbox) {

                    foodTotal +=
                        parseFloat(
                            checkbox.dataset.price || 0
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Sweets
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.sweet-checkbox:checked'
            )
            .forEach(
                function (checkbox) {

                    sweetTotal +=
                        parseFloat(
                            checkbox.dataset.price || 0
                        );

                }
            );


        const hallPrice =
            parseFloat(
                @json((float) ($hall->price ?? 0))
            );


        const total =
            hallPrice +
            foodTotal +
            sweetTotal;


        const deposit =
            total * 0.20;


        document.getElementById(
            'foodPrice'
        ).textContent =
            foodTotal.toFixed(2);


        document.getElementById(
            'sweetPrice'
        ).textContent =
            sweetTotal.toFixed(2);


        document.getElementById(
            'totalPrice'
        ).textContent =
            total.toFixed(2);


        document.getElementById(
            'depositPrice'
        ).textContent =
            deposit.toFixed(2);

    }


    /*
    |--------------------------------------------------------------------------
    | Food Card Selection
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.food-card')
        .forEach(
            function (card) {

                const checkbox =
                    card.querySelector(
                        '.food-checkbox'
                    );

                const check =
                    card.querySelector(
                        '.food-check'
                    );


                function updateFoodCard()
                {
                    if (checkbox.checked) {

                        card.classList.remove(
                            'border-gray-200'
                        );

                        card.classList.add(
                            'border-green-500',
                            'ring-2',
                            'ring-green-200'
                        );


                        check.classList.remove(
                            'hidden'
                        );

                        check.classList.add(
                            'flex'
                        );

                    }
                    else {

                        card.classList.remove(
                            'border-green-500',
                            'ring-2',
                            'ring-green-200'
                        );

                        card.classList.add(
                            'border-gray-200'
                        );


                        check.classList.remove(
                            'flex'
                        );

                        check.classList.add(
                            'hidden'
                        );

                    }

                    calculateTotal();

                }


                card.addEventListener(
                    'click',
                    function () {

                        checkbox.checked =
                            !checkbox.checked;

                        updateFoodCard();

                    }
                );


                checkbox.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );


                updateFoodCard();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Sweet Card Selection
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.sweet-card')
        .forEach(
            function (card) {

                const checkbox =
                    card.querySelector(
                        '.sweet-checkbox'
                    );

                const check =
                    card.querySelector(
                        '.sweet-check'
                    );


                function updateSweetCard()
                {
                    if (checkbox.checked) {

                        card.classList.remove(
                            'border-gray-200'
                        );

                        card.classList.add(
                            'border-green-500',
                            'ring-2',
                            'ring-green-200'
                        );


                        check.classList.remove(
                            'hidden'
                        );

                        check.classList.add(
                            'flex'
                        );

                    }
                    else {

                        card.classList.remove(
                            'border-green-500',
                            'ring-2',
                            'ring-green-200'
                        );

                        card.classList.add(
                            'border-gray-200'
                        );


                        check.classList.remove(
                            'flex'
                        );

                        check.classList.add(
                            'hidden'
                        );

                    }

                    calculateTotal();

                }


                card.addEventListener(
                    'click',
                    function () {

                        checkbox.checked =
                            !checkbox.checked;

                        updateSweetCard();

                    }
                );


                checkbox.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );


                updateSweetCard();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Start / End Time Validation
    |--------------------------------------------------------------------------
    */

    const startTimeInput =
        document.getElementById(
            'start_time'
        );

    const endTimeInput =
        document.getElementById(
            'end_time'
        );


    startTimeInput.addEventListener(
        'change',
        function () {

            if (
                endTimeInput.value &&
                endTimeInput.value <= this.value
            ) {

                endTimeInput.value = '';

            }

        }
    );


    endTimeInput.addEventListener(
        'change',
        function () {

            if (
                startTimeInput.value &&
                this.value <= startTimeInput.value
            ) {

                alert(
                    'End time must be after start time.'
                );

                this.value = '';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Page
    |--------------------------------------------------------------------------
    */

    if (reservationDateInput.value) {

        currentDate =
            new Date(
                reservationDateInput.value +
                'T00:00:00'
            );

    }


    renderCalendar();

    renderHours();

    calculateTotal();

</script>

</body>

</html>
