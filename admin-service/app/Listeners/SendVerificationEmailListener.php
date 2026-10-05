<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Models\EmailVerification;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(public MailService $mailService) {}

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $verificationUrl = config('app.frontend_url') . "/verify-email?token=" . $event->token;

        $this->mailService->verificationMail($event->user, $verificationUrl);
    }
}
