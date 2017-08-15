<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheRefresh
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
     * @param  CacheHit  $event
     * @return void
     */
    public function handle(CacheHit $event)
    {
        logger(json_encode($event));

        if($event->key == 'trabajos'){
            logger('tiro count a la tabla');
            logger($event->value->count());
            logger(json_encode($event));
        }
        
    }
}
