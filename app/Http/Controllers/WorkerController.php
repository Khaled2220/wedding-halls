<?php

namespace App\Http\Controllers;

use App\Http\Requests\Worker\StoreJobApplicationRequest;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkerController extends Controller
{
    /**
     * Worker Dashboard
     */
    public function dashboard(): View
    {
        $workerId = auth()->id();

        $applicationsCount = JobApplication::where(
            'worker_id',
            $workerId
        )->count();

        $pendingApplicationsCount = JobApplication::where(
            'worker_id',
            $workerId
        )
            ->where('status', 'pending')
            ->count();

        $openJobsCount = JobPost::where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', today());
            })
            ->count();

        return view(
            'worker.dashboard',compact(
                'applicationsCount',
                'pendingApplicationsCount',
                'openJobsCount'
            )
        );
    }

    /**
     * Display available job advertisements.
     */
    public function jobs(): View
    {
        $workerId = auth()->id();

        $jobPosts = JobPost::with('hall')
            ->where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', today());
            })
            ->latest()
            ->get();

        $appliedJobIds = JobApplication::where(
            'worker_id',
            $workerId
        )
            ->pluck('job_post_id')
            ->toArray();

        return view(
            'worker.job-posts.index',compact(
                'jobPosts',
                'appliedJobIds'
            )
        );
    }

    /**
     * Display a specific job advertisement.
     */
    public function showJob(JobPost $jobPost): View
    {
        $workerId = auth()->id();

        $hasApplied = JobApplication::where(
            'job_post_id',
            $jobPost->id
        )
            ->where(
                'worker_id',
                $workerId
            )
            ->exists();

        $jobPost->load('hall');

        return view(
            'worker.job-posts.show',compact(
                'jobPost',
                'hasApplied'
            )
        );
    }

    /**
     * Apply for a job advertisement.
     */
    public function apply(StoreJobApplicationRequest $request,JobPost $jobPost): RedirectResponse 
    {
        $workerId = auth()->id();

        if ($jobPost->status !== 'open') {
            return back()
                ->with('error', 'This job advertisement is closed.');
        }

        if (
            $jobPost->deadline !== null &&
            $jobPost->deadline->isBefore(today())
        ) {
            return back()
                ->with('error','The application deadline has passed.');
        }

        $alreadyApplied = JobApplication::where('job_post_id',$jobPost->id)
            ->where(
                'worker_id',
                $workerId
            )
            ->exists();

        if ($alreadyApplied) {
            return back()
                ->with('error','You have already applied for this job.');
        }

        $validated = $request->validated();

        JobApplication::create([
            'job_post_id' => $jobPost->id,
            'worker_id' => $workerId,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return redirect()->route('worker.applications.index')
            ->with('success','Your application has been submitted successfully.');
    }

    /**
     * Display applications submitted by the logged-in worker.
     */
    public function applications(): View
    {
        $applications = JobApplication::with(['jobPost.hall',])
            ->where(
                'worker_id',
                auth()->id()
            )
            ->latest('applied_at')
            ->paginate(10);

        return view(
            'worker.applications.index',compact('applications')
        );
    }
}