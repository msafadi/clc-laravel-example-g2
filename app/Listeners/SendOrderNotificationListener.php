<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Mail\NewOrderMail;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderNotificationListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        //
        $order = $event->getOrder();
        $user_id = $order->user_id;
        $user = User::findOrFail($user_id);
        $email = $user->email;

        Mail::to($user)->send(new NewOrderMail($user->name, $order));
    }
}
