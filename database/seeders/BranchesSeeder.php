<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('install_branches')->insert([
            'id' => 1,
            'name' => 'Main Branch',
            'phone' => null,
            'address' => 'Main Branch',
            'note' => null,
        ]);
    }
}
