<?php

namespace App\Services\HallManager;

use App\Models\Hall;
use App\Models\JobPost;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class HallManagerService
{
    /**
     * Get Hall Manager dashboard data.
     */
    public function getDashboardData(int $hallManagerId): array
    {
        $hallsCount = Hall::where('hall_manager_id',$hallManagerId)->count();

        $activeHallsCount = Hall::where('hall_manager_id',$hallManagerId)
            ->where('status', 'active')
            ->count();

        $jobPostsCount = JobPost::where('hall_manager_id',$hallManagerId)->count();

        $openJobPostsCount = JobPost::where('hall_manager_id',$hallManagerId)
            ->where('status', 'open')
            ->count();

        $reservationsCount = Reservation::whereHas('hall',
            function ($query) use ($hallManagerId) {
                $query->where('hall_manager_id',$hallManagerId);
            }
        )->count();

        $pendingReservationsCount = Reservation::whereHas('hall',
            function ($query) use ($hallManagerId) {
                $query->where('hall_manager_id',$hallManagerId);
            }
        )
            ->where('status', 'pending')
            ->count();

        return [
            'hallsCount' => $hallsCount,
            'activeHallsCount' => $activeHallsCount,
            'jobPostsCount' => $jobPostsCount,
            'openJobPostsCount' => $openJobPostsCount,
            'reservationsCount' => $reservationsCount,
            'pendingReservationsCount' => $pendingReservationsCount,
        ];
    }

    /**
     * Get Hall Manager's halls.
     */
    public function getHalls(int $hallManagerId): Collection
    {
        return Hall::where('hall_manager_id',$hallManagerId)
            ->latest()
            ->get();
    }

    /**
     * Get Hall Manager's reservations.
     */
    public function getReservations(int $hallManagerId): Collection
    {
        return Reservation::with([
            'customer',
            'hall',
        ])
            ->whereHas('hall',
                function ($query) use ($hallManagerId) {
                    $query->where('hall_manager_id',$hallManagerId
                    );
                }
            )
            ->latest('reservation_date')
            ->get();
    }

    /**
     * Get reservations for the calendar.
     */
    public function getReservationsCalendarData(int $hallManagerId): array 
    {
        $hallIds = Hall::where('hall_manager_id',$hallManagerId)->pluck('id');

        $startDate = Carbon::today();

        $endDate = Carbon::today()->addYear();

        $reservations = Reservation::with(['customer','hall',])
            ->whereIn('hall_id', $hallIds)
            ->whereBetween('reservation_date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ])
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->get();

        $reservationsByDate = $reservations->groupBy(
            function ($reservation) {
                return Carbon::parse($reservation->reservation_date)->format('Y-m-d');
            }
        );

        return [
            'reservationsByDate' => $reservationsByDate,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }

    /**
     * Get Hall Manager's job posts.
     */
    public function getJobPosts(int $hallManagerId): Collection
    {
        return JobPost::with('hall')
            ->where('hall_manager_id',$hallManagerId)
            ->latest()
            ->get();
    }

    /**
     * Check if Hall Manager owns the hall.
     */
    public function ownsHall(Hall $hall,int $hallManagerId): bool 
    {
        return $hall->hall_manager_id === $hallManagerId;
    }

    /**
     * Check if Hall Manager owns the job post.
     */
    public function ownsJobPost(JobPost $jobPost,int $hallManagerId): bool 
    {
        return $jobPost->hall_manager_id === $hallManagerId;
    }
}