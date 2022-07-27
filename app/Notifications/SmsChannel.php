<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('sms');

        if (! $to) {
            $to = $notifiable->routeNotificationFor(SmsChannel::class);
        }

        if (! $to) {
            return;
        }
        $message = $notification->toSms($notifiable);

        $key = '25FCB50F731D59';
        $senderid = 'SJSMTH';
        $routeid = 17;
        $apiUrl = "http://sms.hitechsms.com/app/smsapi/index.php?key=$key&campaign=0&routeid=$routeid&type=text&contacts=$to&senderid=$senderid&msg=".urlencode($message);
        $resp = Http::get($apiUrl);
    }
}
