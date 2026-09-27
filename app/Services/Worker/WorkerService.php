<?php

namespace App\Services\Worker;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class WorkerService
{
    /**
     * Get worker dashboard statistics.
     */
    public function getDashboardData(int $workerId): array
    {
        $applicationsCount = JobApplication::where('worker_id',$workerId)->count();

        $pendingApplicationsCount = JobApplication::where('worker_id',$workerId)
            ->where('status', 'pending')
            ->count();

        $openJobsCount = JobPost::where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', today());
            })
            ->count();

        return [
            'applicationsCount' => $applicationsCount,
            'pendingApplicationsCount' => $pendingApplicationsCount,
            'openJobsCount' => $openJobsCount,
        ];
    }

    /**
     * Get available job advertisements.
     */
    public function getAvailableJobs(int $workerId): array
    {
        $jobPosts = JobPost::with('hall')
            ->where('status', 'open')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', today());
            })
            ->latest()
            ->get();

        $appliedJobIds = JobApplication::where('worker_id',$workerId)
            ->pluck('job_post_id')
            ->toArray();

        return [
            'jobPosts' => $jobPosts,
            'appliedJobIds' => $appliedJobIds,
        ];
    }

    /**
     * Get a specific job advertisement.
     */
    public function getJobDetails(JobPost $jobPost,int $workerId): array 
    {
        $hasApplied = JobApplication::where('job_post_id',$jobPost->id)
            ->where(
                'worker_id',
                $workerId
            )
            ->exists();

        $jobPost->load('hall');

        return [
            'jobPost' => $jobPost,
            'hasApplied' => $hasApplied,
        ];
    }

    /**
     * Check whether the worker can apply for the job.
     */
    public function canApply(JobPost $jobPost,int $workerId): ?string 
    {
        if ($jobPost->status !== 'open') {
            return 'This job advertisement is closed.';
        }

        if (
            $jobPost->deadline !== null &&
            $jobPost->deadline->isBefore(today())
        ) {
            return 'The application deadline has passed.';
        }

        $alreadyApplied = JobApplication::where(
            'job_post_id',
            $jobPost->id
        )
            ->where(
                'worker_id',
                $workerId
            )
            ->exists();

        if ($alreadyApplied) {
            return 'You have already applied for this job.';
        }

        return null;
    }

    /**
     * Create a job application.
     */
    public function applyForJob(JobPost $jobPost,int $workerId,?string $message): JobApplication 
    {
        return JobApplication::create([
            'job_post_id' => $jobPost->id,
            'worker_id' => $workerId,
            'message' => $message,
            'status' => 'pending',
            'applied_at' => now(),
        ]);
    }

    /**
     * Get worker applications.
     */
    public function getApplications(int $workerId): LengthAwarePaginator 
    {
        return JobApplication::with(['jobPost.hall',])
            ->where(
                'worker_id',
                $workerId
            )
            ->latest('applied_at')
            ->paginate(10);
    }
}
