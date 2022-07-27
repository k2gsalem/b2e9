<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralInvite extends Notification
{
    use Queueable;

    protected $referrer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $referrer)
    {
        $this->referrer = $referrer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->referrer->name.' has been invited you to '.config('app.name'))
                    ->action('Join Now', route('register').'?referral_code='.$this->referrer->referral_code);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms($notifiable): string
    {
        return $this->referrer->name.' has been invited you to '.config('app.name').'. '.route('register').'?referral_code='.$this->referrer->referral_code;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
