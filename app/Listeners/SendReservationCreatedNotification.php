<?php

namespace App\Listeners;

use App\Events\ReservationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendReservationCreatedEmail;


class SendReservationCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationCreated $event): void
    {
        SendReservationCreatedEmail::dispatch($event->reservation);
    }
}
