<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderPlacedEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public MailService $mailService){}

    /**
     * Handle the event.
     */
    public function handle(OrderPlacedEvent $event): void
    {
        $this->mailService->orderPlacedMail($event->order);
    }
}
