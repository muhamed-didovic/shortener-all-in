<?php

namespace App\Observers;

use App\Exceptions\CodeGenerationException;
use App\Link;
use Carbon\Carbon;

class LinkObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param Link $link
     * @return void
     * @throws CodeGenerationException
     */
    public function created(Link $link)
    {
        $link->update([
            'code' => $link->getCode(),
            'last_requested' => Carbon::now(),
        ]);
    }

//    public function created(Link $link)
//    {
//
//    }
}
