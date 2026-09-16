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
        $hallIds = $hallManager->halls()->pluck('id');
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addYear();
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

