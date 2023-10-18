<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages=[
            1=>['slug'=>'en','name'=>'English','is_main'=>1],
            2=>['slug'=>'ar','name'=>'Arabic','is_main'=>0],
        ];
        $data=[];
        foreach($languages as $key=>$language){
            $row=[];
            $row['id']=$key;
            $row['name']=$language['name'];
            $row['slug']=$language['slug'];
            $row['is_main']=$language['is_main'];
            $data[]=$row;
        }
        DB::table('install_languages')->insert($data);
    }
}
