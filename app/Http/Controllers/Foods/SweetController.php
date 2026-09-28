<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreSweetRequest;
use App\Http\Requests\Food\UpdateSweetRequest;
use App\Models\Foods\Sweet;
use App\Services\SweetService;
use Illuminate\Http\Request;

class SweetController extends Controller
{
    /**
     * Sweet service.
     */
    public function __construct(private SweetService $sweetService) 
    {
        //
    }


    /**
     * Display sweets.
     *
     * If hall_id is provided:
     * show sweets belonging only to that hall.
     *
     * If hall_id is not provided:
     * show all sweets belonging to the logged-in manager.
     */
    public function index(Request $request)
    {
        $hallId = $request->query('hall_id');

        $result = $this->sweetService->getSweets($hallId ? (int) $hallId : null);

        return view('hall-manager.foods.sweets.index',
            [
                'sweets' => $result['sweets'],
                'hall' => $result['hall'],
            ]
        );
    }


    /**
     * Display one sweet.
     */
    public function show(Sweet $sweet)
    {
        $sweet = $this->sweetService->getSweet($sweet);

        return view('hall-manager.foods.sweets.show',compact('sweet'));
    }


    /**
     * Show create sweet page.
     */
    public function create(Request $request)
    {
        $hallId = $request->query('hall_id');

        $hall = $this->sweetService->getHallForCreate($hallId ? (int) $hallId : null);

        return view( 'hall-manager.foods.sweets.create', compact('hall'));
    }


    /**
     * Store sweet.
     */
    public function store(StoreSweetRequest $request)
    {
        $validated = $request->validated();

        $sweet = $this->sweetService->createSweet($validated, $request->file('images', []));

        return redirect()->route('hall-manager.sweets.index',
                [
                    'hall_id' => $sweet->hall_id,
                ])
            ->with( 'success','Sweet added successfully.');
    }


    /**
     * Show edit sweet page.
     */
    public function edit(Sweet $sweet)
    {
        $sweet = $this->sweetService->getSweet($sweet);

        return view( 'hall-manager.foods.sweets.edit',compact('sweet')
        );
    }


    /**
     * Update sweet.
     */
    public function update( UpdateSweetRequest $request, Sweet $sweet) 
    {
        $validated = $request->validated();

        $this->sweetService->updateSweet($sweet,$validated,$request->file('images', []));

        return redirect()->route('hall-manager.sweets.index',
                [
                    'hall_id' => $sweet->hall_id,
                ])
            ->with('success','Sweet updated successfully.');
    }


    /**
     * Delete sweet.
     */
    public function destroy(Sweet $sweet)
    {
        $hallId = $this->sweetService->deleteSweet($sweet);

        return redirect()->route('hall-manager.sweets.index',
                [
                    'hall_id' => $hallId,
                ])
            ->with('success','Sweet deleted successfully.');
    }
}
