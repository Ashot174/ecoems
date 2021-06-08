<?php

namespace App\Listeners;

use App\Events\NotifyNewUserCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailToNewUser
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
     * @param  NotifyNewUserCredentials  $event
     * @return void
     */
    public function handle(NotifyNewUserCredentials $event)
    {

    }
}
