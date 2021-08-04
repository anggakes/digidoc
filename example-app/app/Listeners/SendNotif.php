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

        $users = [
            "elet-".$event->docAct->user_id
        ];

        OneSignal::sendNotificationToExternalUser(
            "Dokumen ".$event->docAct->document->title." perlu ".$event->docAct->action_need." Anda",
            $users,
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null
        );
    }
}
