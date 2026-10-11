<?php

namespace App\Http\Controllers;

use App\Http\Requests\Worker\StoreJobApplicationRequest;
use App\Models\JobPost;
use App\Services\Worker\WorkerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkerController extends Controller
{
    /**
     * Worker Service.
     */
    public function __construct(private WorkerService $workerService) 
    {
        //
    }

    /**
     * Worker Dashboard.
     */
    public function dashboard(): View
    {
        $data = $this->workerService->getDashboardData(auth()->id());
        return view('worker.dashboard',$data);
    }

    /**
     * Display available job advertisements.
     */
    public function jobs(): View
    {
        $data = $this->workerService->getAvailableJobs(auth()->id());
        return view('worker.job-posts.index',$data);
    }

    /**
     * Display a specific job advertisement.
     */
    public function showJob(JobPost $jobPost): View
    {
        $data = $this->workerService->getJobDetails($jobPost,auth()->id());
        return view('worker.job-posts.show',$data);
    }

    /**
     * Apply for a job advertisement.
     */
    public function apply(StoreJobApplicationRequest $request,JobPost $jobPost): RedirectResponse 
    {
        $workerId = auth()->id();
        $error = $this->workerService->canApply($jobPost,$workerId);

        if ($error !== null) {
            return back()->with('error', $error);
        }

        $validated = $request->validated();

        $this->workerService->applyForJob(
            $jobPost,
            $workerId,
            $validated['message'] ?? null
        );

        return redirect()->route('worker.applications.index')
            ->with('success','Your application has been submitted successfully.');
    }

    /**
     * Display applications submitted by the logged-in worker.
     */
    public function applications(): View
    {
        $applications = $this->workerService->getApplications(auth()->id());
        return view('worker.applications.index',compact('applications'));
    }
}