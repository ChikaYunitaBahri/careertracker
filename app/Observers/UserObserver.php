<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserNotificationPref;

class UserObserver
{
    public function created(User $user): void
    {
        UserNotificationPref::create(['user_id' => $user->id]);
    }
}