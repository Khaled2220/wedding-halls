<?php

namespace App\Http\Controllers\HallManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\HallManager\StoreJobPostRequest;
use App\Http\Requests\HallManager\UpdateJobPostRequest;
use App\Models\Hall;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobPostController extends Controller
{
    /**
     * Display all job advertisements created by the logged-in Hall Manager.
     */
    public function index(): View
    {
        $jobPosts = JobPost::with('hall')
            ->where('hall_manager_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'hall-manager.job-posts.index',compact('jobPosts')
        );
    }

    /**
     * Show the form for creating a new job advertisement.
     */
    public function create(): View
    {
        $halls = Hall::where('hall_manager_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view(
            'hall-manager.job-posts.create',compact('halls')
        );
    }

    /**
     * Store a new job advertisement.
     */
    public function store(StoreJobPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $hall = Hall::where('id', $validated['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->first();

        if (!$hall) {
            return back()
                ->withInput()
                ->withErrors([
                    'hall_id' => 'You are not authorized to use this hall.',
                ]);
        }

        JobPost::create([
            'hall_manager_id' => auth()->id(),
            'hall_id' => $hall->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'salary' => $validated['salary'],
            'workers_needed' => $validated['workers_needed'],
            'employment_type' => $validated['employment_type'] ?? null,
            'job_date' => $validated['job_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'deadline' => $validated['deadline'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('hall-manager.job-posts.index')
            ->with('success','Job advertisement created successfully.');
    }

    /**
     * Display a specific job advertisement.
     */
    public function show(JobPost $jobPost): View
    {
        abort_unless($jobPost->hall_manager_id === auth()->id(),403);

        $jobPost->load('hall');

        return view(
            'hall-manager.job-posts.show',compact('jobPost')
        );
    }

    /**
     * Show the edit form.
     */
    public function edit(JobPost $jobPost): View
    {
        abort_unless($jobPost->hall_manager_id === auth()->id(),403);

        $halls = Hall::where('hall_manager_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view(
            'hall-manager.job-posts.edit',compact('jobPost', 'halls')
        );
    }

    /**
     * Update an existing job advertisement.
     */
    public function update(UpdateJobPostRequest $request,JobPost $jobPost): RedirectResponse
    {
        abort_unless($jobPost->hall_manager_id === auth()->id(),403);

        $validated = $request->validated();

        $hall = Hall::where('id', $validated['hall_id'])
            ->where('hall_manager_id', auth()->id())
            ->first();

        if (!$hall) {
            return back()
                ->withInput()
                ->withErrors([
                    'hall_id' => 'You are not authorized to use this hall.',
                ]);
        }

        $jobPost->update([
            'hall_id' => $hall->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'salary' => $validated['salary'],
            'workers_needed' => $validated['workers_needed'],
            'employment_type' => $validated['employment_type'] ?? null,
            'job_date' => $validated['job_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'deadline' => $validated['deadline'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('hall-manager.job-posts.index')
            ->with('success','Job advertisement updated successfully.');
    }

    /**
     * Delete a job advertisement.
     */
    public function destroy(JobPost $jobPost): RedirectResponse
    {
        abort_unless($jobPost->hall_manager_id === auth()->id(),403);

        $jobPost->delete();

        return redirect()->route('hall-manager.job-posts.index')
            ->with('success','Job advertisement deleted successfully.');
    }
}
