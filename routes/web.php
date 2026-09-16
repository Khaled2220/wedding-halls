<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\CustomerHallController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\HallManagerReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\Foods\FoodController;
use App\Http\Controllers\Foods\SweetController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
});


/*
* Hall Manager Dashboard
*/
Route::get('/hall-manager/dashboard', function () {
    return redirect()->route('hall-manager.sweets.index');
})
    ->middleware(['auth', 'verified'])
    ->name('hall-manager.dashboard');


/*
| Worker Dashboard
*/
Route::get(
    '/worker/dashboard',
    [WorkerController::class, 'dashboard']
)
    ->middleware(['auth', 'verified'])
    ->name('worker.dashboard');


/*
| Profile
*/
Route::middleware('auth')->group(function () {
    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});


/*
| Hall Manager
*/
Route::middleware(['auth', 'verified'])
    ->prefix('hall-manager')
    ->name('hall-manager.')
    ->group(function () {

        /*
        | Halls
        */
        Route::resource(
            'halls',HallController::class
        );


        /*
        | Foods
        */
        Route::resource(
            'foods',FoodController::class
        );


        /*
        | Sweets
        */
        Route::resource(
            'sweets',SweetController::class
        );


        /*
        | Reservations
        */
        Route::get(
            '/reservations',
            [HallManagerReservationController::class, 'index']
        )->name('reservations.index');
    });


/*
| Customer Halls
*/
Route::get(
    '/customer/halls',
    [CustomerHallController::class, 'index']
)->name('customer.halls.index');


Route::get(
    '/customer/halls/{hall}',
    [CustomerHallController::class, 'show']
)->name('customer.halls.show');


/*
| Customer
*/
Route::middleware(['auth', 'verified'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        /*
        | Customer Reservations List
        */
        Route::get(
            '/reservations',
            [ReservationController::class, 'index']
        )->name('reservations.index');


        /*
        | Create Reservation
        */
        Route::get(
            '/halls/{hall}/reserve',
            [ReservationController::class, 'create']
        )->name('reservations.create');


        /*
        | Store Reservation
        */
        Route::post(
            '/halls/{hall}/reserve',
            [ReservationController::class, 'store']
        )->name('reservations.store');


        /*
        | Show Reservation
        */
        Route::get(
            '/reservations/{reservation}',
            [ReservationController::class, 'show']
        )->name('reservations.show');


        /*
        | Edit Food & Sweets
        */
        Route::get(
            '/reservations/{reservation}/edit-food-sweets',
            [ReservationController::class, 'editFoodSweets']
        )->name('reservations.edit-food-sweets');


        /*
        | Update Food & Sweets
        */
        Route::put(
            '/reservations/{reservation}/food-sweets',
            [ReservationController::class, 'updateFoodSweets']
        )->name('reservations.update-food-sweets');


        /*
        | Edit Reservation Date
        */
        Route::get(
            '/reservations/{reservation}/edit-date',
            [ReservationController::class, 'editDate']
        )->name('reservations.edit-date');


        /*
        | Update Reservation Date
        */
        Route::put(
            '/reservations/{reservation}/date',
            [ReservationController::class, 'updateDate']
        )->name('reservations.update-date');


        /*
        | Payment Checkout
        */
        Route::get(
            '/payments/{reservation}',
            [PaymentController::class, 'checkout']
        )->name('payments.checkout');


        /*
        | Process Payment
        */
        Route::post(
            '/payments/{reservation}',
            [PaymentController::class, 'process']
        )->name('payments.process');


        /*
        | Payment Success
        */
        Route::get(
            '/payments/success/{reservation}',
            [PaymentController::class, 'success']
        )->name('payments.success');


        /*
        | Payment Cancel
        */
        Route::get(
            '/payments/cancel/{reservation}',
            [PaymentController::class, 'cancel']
        )->name('payments.cancel');

    });


/*
| Authentication
*/
require __DIR__ . '/auth.php';