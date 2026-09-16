<?php

namespace App\Http\Controllers\Foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreSweetRequest;
use App\Http\Requests\Food\UpdateSweetRequest;
use App\Models\Foods\Sweet;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SweetController extends Controller
{
    /**
     * Display sweets.
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
        $sweets = Sweet::with([
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
            'hall-manager.foods.sweets.index',
            compact('sweets', 'hall')
        );
    }

    /**
     * Display one sweet.
     */
    public function show(Sweet $sweet)
    {
        $this->authorizeSweet($sweet);
        $sweet->load([
            'hall',
            'images',
        ]);
        return view(
            'hall-manager.foods.sweets.show',
            compact('sweet')
        );
    }

    /**
     * Show create sweet page.
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
            'hall-manager.foods.sweets.create',
            compact('hall')
        );
    }

    /**
     * Store sweet.
     */
    public function store(StoreSweetRequest $request)
    {
        $validated = $request->validated();
        $hall = Hall::where('id', $validated['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->firstOrFail();
        $sweet = Sweet::create([
            'hall_id' => $hall->id,
            'price' => $validated['price'],
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(
                    'sweets',
                    'public'
                );
                $sweet->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()
            ->route(
                'hall-manager.sweets.index',
                [
                    'hall_id' => $hall->id,
                ]
            )
            ->with(
                'success',
                'Sweet added successfully.'
            );
    }

    /**
     * Show edit sweet page.
     */
    public function edit(Sweet $sweet)
    {
        $this->authorizeSweet($sweet);
        $sweet->load([
            'hall',
            'images',
        ]);
        return view(
            'hall-manager.foods.sweets.edit',
            compact('sweet')
        );
    }

    /**
     * Update sweet.
     */
    public function update(UpdateSweetRequest $request,Sweet $sweet) 
    {
        $this->authorizeSweet($sweet);
        $validated = $request->validated();
        $sweet->update([
            'price' => $validated['price'],
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(
                    'sweets',
                    'public'
                );

                $sweet->images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()
            ->route(
                'hall-manager.sweets.index',
                [
                    'hall_id' => $sweet->hall_id,
                ]
            )
            ->with(
                'success',
                'Sweet updated successfully.'
            );
    }

    /**
     * Delete sweet.
     */
    public function destroy(Sweet $sweet)
    {
        $this->authorizeSweet($sweet);
        $hallId = $sweet->hall_id;
        $sweet->load('images');
        foreach ($sweet->images as $image) {
            Storage::disk('public')
                ->delete($image->image_path);
        }
        $sweet->delete();
        return redirect()
            ->route(
                'hall-manager.sweets.index',
                [
                    'hall_id' => $hallId,
                ]
            )
            ->with(
                'success',
                'Sweet deleted successfully.'
            );
    }

    /**
     * Authorize sweet ownership.
     */
    private function authorizeSweet(Sweet $sweet): void 
    {
        abort_unless(
            $sweet->hall &&
            $sweet->hall->hall_manager_id === auth()->id(),
            403
        );
    }
}
