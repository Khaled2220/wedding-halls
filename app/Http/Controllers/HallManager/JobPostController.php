<?php

namespace App\Http\Controllers\HallManager;

use App\Http\Controllers\Controller; 
use App\Models\Hall; 
use App\Models\JobPost; 
use Illuminate\Http\RedirectResponse; 
use Illuminate\Http\Request; 
use Illuminate\View\View;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jobPosts = JobPost::with('hall') 
        ->where('hall_manager_id', 
        auth()->id()) ->latest() ->get();

        return view( 
            'hall-manager.job-posts.index', compact('jobPosts') 
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $halls = Hall::where(
            'hall_manager_id', 
            auth()->id()) ->orderBy('name') ->get();

        return view( 
            'hall-manager.job-posts.create', compact('halls') 
        );    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([ 
            'hall_id' => ['required','integer','exists:halls,id', ],
            'title' => [ 'required', 'string', 'max:255', ],
            'description' => [ 'nullable', 'string', ],
            'requirements' => [ 'nullable', 'string', ],
            'salary' => [ 'nullable', 'numeric', 'min:0', ],
            'employment_type' => [ 'nullable', 'string', 'max:100', ],
            'workers_needed' => [ 'required', 'integer', 'min:1', ],
            'deadline' => [ 'nullable', 'date', 'after_or_equal:today', ],
            'status' => [ 'required', 'in:open,closed',], 
        ]);

        $hall = Hall::where('id', $validated['hall_id']) ->where('hall_manager_id', auth()->id()) ->first();

        if (!$hall) { 
            return back() ->withInput() ->withErrors([ 'hall_id' => 'You are not authorized to use this hall.', ]);
        }
        
        JobPost::create([ 
            'hall_manager_id' => auth()->id(), 
            'hall_id' => $hall->id, 
            'title' => $validated['title'], 
            'description' => $validated['description'] ?? null, 
            'requirements' => $validated['requirements'] ?? null, 
            'salary' => $validated['salary'] ?? null, 
            'employment_type' => $validated['employment_type'] ?? null, 
            'workers_needed' => $validated['workers_needed'], 
            'deadline' => $validated['deadline'] ?? null, 
            'status' => $validated['status'], 
        ]);
        return redirect() ->route('hall-manager.job-posts.index') 
            ->with( 'success', 'Job advertisement created successfully.' );
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $jobPost): View
    {
        abort_unless( $jobPost->hall_manager_id === auth()->id(), 403 );
        
        $jobPost->load('hall');
        return view( 'hall-manager.job-posts.show', compact('jobPost') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $jobPost): View
    {
        abort_unless( $jobPost->hall_manager_id === auth()->id(), 403 );

        $halls = Hall::where('hall_manager_id', auth()->id()) ->orderBy('name') ->get();

        return view( 'hall-manager.job-posts.edit', compact('jobPost', 'halls') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPost $jobPost ): RedirectResponse 
    {
        abort_unless( $jobPost->hall_manager_id === auth()->id(), 403 );

        $validated = $request->validate([ 'hall_id' => [ 
            'required', 'integer', 'exists:halls,id', ],
            'title' => [ 'required', 'string', 'max:255', ],
            'description' => [ 'nullable', 'string', ],
            'requirements' => [ 'nullable', 'string', ],
            'salary' => [ 'nullable', 'numeric', 'min:0', ],
            'employment_type' => [ 'nullable', 'string', 'max:100', ],
            'workers_needed' => [ 'required', 'integer', 'min:1', ],
            'deadline' => [ 'nullable', 'date', 'after_or_equal:today', ],
            'status' => [ 'required', 'in:open,closed', ],
        ]);
        
        $hall = Hall::where('id', $validated['hall_id']) ->where('hall_manager_id', auth()->id()) ->first();

        if (!$hall) { return back() ->withInput() 
            ->withErrors([ 'hall_id' => 'You are not authorized to use this hall.', ]);
        }
        $jobPost->update([ 
            'hall_id' => $hall->id, 
        'title' => $validated['title'], 
        'description' => $validated['description'] ?? null, 
        'requirements' => $validated['requirements'] ?? null, 
        'salary' => $validated['salary'] ?? null, 
        'employment_type' => $validated['employment_type'] ?? null, 
        'workers_needed' => $validated['workers_needed'], 
        'deadline' => $validated['deadline'] ?? null, 
        'status' => $validated['status'], 
        ]);
        return redirect() ->route(
            'hall-manager.job-posts.index') 
            ->with( 'success', 'Job advertisement updated successfully.' );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $jobPost): RedirectResponse
    {
        abort_unless( $jobPost->hall_manager_id === auth()->id(), 403 );

        $jobPost->delete();
        return redirect() ->route(
            'hall-manager.job-posts.index') 
            ->with( 'success', 'Job advertisement deleted successfully.' );
    }

}
