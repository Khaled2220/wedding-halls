<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Notifications\ReservationCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendReservationCreatedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(Reservation $reservation)
    {
         $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customer = $this->reservation->customer;
         if (!$customer || !$customer->email) {
            return;
        }
        Notification::route('mail', $customer->email)
            ->notify(
                new ReservationCreatedNotification(
                    $this->reservation
                )
            );
    }
}
