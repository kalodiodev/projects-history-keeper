<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    private $roles = [
        ['name' => 'admin', 'label' => 'Administrator'],
        ['user' => 'user', 'label' => 'User']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert($this->roles);
    }
}
