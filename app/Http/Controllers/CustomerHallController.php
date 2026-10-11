<?php
namespace App\Http\Controllers;

use App\Models\Hall;

class CustomerHallController extends Controller
{
    /**
     * Display all active halls.
     */
    public function index()
    {
        $halls = Hall::with(['images',])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('customer.halls.index',compact('halls'));
    }

    /**
     * Display one active hall.
     */
    public function show(Hall $hall)
    {
        
        abort_if($hall->status !== 'active',404);

        $hall->load([
            'images',
            'foods.images',
            'sweetItems.images',
        ]);

        return view('customer.halls.show',compact('hall'));
    }
}
