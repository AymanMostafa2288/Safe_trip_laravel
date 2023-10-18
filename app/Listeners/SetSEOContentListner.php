<?php

namespace App\Listeners;

use App\Events\SetRelationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SetSEOContentListner
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

        $request=$event->data;
        dd($request);
        DB::table('osoule_seo_content')->insert($request);
        /*
        if(in_array($event->table,['osoule_blogs','osoule_property','osoule_project'])){

            $row=[
                [
                    'title'=>$event->data->id,
                    'content'=>$event->data->description,
                    'keywords'=>null,
                    'element_id'=>$event->data->id,
                    'slug'=>$event->data->name,
                    'element'=>$event->table,
                    'element_id'=>$event->data->id,
                    'sitemap'=>0
                ]
            ];
            DB::table('osoule_seo_content')->where('element',$event->table)->where('element_id',$event->data->id)->delete();
            DB::table('osoule_seo_content')->insert($row);
        }
        */
    }
}
