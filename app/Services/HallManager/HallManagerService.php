<?php

namespace App\Services\HallManager;

use App\Models\Hall;
use App\Models\HallImage;
use App\Models\Foods\Food;
use App\Models\Foods\Sweet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HallManagerService
{
    /**
     * Get Hall Manager's halls.
     */
    public function getHalls(int $hallManagerId): Collection
    {
        return Hall::with('images')
            ->where('hall_manager_id', $hallManagerId)
            ->latest()
            ->get();
    }

    /**
     * Create a new hall with food, sweets and images.
     */
    public function createHall(array $validated,$request,int $hallManagerId): Hall 
    {
        return DB::transaction(function () use ($validated,$request,$hallManagerId) 
        {
            $hall = Hall::create([
                'hall_manager_id' => $hallManagerId,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'food' => $validated['food'] ?? null,
                'sweets' => $validated['sweets'] ?? null,
                'address' => $validated['address'],
                'phone' => $validated['phone'] ?? null,
                'price' => $validated['price'],
                'capacity' => $validated['capacity'] ?? null,
                'status' => 'active',
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store(
                        'halls',
                        'public'
                    );

                    HallImage::create([
                        'hall_id' => $hall->id,
                        'image' => $path,
                    ]);
                }
            }


            if (
                $request->filled('food_price') ||
                $request->hasFile('food_images')
            ) {
                $food = Food::create([
                    'hall_id' => $hall->id,
                    'price' => $validated['food_price'] ?? 0,
                ]);

                if ($request->hasFile('food_images')) {
                    foreach ($request->file('food_images') as $image) {
                        $path = $image->store(
                            'foods',
                            'public'
                        );

                        $food->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }
            }

            if (
                $request->filled('sweet_price') ||
                $request->hasFile('sweet_images')
            ) {
                $sweet = Sweet::create([
                    'hall_id' => $hall->id,
                    'price' => $validated['sweet_price'] ?? 0,
                ]);

                if ($request->hasFile('sweet_images')) {
                    foreach ($request->file('sweet_images') as $image) {
                        $path = $image->store(
                            'sweets',
                            'public'
                        );

                        $sweet->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }
            }

            return $hall;
        });
    }

    /**
     * Get a hall with images, foods and sweets.
     */
    public function getHall(Hall $hall,int $hallManagerId): Hall 
    {
        $this->authorizeHall($hall,$hallManagerId);

        $hall->load(['images','foods.images','sweetItems.images',]);

        return $hall;
    }

    /**
     * Get a hall for editing.
     */
    public function getHallForEdit(Hall $hall,int $hallManagerId): Hall 
    {
        $this->authorizeHall($hall,$hallManagerId);

        $hall->load('images');

        return $hall;
    }

    /**
     * Update a hall.
     */
    public function updateHall(Hall $hall,array $validated,$request,int $hallManagerId): Hall 
    {
        $this->authorizeHall($hall,$hallManagerId);

        $hall->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'food' => $validated['food'] ?? null,
            'sweets' => $validated['sweets'] ?? null,
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? null,
            'price' => $validated['price'],
            'capacity' => $validated['capacity'] ?? null,
            'status' => $validated['status'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        /*
         * Delete selected images.
         */
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = HallImage::where('hall_id',$hall->id)
                ->whereIn('id',$validated['delete_images'])
                ->get();

            foreach ($imagesToDelete as $hallImage) {
                Storage::disk('public')->delete(
                    $hallImage->image
                );

                $hallImage->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('halls','public');

                HallImage::create(['hall_id' => $hall->id,'image' => $path,]);
            }
        }

        return $hall->fresh(['images','foods.images','sweetItems.images',]);
    }


    public function deleteHall(Hall $hall,int $hallManagerId): void 
    {
        $this->authorizeHall($hall,$hallManagerId);

        $hall->load('images');

        foreach ($hall->images as $hallImage) {
            Storage::disk('public')->delete($hallImage->image);
        }

        $hall->delete();
    }

    /**
     * Check Hall ownership.
     */
    public function ownsHall(Hall $hall,int $hallManagerId): bool 
    {
        return $hall->hall_manager_id === $hallManagerId;
    }

    /**
     * Authorize Hall ownership.
     */
    private function authorizeHall(Hall $hall,int $hallManagerId): void 
    {
        abort_unless($this->ownsHall($hall,$hallManagerId ),403);
    }
}