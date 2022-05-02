<?php

namespace App\Listeners;

use App\Mail\VerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail
{
    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user)->send(new VerificationEmail($event->user));
    }
}
