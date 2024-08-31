<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
        Cache::forget('stats');

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
        Cache::forget('stats');

    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
        Cache::forget('stats');
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
        Cache::forget('stats');

    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
        Cache::forget('stats');

    }
}
