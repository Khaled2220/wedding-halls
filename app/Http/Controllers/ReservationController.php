<?php

namespace App\Http\Controllers;

use App\Events\ReservationCreated;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Foods\Food;
use App\Models\Foods\Sweet;
use App\Models\Hall;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private const DEPOSIT_PERCENTAGE = 20;



    /*
    |--------------------------------------------------------------------------
    | Reservations List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $reservations = Reservation::with([
            'hall',
            'foods',
            'sweets',
        ])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view(
            'customer.reservations.index',
            compact('reservations')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Show Reservation Form
    |--------------------------------------------------------------------------
    */

    public function create(Hall $hall)
    {
        abort_unless(
            $hall->status === 'active',
            404
        );

        $hall->load([
            'foods.images',
            'sweetItems.images',
        ]);

        $bookedReservations = Reservation::where(
                'hall_id',
                $hall->id
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->get([
                'id',
                'reservation_date',
                'start_time',
                'end_time',
            ]);

        return view(
            'customer.reservations.create',
            compact(
                'hall',
                'bookedReservations'
            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Store Reservation
    |--------------------------------------------------------------------------
    */

    public function store(
        StoreReservationRequest $request,
        Hall $hall
    ) {
        abort_unless(
            $hall->status === 'active',
            404
        );

        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | Check Guests Capacity
        |--------------------------------------------------------------------------
        */

        if ($validated['guests'] > $hall->capacity) {

            return back()
                ->withInput()
                ->withErrors([
                    'guests' =>
                        'The number of guests cannot exceed the hall capacity.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Get Selected Foods
        |--------------------------------------------------------------------------
        */

        $foodIds = $validated['food_ids'] ?? [];

        $foods = Food::whereIn(
                'id',
                $foodIds
            )
            ->where(
                'hall_id',
                $hall->id
            )
            ->get();

        if ($foods->count() !== count($foodIds)) {

            return back()
                ->withInput()
                ->withErrors([
                    'food_ids' =>
                        'One or more selected food items are invalid.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Get Selected Sweets
        |--------------------------------------------------------------------------
        */

        $sweetIds = $validated['sweet_ids'] ?? [];

        $sweets = Sweet::whereIn(
                'id',
                $sweetIds
            )
            ->where(
                'hall_id',
                $hall->id
            )
            ->get();

        if ($sweets->count() !== count($sweetIds)) {

            return back()
                ->withInput()
                ->withErrors([
                    'sweet_ids' =>
                        'One or more selected sweet items are invalid.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Check Hall Availability
        |--------------------------------------------------------------------------
        */

        $alreadyBooked = Reservation::where(
                'hall_id',
                $hall->id
            )
            ->whereDate(
                'reservation_date',
                $validated['reservation_date']
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->where(function ($query) use ($validated) {

                $query
                    ->where(
                        'start_time',
                        '<',
                        $validated['end_time']
                    )
                    ->where(
                        'end_time',
                        '>',
                        $validated['start_time']
                    );

            })
            ->exists();

        if ($alreadyBooked) {

            return back()
                ->withInput()
                ->withErrors([
                    'reservation_date' =>
                        'This hall is already reserved during the selected time.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Calculate Total Price
        |--------------------------------------------------------------------------
        */

        $hallPrice = (float) $hall->price;

        $foodTotal = (float) $foods->sum(
            fn ($food) =>
                (float) $food->price
        );

        $sweetTotal = (float) $sweets->sum(
            fn ($sweet) =>
                (float) $sweet->price
        );

        $totalPrice = round(
            $hallPrice +
            $foodTotal +
            $sweetTotal,
            2
        );



        /*
        |--------------------------------------------------------------------------
        | Calculate Deposit
        |--------------------------------------------------------------------------
        */

        $depositAmount = round(
            $totalPrice *
            (self::DEPOSIT_PERCENTAGE / 100),
            2
        );



        /*
        |--------------------------------------------------------------------------
        | Create Reservation
        |--------------------------------------------------------------------------
        */

        $reservation = DB::transaction(function () use (
            $validated,
            $hall,
            $foods,
            $sweets,
            $totalPrice,
            $depositAmount
        ) {

            $reservation = Reservation::create([

                'customer_id' =>
                    auth()->id(),

                'hall_id' =>
                    $hall->id,

                'reservation_date' =>
                    $validated['reservation_date'],

                'start_time' =>
                    $validated['start_time'],

                'end_time' =>
                    $validated['end_time'],

                'guests' =>
                    $validated['guests'],

                'total_price' =>
                    $totalPrice,

                'deposit_amount' =>
                    $depositAmount,

                'status' =>
                    'pending',

            ]);



            /*
            |--------------------------------------------------------------------------
            | Save Selected Foods
            |--------------------------------------------------------------------------
            */

            foreach ($foods as $food) {

                $reservation->foods()->attach(
                    $food->id,
                    [
                        'price' =>
                            $food->price,
                    ]
                );
            }



            /*
            |--------------------------------------------------------------------------
            | Save Selected Sweets
            |--------------------------------------------------------------------------
            */

            foreach ($sweets as $sweet) {

                $reservation->sweets()->attach(
                    $sweet->id,
                    [
                        'price' =>
                            $sweet->price,
                    ]
                );
            }



            return $reservation;
        });



        /*
        |--------------------------------------------------------------------------
        | Reservation Created Event
        |--------------------------------------------------------------------------
        */

        event(
            new ReservationCreated($reservation)
        );



        /*
        |--------------------------------------------------------------------------
        | Redirect to Reservation Details
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'customer.reservations.show',
                $reservation
            )
            ->with(
                'success',
                'Reservation created successfully and is pending confirmation.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Reservation Details
    |--------------------------------------------------------------------------
    */

    public function show(Reservation $reservation)
    {
        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );

        $reservation->load([
            'hall',
            'foods.images',
            'sweets.images',
            'payment',
        ]);

        return view(
            'customer.reservations.show',
            compact('reservation')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Edit Food & Sweets
    |--------------------------------------------------------------------------
    */

    public function editFoodSweets(
        Reservation $reservation
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make Sure Reservation Belongs To Customer
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );



        /*
        |--------------------------------------------------------------------------
        | Only Pending Reservations Can Be Edited
        |--------------------------------------------------------------------------
        */

        if ($reservation->status !== 'pending') {

            return redirect()
                ->route(
                    'customer.reservations.show',
                    $reservation
                )
                ->with(
                    'error',
                    'Food and sweets can only be updated while the reservation is pending.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Load Reservation Data
        |--------------------------------------------------------------------------
        */

        $reservation->load([
            'hall',
            'foods',
            'sweets',
        ]);



        /*
        |--------------------------------------------------------------------------
        | Get Foods For This Hall Only
        |--------------------------------------------------------------------------
        */

        $foods = Food::where(
                'hall_id',
                $reservation->hall_id
            )
            ->with('images')
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Get Sweets For This Hall Only
        |--------------------------------------------------------------------------
        */

        $sweets = Sweet::where(
                'hall_id',
                $reservation->hall_id
            )
            ->with('images')
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Show Edit Page
        |--------------------------------------------------------------------------
        */

        return view(
            'customer.reservations.edit-food-sweets',
            compact(
                'reservation',
                'foods',
                'sweets'
            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Update Food & Sweets
    |--------------------------------------------------------------------------
    */

    public function updateFoodSweets(
        Request $request,
        Reservation $reservation
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make Sure Reservation Belongs To Customer
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );



        /*
        |--------------------------------------------------------------------------
        | Only Pending Reservations Can Be Updated
        |--------------------------------------------------------------------------
        */

        if ($reservation->status !== 'pending') {

            return redirect()
                ->route(
                    'customer.reservations.show',
                    $reservation
                )
                ->with(
                    'error',
                    'Food and sweets can only be updated while the reservation is pending.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'food_ids' =>
                'nullable|array',

            'food_ids.*' =>
                'integer|exists:foods,id',

            'sweet_ids' =>
                'nullable|array',

            'sweet_ids.*' =>
                'integer|exists:sweets,id',

        ]);



        /*
        |--------------------------------------------------------------------------
        | Selected Food IDs
        |--------------------------------------------------------------------------
        */

        $foodIds = $validated['food_ids'] ?? [];



        /*
        |--------------------------------------------------------------------------
        | Get Selected Foods For This Hall
        |--------------------------------------------------------------------------
        */

        $foods = Food::whereIn(
                'id',
                $foodIds
            )
            ->where(
                'hall_id',
                $reservation->hall_id
            )
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Validate Food Ownership
        |--------------------------------------------------------------------------
        */

        if ($foods->count() !== count($foodIds)) {

            return back()
                ->withInput()
                ->withErrors([
                    'food_ids' =>
                        'One or more selected food items do not belong to this hall.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Selected Sweet IDs
        |--------------------------------------------------------------------------
        */

        $sweetIds = $validated['sweet_ids'] ?? [];



        /*
        |--------------------------------------------------------------------------
        | Get Selected Sweets For This Hall
        |--------------------------------------------------------------------------
        */

        $sweets = Sweet::whereIn(
                'id',
                $sweetIds
            )
            ->where(
                'hall_id',
                $reservation->hall_id
            )
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Validate Sweet Ownership
        |--------------------------------------------------------------------------
        */

        if ($sweets->count() !== count($sweetIds)) {

            return back()
                ->withInput()
                ->withErrors([
                    'sweet_ids' =>
                        'One or more selected sweet items do not belong to this hall.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Get Hall
        |--------------------------------------------------------------------------
        */

        $hall = Hall::findOrFail(
            $reservation->hall_id
        );



        /*
        |--------------------------------------------------------------------------
        | Calculate New Total
        |--------------------------------------------------------------------------
        */

        $hallPrice = (float) $hall->price;

        $foodTotal = (float) $foods->sum(
            fn ($food) =>
                (float) $food->price
        );

        $sweetTotal = (float) $sweets->sum(
            fn ($sweet) =>
                (float) $sweet->price
        );

        $totalPrice = round(
            $hallPrice +
            $foodTotal +
            $sweetTotal,
            2
        );



        /*
        |--------------------------------------------------------------------------
        | Calculate New Deposit
        |--------------------------------------------------------------------------
        */

        $depositAmount = round(
            $totalPrice *
            (self::DEPOSIT_PERCENTAGE / 100),
            2
        );



        /*
        |--------------------------------------------------------------------------
        | Update Reservation
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $reservation,
            $foods,
            $sweets,
            $totalPrice,
            $depositAmount
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Total & Deposit
            |--------------------------------------------------------------------------
            */

            $reservation->update([

                'total_price' =>
                    $totalPrice,

                'deposit_amount' =>
                    $depositAmount,

            ]);



            /*
            |--------------------------------------------------------------------------
            | Remove Old Foods
            |--------------------------------------------------------------------------
            */

            $reservation->foods()->detach();



            /*
            |--------------------------------------------------------------------------
            | Add New Foods
            |--------------------------------------------------------------------------
            */

            foreach ($foods as $food) {

                $reservation->foods()->attach(
                    $food->id,
                    [
                        'price' =>
                            $food->price,
                    ]
                );
            }



            /*
            |--------------------------------------------------------------------------
            | Remove Old Sweets
            |--------------------------------------------------------------------------
            */

            $reservation->sweets()->detach();



            /*
            |--------------------------------------------------------------------------
            | Add New Sweets
            |--------------------------------------------------------------------------
            */

            foreach ($sweets as $sweet) {

                $reservation->sweets()->attach(
                    $sweet->id,
                    [
                        'price' =>
                            $sweet->price,
                    ]
                );
            }

        });



        /*
        |--------------------------------------------------------------------------
        | Redirect To Reservation Details
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'customer.reservations.show',
                $reservation
            )
            ->with(
                'success',
                'Food and sweets updated successfully.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Edit Reservation Date
    |--------------------------------------------------------------------------
    */

    public function editDate(
        Reservation $reservation
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make Sure Reservation Belongs To Customer
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );



        /*
        |--------------------------------------------------------------------------
        | Only Pending Reservations Can Be Changed
        |--------------------------------------------------------------------------
        */

        if ($reservation->status !== 'pending') {

            return redirect()
                ->route(
                    'customer.reservations.index'
                )
                ->with(
                    'error',
                    'Only pending reservations can be changed.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Check 14 Days Rule
        |--------------------------------------------------------------------------
        */

        $reservationDate = Carbon::parse(
            $reservation->reservation_date
        )->startOfDay();

        $today = Carbon::today();

        $daysUntilReservation = $today->diffInDays(
            $reservationDate,
            false
        );



        if ($daysUntilReservation < 14) {

            return redirect()
                ->route(
                    'customer.reservations.index'
                )
                ->with(
                    'error',
                    'You cannot change the reservation date less than 14 days in advance.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Show Edit Date Page
        |--------------------------------------------------------------------------
        */

        return view(
            'customer.reservations.edit-date',
            compact('reservation')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Update Reservation Date
    |--------------------------------------------------------------------------
    */

    public function updateDate(
        Request $request,
        Reservation $reservation
    ) {

        /*
        |--------------------------------------------------------------------------
        | Make Sure Reservation Belongs To Customer
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );



        /*
        |--------------------------------------------------------------------------
        | Only Pending Reservations Can Be Updated
        |--------------------------------------------------------------------------
        */

        if ($reservation->status !== 'pending') {

            return redirect()
                ->route(
                    'customer.reservations.index'
                )
                ->with(
                    'error',
                    'Only pending reservations can be changed.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Check Original Reservation Is Still 14+ Days Away
        |--------------------------------------------------------------------------
        */

        $currentReservationDate = Carbon::parse(
            $reservation->reservation_date
        )->startOfDay();

        $today = Carbon::today();

        $daysUntilReservation = $today->diffInDays(
            $currentReservationDate,
            false
        );



        if ($daysUntilReservation < 14) {

            return redirect()
                ->route(
                    'customer.reservations.index'
                )
                ->with(
                    'error',
                    'You cannot change the reservation date less than 14 days in advance.'
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Validate New Date
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:' .
                    now()
                        ->addDays(14)
                        ->format('Y-m-d'),
            ],

        ]);



        /*
        |--------------------------------------------------------------------------
        | Parse New Date
        |--------------------------------------------------------------------------
        */

        $newDate = Carbon::parse(
            $validated['reservation_date']
        )->startOfDay();



        /*
        |--------------------------------------------------------------------------
        | Make Sure New Date Is Different
        |--------------------------------------------------------------------------
        */

        if ($newDate->equalTo($currentReservationDate)) {

            return back()
                ->withErrors([
                    'reservation_date' =>
                        'The new date must be different from the current reservation date.',
                ])
                ->withInput();
        }



        /*
        |--------------------------------------------------------------------------
        | Check Hall Availability
        |--------------------------------------------------------------------------
        */

        $conflictingReservation = Reservation::where(
                'hall_id',
                $reservation->hall_id
            )
            ->where(
                'id',
                '!=',
                $reservation->id
            )
            ->whereDate(
                'reservation_date',
                $newDate->format('Y-m-d')
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->where(function ($query) use ($reservation) {

                $query
                    ->where(
                        'start_time',
                        '<',
                        $reservation->end_time
                    )
                    ->where(
                        'end_time',
                        '>',
                        $reservation->start_time
                    );

            })
            ->exists();



        if ($conflictingReservation) {

            return back()
                ->withInput()
                ->withErrors([
                    'reservation_date' =>
                        'This date is already booked for this hall during the selected time.',
                ]);
        }



        /*
        |--------------------------------------------------------------------------
        | Update Reservation Date
        |--------------------------------------------------------------------------
        */

        $reservation->update([

            'reservation_date' =>
                $newDate->format('Y-m-d'),

        ]);



        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'customer.reservations.index'
            )
            ->with(
                'success',
                'Reservation date updated successfully.'
            );
    }
}