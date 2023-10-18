<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('install_notifications')->insert([
            'id' => '1',
            'name' => 'Contact Us',
            'icon' => NULL,
            'table_db' => 'install_contacts',
            'field_name' => 'show_status',
            'field_value' => 'new',
            'message' => 'Contact Us',
            'is_active' => '1',
            'type' => 'badge',
            'created_at' => '2023-04-10 11:32:57',
        ]);

    }
}
