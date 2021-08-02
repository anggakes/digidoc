<?php

namespace App\Listeners;

use App\Events\Notif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OneSignal;

class SendNotif
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
     * @param  Notif  $event
     * @return void
     */
    public function handle(Notif $event)
    {
        //



        OneSignal::sendNotificationToExternalUser(
            "Some Message",
            ["$event->docAct->user_id"],
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null
        );
    }
}
