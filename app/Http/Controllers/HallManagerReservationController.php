<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HallManagerReservationController extends Controller
{
    public function index()
    {
        $hallManager = Auth::user();

        // Get halls belonging to this hall manager
        $hallIds = $hallManager->halls()->pluck('id');

        // Today
        $startDate = Carbon::today();

        // One year from today
        $endDate = Carbon::today()->addYear();

        // Get reservations for this manager's halls
        $reservations = Reservation::with([
            'customer',
            'hall',
        ])
            ->whereIn('hall_id', $hallIds)
            ->whereBetween('reservation_date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ])
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->get();

        // Group reservations by date
        $reservationsByDate = $reservations->groupBy(function ($reservation) {
            return Carbon::parse($reservation->reservation_date)
                ->format('Y-m-d');
        });

        return view(
            'hall-manager.reservations.index',
            compact(
                'reservationsByDate',
                'startDate',
                'endDate'
            )
        );
    }
}

