<?php

namespace App\Services;

use App\Mail\OrderDeliveredMail;
use App\Mail\OrderPlacedMail;
use App\Mail\ResetPasswordMail;
use App\Mail\VerificationMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Modules\Order\app\Models\Order;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * welcome email to user after verification
     *
     * @param User $user
     * @return void
     */
    public function welcomeMail(User $user): void
    {
        Mail::to($user['email'])->queue(new WelcomeMail($user['name']));
    }

    /**
     * order placed mail with order inform
     *
     * @param Order $order
     * @return void
     */
    public function orderPlacedMail(Order $order): void
    {
        Mail::to($order->user->email)->queue(new OrderPlacedMail($order));
    }

    public function orderDeliveredMail(Order $order): void
    {
        Mail::to($order->user->email)->queue(new OrderDeliveredMail($order));
    }

    /**
     * verification email after registration
     *
     * @param User $user
     * @param string $verificationUrl
     * @return void
     */
    public function verificationMail(User $user, string $verificationUrl): void
    {
        Mail::to($user['email'])->queue(new VerificationMail($user, $verificationUrl));
    }

    /**
     * reset password link mail to requested user
     *
     * @param User $user
     * @param string $url
     * @return void
     */
    public function resetPasswordMail(User $user, string $url): void
    {
        Mail::to($user['email'])->queue(new ResetPasswordMail($user, $url));
    }
}
