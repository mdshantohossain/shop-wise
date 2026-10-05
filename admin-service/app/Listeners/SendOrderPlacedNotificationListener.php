<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderPlacedNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public NotificationService $notificationService){}

    /**
     * Handle the event.
     */
    public function handle(OrderPlacedEvent $event): void
    {
        // notification
        $this->notificationService->sendOrderPlacedNotification($event->order);
    }
}
