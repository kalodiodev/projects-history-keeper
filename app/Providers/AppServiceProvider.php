<?php

namespace App\Providers;

use App\Guide;
use App\Snippet;
use App\Project;
use App\Observers\GuideObserver;
use App\Observers\SnippetObserver;
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
        Snippet::observe(SnippetObserver::class);
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
