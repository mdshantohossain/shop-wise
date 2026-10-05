<?php

namespace App\Services;

use App\Models\User;
use App\Modules\Order\app\Models\Order;
use App\Notifications\NewOrderNotification;
use App\Notifications\PaymentNotification;

class NotificationService
{
    public function sendOrderPlacedNotification(Order $order): void
    {
        $users = User::permission('notification module')->get();

        foreach ($users as $user) {
            $user->notify(new NewOrderNotification($order));
        }
    }

    public function sendPaymentReceivedNotification(Order $order): void
    {
        $users = User::permission('notification module')->get();

        foreach ($users as $user) {
            $user->notify(new PaymentNotification($order));
        }
    }
}
