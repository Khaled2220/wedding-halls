<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Foods\Food;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
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
        $hall = null;
        if ($hallId) {
            $hall = Hall::where('id', $hallId)
                ->where('hall_manager_id', auth()->id())
                ->firstOrFail();
        }
        $foods = Food::with([
            'hall',
            'images',
        ])
            ->when($hallId, function ($query) use ($hallId) {
                $query->where('hall_id', $hallId);
            })
            ->whereHas('hall', function ($query) {
                $query->where(
                    'hall_manager_id',auth()->id()
                );
            })
            ->latest()
            ->get();

        return view(
            'hall-manager.foods.index',compact('foods', 'hall')
        );
    }


    /**
     * Display one food.
     */
    public function show(Food $food)
    {
        $this->authorizeFood($food);
        $food->load([
            'hall',
            'images',
        ]);
        return view(
            'hall-manager.foods.show',compact('food')
        );
    }


    /**
     * Show create food page.
     */
    public function create(Request $request)
    {
        $hallId = $request->query('hall_id');
        if (!$hallId) {
            return redirect()->route('hall-manager.halls.index')
                ->with('error','Please select a hall first.'
                );
        }
        $hall = Hall::where('id', $hallId)
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        return view(
            'hall-manager.foods.create',compact('hall')
        );
    }

    /**
     * Store food.
     */
    public function store(StoreFoodRequest $request)
    {
        $validated = $request->validated();
        $hall = Hall::where('id', $validated['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        $food = Food::create([
            'hall_id' => $hall->id,
            'price' => $validated['price'],
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(
                    'foods',
                    'public'
                );
                $food->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $hall->id,
                ]
            )
            ->with('success','Food added successfully.');
    }


    /**
     * Show edit food page.
     */
    public function edit(Food $food)
    {
        $this->authorizeFood($food);
        $food->load([
            'hall',
            'images',
        ]);
        return view(
            'hall-manager.foods.edit',compact('food')
        );
    }


    /**
     * Update food.
     */
    public function update(UpdateFoodRequest $request,Food $food) 
    {
        $this->authorizeFood($food);
        $validated = $request->validated();
        $food->update([
            'price' => $validated['price'],
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(
                    'foods',
                    'public'
                );
                $food->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $food->hall_id,
                ]
            )
            ->with('success','Food updated successfully.');
    }


    /**
     * Delete food.
     */
    public function destroy(Food $food)
    {
        $this->authorizeFood($food);
        $hallId = $food->hall_id;
        $food->load('images');
        foreach ($food->images as $image) {
            Storage::disk('public')
                ->delete($image->image_path);
        }
        $food->delete();
        return redirect()->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $hallId,
                ]
            )
            ->with('success','Food deleted successfully.');
    }


    /**
     * Make sure food belongs to
     * the logged-in manager.
     */
    private function authorizeFood(Food $food): void 
    {
        abort_unless($food->hall && $food->hall->hall_manager_id === auth()->id(),403);
    }
}
