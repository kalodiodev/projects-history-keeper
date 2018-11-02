<?php

namespace App\Providers;

use App\Role;
use App\Tag;
use App\User;
use App\Task;
use App\Guide;
use App\Snippet;
use App\Project;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use App\Policies\TaskPolicy;
use App\Policies\RolePolicy;
use App\Policies\GuidePolicy;
use App\Policies\SnippetPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Task::class    => TaskPolicy::class,
        Tag::class     => TagPolicy::class,
        User::class    => UserPolicy::class,
        Guide::class   => GuidePolicy::class,
        Snippet::class => SnippetPolicy::class,
        Role::class    => RolePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
