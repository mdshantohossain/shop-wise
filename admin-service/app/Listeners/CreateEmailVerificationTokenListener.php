<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Models\EmailVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class CreateEmailVerificationTokenListener implements ShouldQueue
{
    public function handle(UserRegisteredEvent $event): void
    {
        EmailVerification::create([
            'user_id'    => $event->user->id,
            'token'      =>  Str::uuid(),
            'expires_at' => now()->addMinutes(30),
        ]);
    }
}
