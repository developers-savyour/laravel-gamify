<?php

namespace QCod\Gamify\Listeners;

use QCod\Gamify\Events\ReputationChanged;

class SyncLevels
{
    /**
     * Handle the event.
     *
     * @param  ReputationChanged  $event
     * @return void
     */
    public function handle(ReputationChanged $event)
    {
        $event->user->syncLevels();
    }
}
