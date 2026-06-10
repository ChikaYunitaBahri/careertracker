<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationDocumentController;
use App\Http\Controllers\ApplicationNoteController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CareerGoalController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GoalMilestoneController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserNotificationPrefController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ── Dashboard ────────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ── Applications ─────────────────────────────────────────────────────
    // Full resource (index, create, store, show, edit, update, destroy)
    Route::resource('applications', ApplicationController::class);

    // Nested: Notes & Documents
    Route::prefix('applications/{application}')->name('applications.')->group(function () {

        Route::resource('notes', ApplicationNoteController::class)
            ->only(['store', 'update', 'destroy']);

        Route::resource('documents', ApplicationDocumentController::class)
            ->only(['store', 'destroy']);

        Route::get('documents/{document}/download', [ApplicationDocumentController::class, 'download'])
            ->name('documents.download');
    });

    // ── Companies ────────────────────────────────────────────────────────
    Route::resource('companies', CompanyController::class);

    Route::prefix('companies/{company}')->name('companies.')->group(function () {
        Route::resource('contacts', CompanyContactController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->names([
                'create' => 'contacts.create',
                'store' => 'contacts.store',
                'edit' => 'contacts.edit',
                'update' => 'contacts.update',
                'destroy' => 'contacts.destroy',
            ]);
    });

    // ── Calendar Events ──────────────────────────────────────────────────
    Route::resource('calendar-events', CalendarEventController::class)
        ->except(['create', 'edit']);

    // ── Career Goals ─────────────────────────────────────────────────────
    Route::resource('career-goals', CareerGoalController::class)
        ->except(['create', 'edit']);

    Route::prefix('career-goals/{goal}')->name('career-goals.')->group(function () {
        Route::resource('milestones', GoalMilestoneController::class)
            ->only(['store', 'update', 'destroy']);
    });

    // ── Notifications ────────────────────────────────────────────────────
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',              [NotificationController::class, 'index'])       ->name('index');
        Route::patch('{id}/read',    [NotificationController::class, 'markAsRead'])  ->name('read');
        Route::post('read-all',      [NotificationController::class, 'markAllRead']) ->name('read-all');
    });

    // ── Notification Preferences ─────────────────────────────────────────
    Route::singleton('notification-prefs', UserNotificationPrefController::class)
        ->only(['show', 'update']);

    // ── Profile ──────────────────────────────────────────────────────────
    Route::get('/profile',    [ProfileController::class, 'edit'])    ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])  ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy']) ->name('profile.destroy');

});

require __DIR__.'/auth.php';
