<?php

namespace Modules\Api\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[Red Medial] Reset Password')
            ->greeting("Hello, {$notifiable->name}!")
            ->line("Your new password: **{$this->password}**.")
            ->line('You could change it in profile settings in your mobile.');
    }
}
