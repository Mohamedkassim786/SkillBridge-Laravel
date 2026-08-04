<?php

namespace App\Domain\Auth\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class UserLoggedInEvent
{
    use Dispatchable;

    public function __construct(public User $user, public string $ipAddress) {}
}
