<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    private $admin_actions = [
        // User
        ['name' => 'user-invite', 'label' => 'User can invite a new user'],
        ['name' => 'user-edit', 'label' => 'User can edit a user'],
        ['name' => 'user-delete', 'label' => 'User can delete a user'],

        // Project
        ['name' => 'project-update-any', 'label' => 'User can update any project'],
        ['name' => 'project-delete-any', 'label' => 'User can delete any project'],
        ['name' => 'project-view-any', 'label' => 'User can view any project'],

        // Project Image
        ['name' => 'image-store-any-project', 'label' => 'User can upload image to any project'],

        // Task
        ['name' => 'task-create-any', 'label' => 'User can create a task to any project'],
        ['name' => 'task-update-any', 'label' => 'User can update any task'],
        ['name' => 'task-delete-any', 'label' => 'User can delete any task'],

        // Tag
        ['name' => 'tag-create', 'label' => 'User can create a tag'],
        ['name' => 'tag-update', 'label' => 'User can update a tag'],
        ['name' => 'tag-delete', 'label' => 'User can delete a tag'],

        // Guide
        ['name' => 'guide-view-any', 'label' => 'User can view any guide'],
        ['name' => 'guide-update-any', 'label' => 'User can update any guide'],
        ['name' => 'guide-delete-any', 'label' => 'User can delete any guide'],

        // Snippet
        ['name' => 'snippet-view-any', 'label' => 'User can view any snippet'],
        ['name' => 'snippet-update-any', 'label' => 'User can update any snippet'],
        ['name' => 'snippet-delete-any', 'label' => 'User can delete any snippet'],

        // Role
        ['name' => 'role-view', 'label' => 'User can view a role'],
        ['name' => 'role-create', 'label' => 'User can create a role'],
        ['name' => 'role-update', 'label' => 'User can update a role'],
        ['name' => 'role-delete', 'label' => 'User can delete a role'],

        // Status
        ['name' => 'status-create', 'label' => 'User can create status'],
        ['name' => 'status-update', 'label' => 'User can update status'],
        ['name' => 'status-delete', 'label' => 'User can delete status'],

        // Comment
        ['name' => 'comment-update', 'label' => 'User can update comment'],
        ['name' => 'comment-delete', 'label' => 'User can delete comment'],
    ];

    private $default_actions = [
        // Project
        ['name' => 'project-create', 'label' => 'User can create a project'],
        ['name' => 'project-update', 'label' => 'User can update own project'],
        ['name' => 'project-delete', 'label' => 'User can delete own project'],

        // Task
        ['name' => 'task-create', 'label' => 'User can create a task to a project he/she created'],
        ['name' => 'task-update', 'label' => 'User can update own task'],
        ['name' => 'task-delete', 'label' => 'User can delete own task'],

        // Guide
        ['name' => 'guide-create', 'label' => 'User can create a guide'],
        ['name' => 'guide-update', 'label' => 'User can update own guide'],
        ['name' => 'guide-delete', 'label' => 'User can delete own guide'],

        // Snippet
        ['name' => 'snippet-create', 'label' => 'User can create a snippet'],
        ['name' => 'snippet-update', 'label' => 'User can update own snippet'],
        ['name' => 'snippet-delete', 'label' => 'User can delete own snippet'],

        // Profile
        ['name' => 'profile-view', 'label' => 'User can view users profile'],

        // Comment
        ['name' => 'comment-create', 'label' => 'User can post comments'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions
        DB::table('permissions')->insert($this->admin_actions);
        DB::table('permissions')->insert($this->default_actions);

        // Admin permissions
        $admin = Role::whereName('admin')->firstOrFail();
        $admin->grantPermissions($this->admin_actions);
        $admin->grantPermissions($this->default_actions);

        // Default permissions
        $default = Role::whereName('default')->firstOrFail();
        $default->grantPermissions($this->default_actions);
    }
}
