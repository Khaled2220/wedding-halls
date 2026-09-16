<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Reservation $reservation)
    {
        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );
        return view('customer.payments.checkout', compact('reservation'));
    }

    public function process(Request $request, Reservation $reservation)
    {
        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );
        return response()->json([
            'message' => 'Payment process will be connected to PayTabs next.',
            'reservation_id' => $reservation->id,
        ]);
    }

    public function success(Reservation $reservation)
    {
        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );
        return view('customer.payments.success', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        abort_unless(
            $reservation->customer_id === auth()->id(),
            403
        );
        return view('customer.payments.cancel', compact('reservation'));
    }
}