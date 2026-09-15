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

        /*
         * If a hall was selected,
         * make sure it belongs to the logged-in manager.
         */
        if ($hallId) {
            $hall = Hall::where('id', $hallId)
                ->where('hall_manager_id', auth()->id())
                ->firstOrFail();
        }

        /*
         * Get foods.
         */
        $foods = Food::with([
            'hall',
            'images',
        ])
            ->when($hallId, function ($query) use ($hallId) {
                $query->where('hall_id', $hallId);
            })
            ->whereHas('hall', function ($query) {
                $query->where(
                    'hall_manager_id',
                    auth()->id()
                );
            })
            ->latest()
            ->get();

        return view(
            'hall-manager.foods.index',
            compact('foods', 'hall')
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
            'hall-manager.foods.show',
            compact('food')
        );
    }


    /**
     * Show create food page.
     */
    public function create(Request $request)
    {
        $hallId = $request->query('hall_id');

        if (!$hallId) {
            return redirect()
                ->route('hall-manager.halls.index')
                ->with(
                    'error',
                    'Please select a hall first.'
                );
        }

        $hall = Hall::where('id', $hallId)
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        return view(
            'hall-manager.foods.create',
            compact('hall')
        );
    }


    /**
     * Store food.
     */
    public function store(StoreFoodRequest $request)
    {
        $validated = $request->validated();

        /*
         * Find selected hall AND verify ownership.
         */
        $hall = Hall::where('id', $validated['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        /*
         * Create food for THIS hall only.
         */
        $food = Food::create([
            'hall_id' => $hall->id,
            'price' => $validated['price'],
        ]);

        /*
         * Upload images.
         */
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

        /*
         * Return to the same hall.
         */
        return redirect()
            ->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $hall->id,
                ]
            )
            ->with(
                'success',
                'Food added successfully.'
            );
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
            'hall-manager.foods.edit',
            compact('food')
        );
    }


    /**
     * Update food.
     */
    public function update(
        UpdateFoodRequest $request,
        Food $food
    ) {
        $this->authorizeFood($food);

        $validated = $request->validated();

        /*
         * Update price only.
         */
        $food->update([
            'price' => $validated['price'],
        ]);

        /*
         * Add new images.
         */
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

        /*
         * Return to the food's own hall.
         */
        return redirect()
            ->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $food->hall_id,
                ]
            )
            ->with(
                'success',
                'Food updated successfully.'
            );
    }


    /**
     * Delete food.
     */
    public function destroy(Food $food)
    {
        $this->authorizeFood($food);

        /*
         * Save hall ID before deleting.
         */
        $hallId = $food->hall_id;

        $food->load('images');

        /*
         * Delete image files.
         */
        foreach ($food->images as $image) {

            Storage::disk('public')
                ->delete($image->image_path);
        }

        /*
         * Delete food.
         */
        $food->delete();

        /*
         * Return to the same hall.
         */
        return redirect()
            ->route(
                'hall-manager.foods.index',
                [
                    'hall_id' => $hallId,
                ]
            )
            ->with(
                'success',
                'Food deleted successfully.'
            );
    }


    /**
     * Make sure food belongs to
     * the logged-in manager.
     */
    private function authorizeFood(
        Food $food
    ): void {
        abort_unless(
            $food->hall &&
            $food->hall->hall_manager_id === auth()->id(),
            403
        );
    }
}
