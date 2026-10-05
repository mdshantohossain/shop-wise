<?php

namespace App\Listeners;

use App\Events\OrderDeliveredEvent;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDeliveredEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public MailService $mailService){}

    /**
     * Handle the event.
     */
    public function handle(OrderDeliveredEvent $event): void
    {
        $this->mailService->orderDeliveredMail($event->order);

    }
}
