<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hall\StoreHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Models\Hall;
use App\Models\HallImage;
use App\Models\Foods\Food;
use App\Models\Foods\Sweet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HallController extends Controller
{
    /**
     * Display halls belonging to the logged-in hall manager.
     */
    public function index()
    {
        $halls = Hall::with('images')
            ->where('hall_manager_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'hall-manager.halls.index',compact('halls')
        );
    }

    /**
     * Show the create hall form.
     */
    public function create()
    {
        return view('hall-manager.halls.create');
    }

    /**
     * Store a new hall with food, sweet and images.
     */
    public function store(StoreHallRequest $request)
    {
        $validated = $request->validated();
        DB::transaction(function () use (
            $request,
            $validated
        ) {
            $hall = Hall::create([
                'hall_manager_id' => auth()->id(),
                'name' => $validated['name'],
                'description' =>$validated['description'] ?? null,
                'food' =>$validated['food'] ?? null,
                'sweets' =>$validated['sweets'] ?? null,
                'address' => $validated['address'],
                'phone' => $validated['phone'] ?? null,
                'price' =>  $validated['price'],
                'capacity' => $validated['capacity'] ?? null,
                'status' => 'active',
                'latitude' => $validated['latitude'] ?? null,
                'longitude' =>$validated['longitude'] ?? null,
            ]);
            if ($request->hasFile('images')) {
                foreach (
                    $request->file('images') as $image
                ) 
                {
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
                    'price' =>
                        $validated['food_price'] ?? 0,
                ]);
                if ($request->hasFile('food_images')) {
                    foreach (
                        $request->file('food_images') as $image
                    ) {
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
                    'price' =>
                        $validated['sweet_price'] ?? 0,
                ]);
                if ($request->hasFile('sweet_images')) {
                    foreach (
                        $request->file('sweet_images') as $image
                    ) {
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
        });
        return redirect()->route('hall-manager.halls.index')
            ->with('success','Hall, food, sweet and images created successfully.');
    }

    /**
     * Display a hall.
     */
    public function show(Hall $hall)
    {
        abort_unless($hall->hall_manager_id === auth()->id(),403);

        $hall->load([
            'images',
            'foods.images',
            'sweetItems.images',
        ]);
        return view(
            'hall-manager.halls.show',compact('hall'));
    }

    /**
     * Show the edit hall form.
     */
    public function edit(Hall $hall)
    {
        abort_unless($hall->hall_manager_id === auth()->id(),403 );
      
        $hall->load('images');

        return view(
            'hall-manager.halls.edit',compact('hall')
        );
    }

    /**
     * Update a hall.
     */
    public function update(UpdateHallRequest $request,Hall $hall) 
    {
        abort_unless($hall->hall_manager_id === auth()->id(),403);

        $validated = $request->validated();
        $hall->update([
            'name' =>$validated['name'],
            'description' =>$validated['description'] ?? null,
            'food' =>$validated['food'] ?? null,
            'sweets' =>$validated['sweets'] ?? null,
            'address' =>$validated['address'],
            'phone' =>$validated['phone'] ?? null,
            'price' =>$validated['price'],
            'capacity' =>$validated['capacity'] ?? null,
            'status' =>$validated['status'],
            'latitude' =>$validated['latitude'] ?? null,
            'longitude' =>$validated['longitude'] ?? null,
        ]);

        /*
         * Delete selected images
         */
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = HallImage::where(
                'hall_id',
                $hall->id
            )
            ->whereIn(
                'id',
                $validated['delete_images']
            )->get();

            foreach ($imagesToDelete as $hallImage) {
                Storage::disk('public')->delete(
                    $hallImage->image
                );
                $hallImage->delete();
            }
        }

        /*
         * Add new Hall images
         */
        if ($request->hasFile('images')) {
            foreach (
                $request->file('images') as $image
            ) {
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
        return redirect()->route('hall-manager.halls.show',$hall)
            ->with('success','Hall updated successfully.');
    }

    /**
     * Delete a hall.
     */
    public function destroy(Hall $hall)
    {
        abort_unless($hall->hall_manager_id === auth()->id(),403);
        
        $hall->load('images');
        foreach ($hall->images as $hallImage) {
            Storage::disk('public')->delete(
                $hallImage->image
            );
        }
        $hall->delete();

        return redirect()->route('hall-manager.halls.index')
            ->with('success','Hall deleted successfully.');
    }
}
