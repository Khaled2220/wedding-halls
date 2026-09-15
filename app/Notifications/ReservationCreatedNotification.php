<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $reservation = $this->reservation;
        $reservation->loadMissing('hall');
        return (new MailMessage)
            ->subject('Booking Hall Successfully')
            ->greeting('Hello ' . ($notifiable->name ?? 'Customer') . ',')
            ->line('Your hall reservation has been created successfully.')
            ->line('Hall: ' . $reservation->hall->name)
            ->line('Date: ' . $reservation->reservation_date)
            ->line('Time: ' . $reservation->start_time . ' - ' . $reservation->end_time)    
            ->line('Guests: ' . $reservation->guests)
            ->line('Total Price: ' . $reservation->total_price . ' JD')  
            ->line('Deposit Amount: ' . $reservation->deposit_amount . ' JD')
            ->line('Status: ' . ucfirst($reservation->status))
            ->action('View Reservation', route('customer.reservations.show', $reservation))
            ->line('Thank you for booking with Wedding Halls.');
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}