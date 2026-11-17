<?php

namespace App\Providers;

use App\Models\FloodReport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.petugas', function ($view): void {
            $pendingFloodReportsCount = FloodReport::query()
                ->whereIn('status', ['pending', 'needs_clarification'])
                ->count();

            $view->with('pendingFloodReportsCount', $pendingFloodReportsCount);
        });
    }
}
