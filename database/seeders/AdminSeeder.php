<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('install_admins')->insert([
            'id' =>1,
            'first_name' => Str::lower(env('APP_NAME')),
            'last_name' => 'Admin',
            'username' => Str::lower(env('APP_NAME')).'_'.'Admin',
            'password' => Hash::make('123123123'),
            'email' => 'admin@'.Str::lower(env('APP_NAME')).'.com',
            'type' => 'manger',
            'is_developer' => 1,
            'is_active' => 1,
            'role_id' => 1,
            'branch_id' => 1,
            'specific_permissions' => null,
        ]);
    }
}
