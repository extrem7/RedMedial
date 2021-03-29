<?php

namespace Modules\Frontend\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class AssistanceRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'New assistance request';

    private MailMessage $message;

    public function __construct(User $user)
    {
        $this->message = (new MailMessage)
            ->greeting("Hello, you have new assistance request from '{$user->name}' with id {$user->id}.")
            ->salutation(null);
    }

    public function build(): self
    {
        return $this->markdown('vendor.notifications.email', $this->message->data());
    }
}
