<?php

namespace App\Services;

use App\Models\Foods\Sweet;
use App\Models\Hall;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SweetService
{
    /**
     * Get sweets belonging to the logged-in hall manager.
     */
    public function getSweets(?int $hallId = null): array
    {
        $hall = null;

        if ($hallId) {
            $hall = Hall::where('id', $hallId)
                ->where('hall_manager_id', auth()->id())
                ->firstOrFail();
        }

        $sweets = Sweet::with(['hall','images',])
            ->when($hallId, function ($query) use ($hallId) {
                $query->where('hall_id', $hallId);
            })
            ->whereHas('hall', function ($query) {
                $query->where('hall_manager_id',auth()->id());
            })
            ->latest()
            ->get();

        return [ 'sweets' => $sweets, 'hall' => $hall,];
    }


    /**
     * Get one sweet.
     */
    public function getSweet(Sweet $sweet): Sweet
    {
        $this->authorizeSweet($sweet);

        return $sweet->load([ 'hall', 'images',]);
    }


    /**
     * Get hall for creating sweet.
     */
    public function getHallForCreate(?int $hallId): Hall
    {
        if (!$hallId) {
            abort(redirect()->route('hall-manager.halls.index')
                    ->with('error','Please select a hall first.')
            );
        }

        return Hall::where('id', $hallId)
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();
    }


    /**
     * Create sweet.
     */
    public function createSweet(array $data, array $images = []): Sweet 
    {
        $hall = Hall::where('id', $data['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();

        $sweet = Sweet::create([
            'hall_id' => $hall->id,
            'price' => $data['price'],
        ]);

        $this->storeImages($sweet, $images);

        return $sweet;
    }


    /**
     * Update sweet.
     */
    public function updateSweet(Sweet $sweet,array $data,array $images = []): Sweet 
    {
        $this->authorizeSweet($sweet);

        $sweet->update([
            'price' => $data['price'],
        ]);

        $this->storeImages($sweet, $images);

        return $sweet->fresh(['hall','images',]);
    }


    /**
     * Delete sweet.
     */
    public function deleteSweet(Sweet $sweet): int
    {
        $this->authorizeSweet($sweet);

        $hallId = $sweet->hall_id;

        $sweet->load('images');

        foreach ($sweet->images as $image) {
            Storage::disk('public')
                ->delete($image->image_path);
        }

        $sweet->delete();

        return $hallId;
    }


    /**
     * Store sweet images.
     */
    private function storeImages(Sweet $sweet,array $images): void 
    {
        foreach ($images as $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $path = $image->store( 'sweets', 'public');

            $sweet->images()->create([ 'image_path' => $path,]);
        }
    }


    /**
     * Make sure sweet belongs to
     * the logged-in manager.
     */
    private function authorizeSweet(Sweet $sweet): void
    {
        abort_unless($sweet->hall && $sweet->hall->hall_manager_id === auth()->id(),  403);
    }
}
