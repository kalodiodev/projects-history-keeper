<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeedeer extends Seeder
{
    private $admin_actions = [
        // Project
        ['name' => 'project-update-any', 'label' => 'User can update any project'],
        ['name' => 'project-delete-any', 'label' => 'User can delete any project'],
        ['name' => 'project-view-any', 'label' => 'User can view any project'],

        // Task
        ['name' => 'task-create-any', 'label' => 'User can create a task to any project'],
        ['name' => 'task-update-any', 'label' => 'User can update any task'],
        ['name' => 'task-delete-any', 'label' => 'User can delete any task'],

        // Tag
        ['name' => 'tag-create', 'label' => 'User can create a tag'],
        ['name' => 'tag-view', 'label' => 'User can view a tag']
    ];

    private $default_actions = [
        // Project
        ['name' => 'project-create', 'label' => 'Create a project'],
        ['name' => 'project-update', 'label' => 'User can update own project'],
        ['name' => 'project-delete', 'label' => 'User can delete own project'],
        ['name' => 'project-view', 'label' => 'User can view own project'],

        // Task
        ['name' => 'task-create', 'label' => 'User can create a task to a project he/she created'],
        ['name' => 'task-update', 'label' => 'User can update own task'],
        ['name' => 'task-delete', 'label' => 'User can delete own task']
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
