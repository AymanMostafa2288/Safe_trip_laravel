<?php

namespace App\Listeners;

use App\Events\CreateSlugEvent;
use App\Models\Seo;
use App\Models\Slugable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class StoreSlugDBListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateSlugEvent  $event
     * @return void
     */
    public function handle(CreateSlugEvent $event)
    {


        $main_table_db=$event->table;
        $request=$event->data;
        $key=$event->key;
        $section=$event->section;
        $check_if_edit=Slugable::where('row_id',$request['id'])->where('table_name',$main_table_db)->first();
        if($check_if_edit){
            $slug=$section.'/'.str_replace(' ', '-',strtolower($request[$key]));
            $exist=Slugable::where('slug',$slug)->where('id','!=',$check_if_edit->id)->get();

            if(count($exist) > 0){

                $slug=$slug.'-'.count($exist)+1;
            }
            Slugable::where('id',$check_if_edit->id)->update([
                'slug'=>$slug,
            ]);
        }else{
            $slug=$section.'/'.str_replace(' ', '-',strtolower($request[$key]));
            $exist=Slugable::where('slug',$slug)->get();
            if(count($exist) > 0){
                $slug=$slug.'-'.count($exist)+1;
            }
            Slugable::create([
                'slug'=>$slug,
                'table_name'=>$main_table_db,
                'row_id'=>$request['id'],
                'in_sitemap'=>1
            ]);
        }
        $urls=[];
        $urls[]=env('APP_URL').$slug;
        $urls[]=env('APP_URL').'en/'.$slug;
        foreach($urls as $url){
            Seo::updateOrCreate(
                [
                    'url'=>$url
                ],
                [
                    'url'=>$url,
                    'meta_title'=>$request[$key],
                    'web_h1'=>$request[$key],
                    'meta_canonical'=>$url,
                ]
            );
        }




        return true;
    }
}
