<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\InternshipApplication;
use App\Policies\AttendancePolicy;
use App\Policies\InternshipApplicationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Gate::policy(InternshipApplication::class, InternshipApplicationPolicy::class);
        Gate::policy(Attendance::class, AttendancePolicy::class);
    }
}
