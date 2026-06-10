<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\ApplicationNote;
use App\Models\CalendarEvent;
use App\Models\CareerGoal;
use App\Models\Company;
use App\Models\User;

use App\Observers\ApplicationObserver;
use App\Observers\UserObserver;

use App\Policies\ApplicationDocumentPolicy;
use App\Policies\ApplicationNotePolicy;
use App\Policies\ApplicationPolicy;
use App\Policies\CalendarEventPolicy;
use App\Policies\CareerGoalPolicy;
use App\Policies\CompanyPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ─── Pagination View ─────────────────────────────────────────────────────
        Paginator::useTailwind();

        // ─── Observers ───────────────────────────────────────────────────────────
        // ApplicationObserver: mencatat activity log otomatis setiap kali
        // lamaran dibuat atau status-nya berubah.
        Application::observe(ApplicationObserver::class);

        // UserObserver: membuat record UserNotificationPref otomatis
        // setiap kali user baru mendaftar.
        User::observe(UserObserver::class);

        // ─── Policies ────────────────────────────────────────────────────────────
        // Memetakan setiap Model ke Policy-nya agar $this->authorize()
        // di controller dapat bekerja dengan benar.
        Gate::policy(Application::class,         ApplicationPolicy::class);
        Gate::policy(ApplicationNote::class,     ApplicationNotePolicy::class);
        Gate::policy(ApplicationDocument::class, ApplicationDocumentPolicy::class);
        Gate::policy(Company::class,             CompanyPolicy::class);
        Gate::policy(CalendarEvent::class,       CalendarEventPolicy::class);
        Gate::policy(CareerGoal::class,          CareerGoalPolicy::class);
    }
}