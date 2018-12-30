<?php

namespace App\Providers;

use App\Tag;
use App\Role;
use App\User;
use App\Task;
use App\Guide;
use App\Status;
use App\Snippet;
use App\Project;
use App\Comment;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use App\Policies\TaskPolicy;
use App\Policies\RolePolicy;
use App\Policies\GuidePolicy;
use App\Policies\StatusPolicy;
use App\Policies\CommentPolicy;
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
        Role::class    => RolePolicy::class,
        Status::class  => StatusPolicy::class,
        Comment::class => CommentPolicy::class,
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
