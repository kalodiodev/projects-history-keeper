<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions
        DB::table('statuses')->insert([
            ['title' => 'Active', 'color' => 'green'],
            ['title' => 'Inactive', 'color' => 'orange']
        ]);
    }
}
