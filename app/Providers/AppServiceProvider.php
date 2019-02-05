<?php

namespace App\Providers;

use App\Guide;
use App\Project;
use App\Observers\GuideObserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Project::observe(ProjectObserver::class);
        Guide::observe(GuideObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
