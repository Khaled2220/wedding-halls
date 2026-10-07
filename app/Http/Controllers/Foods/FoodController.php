<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Foods\Food;
use App\Services\FoodService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Food service.
     */
    public function __construct(private FoodService $foodService) 
    {
        //
    }


    /**
     * Display foods.
     *
     * If hall_id is provided:
     * show foods belonging only to that hall.
     *
     * If hall_id is not provided:
     * show all foods belonging to the logged-in manager.
     */
    public function index(Request $request)
    {
        $hallId = $request->query('hall_id');

        $result = $this->foodService->getFoods($hallId ? (int) $hallId : null);

        return view('hall-manager.foods.index',
            [
                'foods' => $result['foods'],
                'hall' => $result['hall'],
            ]
        );
    }


    /**
     * Display one food.
     */
    public function show(Food $food)
    {
        $food = $this->foodService->getFood($food);

        return view('hall-manager.foods.show', compact('food'));
    }


    /**
     * Show create food page.
     */
    public function create(Request $request)
    {
        $hallId = $request->query('hall_id');

        $hall = $this->foodService->getHallForCreate( $hallId ? (int) $hallId : null);

        return view('hall-manager.foods.create',compact('hall'));
    }


    /**
     * Store food.
     */
    public function store(StoreFoodRequest $request)
    {
        $validated = $request->validated();

        $food = $this->foodService->createFood($validated, $request->file('images', []));

        return redirect()->route('hall-manager.foods.index',[ 'hall_id' => $food->hall_id, ])
            ->with('success','Food added successfully.');
    }


    /**
     * Show edit food page.
     */
    public function edit(Food $food)
    {
        $food = $this->foodService->getFood($food);

        return view('hall-manager.foods.edit',compact('food'));
    }


    /**
     * Update food.
     */
    public function update(UpdateFoodRequest $request,Food $food) 
    {
        $validated = $request->validated();

        $this->foodService->updateFood($food,$validated,$request->file('images', []));

        return redirect()->route('hall-manager.foods.index',[ 'hall_id' => $food->hall_id, ])
            ->with('success','Food updated successfully.');
    }


    /**
     * Delete food.
     */
    public function destroy(Food $food)
    {
        $hallId = $this->foodService->deleteFood($food);

        return redirect()->route('hall-manager.foods.index',[ 'hall_id' => $hallId, ])
            ->with('success','Food deleted successfully.');
    }
}
