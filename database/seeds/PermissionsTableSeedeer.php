<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeedeer extends Seeder
{
    private $actions = [
        ['name' => 'project-create', 'label' => 'Create a project']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert($this->actions);
    }
}
