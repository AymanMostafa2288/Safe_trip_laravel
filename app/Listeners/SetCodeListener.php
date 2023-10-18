<?php

namespace App\Listeners;

use App\Events\SetCodeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SetCodeListener
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
     * @param  SetCodeEvent  $event
     * @return void
     */
    public function handle(SetCodeEvent $event)
    {

    }
}
