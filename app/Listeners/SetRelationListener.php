<?php

namespace App\Listeners;

use App\Events\SetRelationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SetRelationListener
{
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  SetRelationEvent  $event
     * @return void
     */
    public function handle(SetRelationEvent $event)
    {
        $main_table_db=$event->table;
        $request=$event->data;
        $id=$event->id;
        // $lang=$event->id;
        $relations=checkCrud('',$main_table_db);
        
        if($relations!==false){
            foreach($relations as $relation){
                $insert_table=$relation->table_db;
                foreach($relation->fields as $field){
                    if($field->related_with!='' && $field->related_with==$main_table_db){
                        $main_field=$field->name;
                        continue;
                    }
                    if($field->related_with!=''){
                        $another_field=$field->name;
                        continue;
                    }
                }
                $rows=[];
                foreach($request[$another_field] as $value){
                    $rows[]=[$main_field=>$id,$another_field=>$value];
                }
                DB::table($insert_table)->where($main_field,$id)->delete();
                DB::table($insert_table)->insert($rows);
            }
        }
    }
}
