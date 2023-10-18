<?php

namespace App\Listeners;

use App\Events\CreateTranslationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Interfaces\setting_management\LanguageInterface;

class StoreTranslateListener
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
     * @param  CreateTranslationEvent  $event
     * @return void
     */
    public function handle(CreateTranslationEvent $event)
    {

        app(LanguageInterface::class)->translate_content($event->table,$event->data);
    }
}
