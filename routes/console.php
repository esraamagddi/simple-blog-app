<?php

use App\Jobs\DeleteOldSoftDeletedPosts;
use App\Jobs\LogRandomUserApiResponse;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Schedule::job(new DeleteOldSoftDeletedPosts)->daily();

Schedule::job(new LogRandomUserApiResponse)->everySixHours();



