<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeedeer extends Seeder
{
    private $admin_actions = [
        ['name' => 'project-update-any', 'label' => 'User can update any project']
    ];

    private $default_actions = [
        ['name' => 'project-create', 'label' => 'Create a project'],
        ['name' => 'project-update', 'label' => 'User can update own project']
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
