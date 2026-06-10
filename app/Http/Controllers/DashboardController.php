<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CalendarEvent;
use App\Models\CareerGoal;
use App\Models\Company;
use App\Models\RecruitmentStatus;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalApplications = Application::where('user_id', $userId)
            ->active()
            ->count();

        $totalCompanies = Company::where('user_id', $userId)
            ->count();

        $totalInterviews = CalendarEvent::where('user_id', $userId)
            ->where('event_type', 'interview')
            ->count();

        $offerStatusIds = RecruitmentStatus::whereIn('slug', ['offering', 'accepted'])
            ->pluck('id');

        $totalOffers = Application::where('user_id', $userId)
            ->active()
            ->whereIn('status_id', $offerStatusIds)
            ->count();

        $acceptedStatusId = RecruitmentStatus::where('slug', 'accepted')->value('id');
        $acceptedApplications = $acceptedStatusId
            ? Application::where('user_id', $userId)
                ->active()
                ->where('status_id', $acceptedStatusId)
                ->count()
            : 0;

        $successRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100)
            : 0;

        $activeGoals = CareerGoal::where('user_id', $userId)
            ->where('status', 'active')
            ->count();

        $recentApplications = Application::with('status')
            ->where('user_id', $userId)
            ->active()
            ->latest()
            ->take(5)
            ->get();

        $pipelineStatuses = RecruitmentStatus::withCount([
                'applications as applications_count' => fn ($query) => $query
                    ->where('user_id', $userId)
                    ->active(),
            ])
            ->orderBy('sort_order')
            ->orderBy('order_position')
            ->get();

        $todaySchedule = CalendarEvent::where('user_id', $userId)
            ->whereDate('event_datetime', today())
            ->orderBy('event_datetime')
            ->get();

        $goal = CareerGoal::where('user_id', $userId)
            ->where('status', 'active')
            ->latest()
            ->first();

        return view('dashboard', compact(
            'totalApplications',
            'totalCompanies',
            'totalInterviews',
            'totalOffers',
            'successRate',
            'activeGoals',
            'recentApplications',
            'pipelineStatuses',
            'todaySchedule',
            'goal'
        ));
    }
}
