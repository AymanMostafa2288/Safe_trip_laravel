<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[
            1=>'insert',
            2=>'update',
            3=>'view',
            4=>'show',
            5=>'delete',
            6=>'translate',
            7=>'send_mail'
        ];
        $data=[];
        foreach($permissions as $key=>$permission){
            $row=[];
            $row['id']=$key;
            $row['name']=$permission;
            $row['note']=null;
            $data[]=$row;
        }
        DB::table('install_permissions')->insert($data);
    }
}
