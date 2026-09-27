<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hall\StoreHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Models\Hall;
use App\Services\HallManager\HallManagerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HallController extends Controller
{
    public function __construct(private HallManagerService $hallManagerService) 
    {
        //
    }

    /**
     * Display halls belonging to the logged-in Hall Manager.
     */
    public function index(): View
    {
        $halls = $this->hallManagerService->getHalls(auth()->id());

        return view('hall-manager.halls.index',compact('halls'));
    }

    /**
     * Show the create hall form.
     */
    public function create(): View
    {
        return view('hall-manager.halls.create');
    }

    /**
     * Store a new hall.
     */
    public function store(StoreHallRequest $request): RedirectResponse 
    {
        $this->hallManagerService->createHall($request->validated(),$request,auth()->id());

        return redirect()->route('hall-manager.halls.index')
            ->with('success','Hall, food, sweet and images created successfully.');
    }

    /**
     * Display a hall.
     */
    public function show(Hall $hall): View
    {
        $hall = $this->hallManagerService->getHall($hall,auth()->id());

        return view('hall-manager.halls.show',compact('hall'));
    }

    /**
     * Show the edit hall form.
     */
    public function edit(Hall $hall): View
    {
        $hall = $this->hallManagerService->getHallForEdit($hall,auth()->id());

        return view('hall-manager.halls.edit',compact('hall'));
    }

    /**
     * Update a hall.
     */
    public function update(UpdateHallRequest $request,Hall $hall): RedirectResponse 
    {
        $this->hallManagerService->updateHall($hall,$request->validated(),$request,auth()->id());

        return redirect()->route('hall-manager.halls.show',$hall)
            ->with('success','Hall updated successfully.');
    }

    /**
     * Delete a hall.
     */
    public function destroy(Hall $hall): RedirectResponse 
    {
        $this->hallManagerService->deleteHall($hall,auth()->id());

        return redirect()->route('hall-manager.halls.index')
            ->with('success','Hall deleted successfully.');
    }
}