<?php

namespace App\Services;

use App\Models\Foods\Food;
use App\Models\Hall;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FoodService
{
    /**
     * Get foods belonging to the logged-in hall manager.
     */
    public function getFoods(?int $hallId = null): array
    {
        $hall = null;

        if ($hallId) {
            $hall = Hall::where('id', $hallId)
                ->where('hall_manager_id', auth()->id())
                ->firstOrFail();
        }

        $foods = Food::with(['hall','images',])
            ->when($hallId, function ($query) use ($hallId) {
                $query->where('hall_id', $hallId);
            })
            ->whereHas('hall', function ($query) {
                $query->where('hall_manager_id',auth()->id());
            })
            ->latest()
            ->get();

        return [
            'foods' => $foods,
            'hall' => $hall,
        ];
    }

    /**
     * Get one food.
     */
    public function getFood(Food $food): Food
    {
        $this->authorizeFood($food);

        return $food->load(['hall','images',]);
    }

    /**
     * Get hall for creating food.
     */
    public function getHallForCreate(?int $hallId): Hall
    {
        if (!$hallId) {
            abort(
                redirect()
                    ->route('hall-manager.halls.index')
                    ->with('error','Please select a hall first.')
            );
        }

        return Hall::where('id', $hallId)
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();
    }

    /**
     * Create food.
     */
    public function createFood(array $data,array $images = [] ): Food 
    {
        $hall = Hall::where('id', $data['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        $food = Food::create([
            'hall_id' => $hall->id,
            'price' => $data['price'],
        ]);

        $this->storeImages($food, $images);

        return $food;
    }

    /**
     * Update food.
     */
    public function updateFood(Food $food, array $data, array $images = [] ): Food 
    {
        $this->authorizeFood($food);

        $food->update([
            'price' => $data['price'],
        ]);

        $this->storeImages($food, $images);

        return $food->fresh(['hall', 'images',]);
    }

    /**
     * Delete food.
     */
    public function deleteFood(Food $food): int
    {
        $this->authorizeFood($food);

        $hallId = $food->hall_id;

        $food->load('images');

        foreach ($food->images as $image) {
            Storage::disk('public')
                ->delete($image->image_path);
        }

        $food->delete();

        return $hallId;
    }

    /**
     * Store food images.
     */
    private function storeImages(Food $food, array $images ): void 
    {
        foreach ($images as $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $path = $image->store('foods','public');

            $food->images()->create(['image_path' => $path,]);
        }
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