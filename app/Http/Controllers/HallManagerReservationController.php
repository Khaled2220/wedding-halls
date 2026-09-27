<?php

namespace App\Http\Controllers;

use App\Services\HallManager\HallManagerService;
use Illuminate\Support\Facades\Auth;

class HallManagerReservationController extends Controller
{
    public function __construct(private HallManagerService $hallManagerService) 
    {
        //
    }

    public function index()
    {
        $data = $this->hallManagerService->getReservationsCalendarData(Auth::id());

        return view('hall-manager.reservations.index',$data);
    }
}