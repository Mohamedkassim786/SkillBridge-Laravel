<?php

namespace App\Domain\Auth\Listeners;

use App\Domain\Auth\Events\UserRegisteredEvent;
use Illuminate\Auth\Events\Registered;

class SendEmailVerificationListener
{
    public function handle(UserRegisteredEvent $event): void
    {
        event(new Registered($event->user));
    }
}
