<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CalendarEvent;
use App\Models\CareerGoal;
use App\Models\Company;
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

        $activeGoals = CareerGoal::where('user_id', $userId)
            ->where('status', 'active')
            ->count();

        $recentApplications = Application::with('status')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
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
            'activeGoals',
            'recentApplications',
            'todaySchedule',
            'goal'
        ));
    }
}