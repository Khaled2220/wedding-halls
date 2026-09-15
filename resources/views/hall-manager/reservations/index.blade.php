<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservations Calendar</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-6xl mx-auto py-10 px-4">

    {{-- Header --}}
    <div class="mb-8">

        <div class="flex items-center justify-between mb-4">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Reservations Calendar
                </h1>

                <p class="text-gray-600 mt-2">
                    View reservations from today until one year ahead.
                </p>

            </div>

            {{-- Back Link --}}
            <a
                href="{{ route('hall-manager.halls.index') }}"
                class="text-blue-600 hover:text-blue-800 font-semibold"
            >
                ← Back to Halls
            </a>

        </div>

    </div>


    {{-- Calendar --}}
    <div
        class="bg-white rounded-2xl shadow-lg p-6"
        x-data="reservationCalendar()"
        x-init="init()"
    >

        {{-- Calendar Header --}}
        <div class="flex items-center justify-between mb-6">

            <button
                type="button"
                @click="previousMonth()"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-semibold text-gray-700"
            >
                ←
            </button>

            <h2
                class="text-2xl font-bold text-gray-800"
                x-text="monthName"
            ></h2>

            <button
                type="button"
                @click="nextMonth()"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-semibold text-gray-700"
            >
                →
            </button>

        </div>


        {{-- Legend --}}
        <div class="flex items-center gap-5 mb-6">

            {{-- Reserved --}}
            <div class="flex items-center gap-2">

                <div class="w-4 h-4 rounded bg-red-500"></div>

                <span class="text-sm text-gray-600">
                    Reserved
                </span>

            </div>


            {{-- Available --}}
            <div class="flex items-center gap-2">

                <div class="w-4 h-4 rounded bg-gray-100 border"></div>

                <span class="text-sm text-gray-600">
                    Available
                </span>

            </div>

        </div>


        {{-- Calendar --}}
        <div class="grid grid-cols-7 border-t border-l">

            {{-- Week Days --}}
            <template
                x-for="day in weekDays"
                :key="day"
            >

                <div
                    class="p-3 text-center font-semibold text-gray-600 bg-gray-50 border-r border-b"
                    x-text="day"
                ></div>

            </template>


            {{-- Empty Days --}}
            <template
                x-for="empty in emptyDays"
                :key="'empty-' + empty"
            >

                <div class="min-h-24 border-r border-b bg-gray-50"></div>

            </template>


            {{-- Days --}}
            <template
                x-for="day in days"
                :key="day.date"
            >

                <div
                    @click="selectDay(day)"
                    class="min-h-24 border-r border-b p-2 cursor-pointer transition"
                    :class="{
                        'bg-red-500 text-white hover:bg-red-600': day.reserved,
                        'bg-white hover:bg-gray-50': !day.reserved,
                        'ring-2 ring-blue-500 ring-inset': day.today
                    }"
                >

                    <div class="flex justify-between items-start">

                        <span
                            class="font-semibold"
                            x-text="day.number"
                        ></span>


                        <span
                            x-show="day.reserved"
                            class="text-xs font-bold"
                        >
                            RESERVED
                        </span>

                    </div>


                    <div
                        x-show="day.reserved"
                        class="mt-3 text-xs"
                    >

                        <span
                            x-text="day.reservationCount + ' reservation(s)'"
                        ></span>

                    </div>

                </div>

            </template>

        </div>


        {{-- Selected Date --}}
        <div
            x-show="selectedDay"
            x-cloak
            class="mt-8 border-t pt-6"
        >

            <h3
                class="text-xl font-bold text-gray-800 mb-4"
                x-text="selectedDayTitle"
            ></h3>


            {{-- Reservation Details --}}
            <template
                x-for="reservation in selectedReservations"
                :key="reservation.id"
            >

                <div class="bg-gray-50 rounded-xl p-5 mb-4 border">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Customer --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Customer
                            </p>

                            <p
                                class="font-semibold text-gray-800"
                                x-text="reservation.customer"
                            ></p>

                            <p
                                class="text-sm text-gray-500"
                                x-text="reservation.email"
                            ></p>

                        </div>


                        {{-- Hall --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Hall
                            </p>

                            <p
                                class="font-semibold text-gray-800"
                                x-text="reservation.hall"
                            ></p>

                        </div>


                        {{-- Time --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Time
                            </p>

                            <p class="font-semibold text-gray-800">

                                <span
                                    x-text="reservation.start_time"
                                ></span>

                                -

                                <span
                                    x-text="reservation.end_time"
                                ></span>

                            </p>

                        </div>


                        {{-- Guests --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Guests
                            </p>

                            <p
                                class="font-semibold text-gray-800"
                                x-text="reservation.guests"
                            ></p>

                        </div>


                        {{-- Total Price --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Total Price
                            </p>

                            <p
                                class="font-semibold text-gray-800"
                                x-text="reservation.total_price"
                            ></p>

                        </div>


                        {{-- Status --}}
                        <div>

                            <p class="text-xs text-gray-500 uppercase">
                                Status
                            </p>

                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                                x-text="reservation.status"
                                :class="{
                                    'bg-green-100 text-green-800':
                                        reservation.status === 'confirmed',

                                    'bg-yellow-100 text-yellow-800':
                                        reservation.status === 'pending',

                                    'bg-red-100 text-red-800':
                                        reservation.status === 'cancelled',

                                    'bg-gray-100 text-gray-800':
                                        ![
                                            'confirmed',
                                            'pending',
                                            'cancelled'
                                        ].includes(reservation.status)
                                }"
                            ></span>

                        </div>

                    </div>

                </div>

            </template>


            {{-- No Reservations --}}
            <div
                x-show="selectedReservations.length === 0"
                class="bg-gray-50 rounded-xl p-6 text-center"
            >

                <p class="text-gray-500">
                    No Reservations for this date.
                </p>

            </div>

        </div>

    </div>

</div>


{{-- Alpine.js --}}
<script
    defer
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
></script>


<script>

function reservationCalendar()
{
    return {

        currentDate: new Date(),

        monthName: '',

        days: [],

        emptyDays: [],

        selectedDay: null,

        selectedDayTitle: '',

        selectedReservations: [],


        /*
        |--------------------------------------------------------------------------
        | Week Days
        |--------------------------------------------------------------------------
        */

        weekDays: [
            'Sun',
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat'
        ],


        /*
        |--------------------------------------------------------------------------
        | Reservations from Laravel
        |--------------------------------------------------------------------------
        */

        reservations: @json($reservationsByDate),


        /*
        |--------------------------------------------------------------------------
        | Date Limits
        |--------------------------------------------------------------------------
        */

        startDate: '{{ $startDate->format("Y-m-d") }}',

        endDate: '{{ $endDate->format("Y-m-d") }}',


        /*
        |--------------------------------------------------------------------------
        | Initialize
        |--------------------------------------------------------------------------
        */

        init()
        {
            this.currentDate = new Date();

            this.renderCalendar();
        },


        /*
        |--------------------------------------------------------------------------
        | Render Calendar
        |--------------------------------------------------------------------------
        */

        renderCalendar()
        {
            const year =
                this.currentDate.getFullYear();

            const month =
                this.currentDate.getMonth();


            /*
            |--------------------------------------------------------------------------
            | Month Name
            |--------------------------------------------------------------------------
            */

            this.monthName =
                new Date(
                    year,
                    month,
                    1
                ).toLocaleDateString(
                    'en-US',
                    {
                        month: 'long',
                        year: 'numeric'
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | First Day Of Month
            |--------------------------------------------------------------------------
            */

            const firstDay =
                new Date(
                    year,
                    month,
                    1
                ).getDay();


            /*
            |--------------------------------------------------------------------------
            | Number Of Days
            |--------------------------------------------------------------------------
            */

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

            this.emptyDays =
                Array.from(
                    {
                        length: firstDay
                    },
                    (_, index) => index
                );


            /*
            |--------------------------------------------------------------------------
            | Reset Days
            |--------------------------------------------------------------------------
            */

            this.days = [];


            /*
            |--------------------------------------------------------------------------
            | Create Calendar Days
            |--------------------------------------------------------------------------
            */

            for (
                let day = 1;
                day <= daysInMonth;
                day++
            )
            {

                const date =
                    `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;


                /*
                |--------------------------------------------------------------------------
                | Reservations For This Date
                |--------------------------------------------------------------------------
                */

                const reservations =
                    this.reservations[date] || [];


                /*
                |--------------------------------------------------------------------------
                | Today
                |--------------------------------------------------------------------------
                */

                const today =
                    date ===
                    new Date()
                        .toISOString()
                        .split('T')[0];


                /*
                |--------------------------------------------------------------------------
                | Add Day
                |--------------------------------------------------------------------------
                */

                this.days.push({

                    number: day,

                    date: date,

                    reserved:
                        reservations.length > 0,

                    reservationCount:
                        reservations.length,

                    today: today

                });

            }

        },


        /*
        |--------------------------------------------------------------------------
        | Previous Month
        |--------------------------------------------------------------------------
        */

        previousMonth()
        {
            const newDate =
                new Date(this.currentDate);


            newDate.setMonth(
                newDate.getMonth() - 1
            );


            const firstOfMonth =
                `${newDate.getFullYear()}-${String(newDate.getMonth() + 1).padStart(2, '0')}-01`;


            /*
            |--------------------------------------------------------------------------
            | Do Not Go Before Today
            |--------------------------------------------------------------------------
            */

            if (
                firstOfMonth < this.startDate
            )
            {
                return;
            }


            this.currentDate =
                newDate;


            this.selectedDay =
                null;


            this.selectedReservations =
                [];


            this.renderCalendar();
        },


        /*
        |--------------------------------------------------------------------------
        | Next Month
        |--------------------------------------------------------------------------
        */

        nextMonth()
        {
            const newDate =
                new Date(this.currentDate);


            newDate.setMonth(
                newDate.getMonth() + 1
            );


            const lastDayOfMonth =
                new Date(
                    newDate.getFullYear(),
                    newDate.getMonth() + 1,
                    0
                );


            const lastDate =
                `${lastDayOfMonth.getFullYear()}-${String(lastDayOfMonth.getMonth() + 1).padStart(2, '0')}-${String(lastDayOfMonth.getDate()).padStart(2, '0')}`;


            /*
            |--------------------------------------------------------------------------
            | Do Not Go After One Year
            |--------------------------------------------------------------------------
            */

            if (
                lastDate > this.endDate
            )
            {
                return;
            }


            this.currentDate =
                newDate;


            this.selectedDay =
                null;


            this.selectedReservations =
                [];


            this.renderCalendar();
        },


        /*
        |--------------------------------------------------------------------------
        | Select Day
        |--------------------------------------------------------------------------
        */

        selectDay(day)
        {
            this.selectedDay =
                day;


            this.selectedDayTitle =
                new Date(
                    day.date + 'T00:00:00'
                ).toLocaleDateString(
                    'en-US',
                    {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }
                );


            this.selectedReservations =
                this.reservations[day.date] || [];
        }

    };
}

</script>


</body>

</html>
